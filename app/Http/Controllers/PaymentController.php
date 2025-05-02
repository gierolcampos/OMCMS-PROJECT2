<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\NonIcsMember;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            // Admin view
            $query = Order::with(['user', 'nonIcsMember']);

            // Apply search filter
            if (request('search')) {
                $query->where(function($q) {
                    $q->where('id', 'like', '%' . request('search') . '%')
                      ->orWhere('email', 'like', '%' . request('search') . '%')
                      ->orWhereHas('user', function($q) {
                          $q->where('firstname', 'like', '%' . request('search') . '%')
                            ->orWhere('lastname', 'like', '%' . request('search') . '%')
                            ->orWhere('email', 'like', '%' . request('search') . '%');
                      })
                      ->orWhereHas('nonIcsMember', function($q) {
                          $q->where('fullname', 'like', '%' . request('search') . '%')
                            ->orWhere('email', 'like', '%' . request('search') . '%');
                      });
                });
            }

            // Apply payment method filter
            if (request('payment_method')) {
                $query->where('method', request('payment_method'));
            }

            // Apply status filter
            if (request('status')) {
                $query->where('payment_status', request('status'));
            }

            $payments = $query->orderBy('created_at', 'desc')->paginate(10);

            // Get non-ICS members data directly from the non_ics_members table
            $nonIcsQuery = NonIcsMember::query();

            // Apply search filter for non-ICS members
            if (request('search')) {
                $nonIcsQuery->where(function($q) {
                    $q->where('id', 'like', '%' . request('search') . '%')
                      ->orWhere('email', 'like', '%' . request('search') . '%')
                      ->orWhere('fullname', 'like', '%' . request('search') . '%');
                });
            }

            // Apply payment method filter for non-ICS members
            if (request('payment_method')) {
                $nonIcsQuery->where('method', request('payment_method'));
            }

            // Apply status filter for non-ICS members
            if (request('status')) {
                $nonIcsQuery->where('payment_status', request('status'));
            }

            $nonIcsMembers = $nonIcsQuery->orderBy('created_at', 'desc')->paginate(10);

            // Calculate statistics
            $statsQuery = Order::query();

            $totalPayments = $statsQuery->clone()->where('payment_status', 'Paid')->sum('total_price');
            $thisMonthPayments = $statsQuery->clone()
                ->where('payment_status', 'Paid')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_price');
            $pendingPayments = $statsQuery->clone()->where('payment_status', 'Pending')->sum('total_price');
            $rejectedPayments = $statsQuery->clone()->where('payment_status', 'Rejected')->sum('total_price');

            // Add non-ICS members statistics
            $totalPayments += NonIcsMember::where('payment_status', 'Paid')->sum('total_price');
            $thisMonthPayments += NonIcsMember::where('payment_status', 'Paid')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_price');
            $pendingPayments += NonIcsMember::where('payment_status', 'Pending')->sum('total_price');
            $rejectedPayments += NonIcsMember::where('payment_status', 'Failed')->orWhere('payment_status', 'Rejected')->sum('total_price');

            return view('payments.index', compact(
                'payments',
                'nonIcsMembers',
                'totalPayments',
                'thisMonthPayments',
                'pendingPayments',
                'rejectedPayments'
            ));
        } else {
            // Client view
            $query = Order::where('user_id', $user->id);

            // Apply search filter
            if (request('search')) {
                $query->where('id', 'like', '%' . request('search') . '%');
            }

            // Apply status filter
            if (request('payment_status')) {
                $query->where('payment_status', request('payment_status'));
            }

            $payments = $query->orderBy('created_at', 'desc')->paginate(10);

            return view('payments.client', compact('payments'));
        }
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $admin = Auth::user();

        // Restrict payment creation to admin users only
        if (!$admin->is_admin) {
            return redirect()->route('client.payments.index')
                ->with('error', 'You do not have permission to create payments.');
        }

        // For admins, fetch all active members
        $users = User::where('status', 'active')
                    ->where('is_admin', false)
                    ->select('id', 'firstname', 'lastname', 'middlename', 'suffix', 'email')
                    ->orderBy('lastname')
                    ->orderBy('firstname')
                    ->get()
                    ->map(function ($user) {
                        $user->fullname = trim(implode(' ', array_filter([
                            $user->firstname,
                            $user->middlename,
                            $user->lastname,
                            $user->suffix
                        ])));
                        return $user;
                    });

        // Fetch all admin users for officer selection
        $officers = User::where('is_admin', true)
                    ->select('id', 'firstname', 'lastname', 'middlename', 'suffix', 'email')
                    ->orderBy('lastname')
                    ->orderBy('firstname')
                    ->get()
                    ->map(function ($user) {
                        $user->fullname = trim(implode(' ', array_filter([
                            $user->firstname,
                            $user->middlename,
                            $user->lastname,
                            $user->suffix
                        ])));
                        return $user;
                    });

        // Get the current admin's full name
        $adminName = trim(implode(' ', array_filter([
            $admin->firstname,
            $admin->middlename,
            $admin->lastname,
            $admin->suffix
        ])));

        return view('payments.create', compact('users', 'officers', 'adminName'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        // Restrict payment creation to admin users only
        if (!auth()->user()->is_admin) {
            return redirect()->route('client.payments.index')
                ->with('error', 'You do not have permission to create payments.');
        }

        try {
            // Check if this is a non-ICS payment submission
            $isNonIcsPayment = $request->has('non_ics_payment') && $request->non_ics_payment == 1;
            \Log::info('Payment submission type:', ['is_non_ics_payment' => $isNonIcsPayment]);

            // Process payment data

            // Simplify validation rules
            $rules = [
                'total_price' => 'required|numeric|min:0',
                'payment_method' => 'required|string|in:CASH,GCASH',
                'payment_status' => 'required|string|in:Paid,Pending,Failed,Refunded',
                'purpose' => 'required|string',
                'description' => 'nullable|string',
                'payer_type' => 'required|string|in:ics_member,non_ics_member',
            ];

            // Add payment method specific rules
            if ($request->payment_method === 'GCASH') {
                $rules['gcash_name'] = 'required|string';
                $rules['gcash_num'] = 'required|string';
                $rules['reference_number'] = 'required|string';
                $rules['gcash_proof_of_payment'] = 'required|file|mimes:jpg,jpeg|max:2048';
            } else if ($request->payment_method === 'CASH') {
                $rules['officer_in_charge'] = 'required|string';
                $rules['receipt_control_number'] = 'required|integer';
                $rules['cash_proof_of_payment'] = 'required|file|mimes:jpg,jpeg|max:2048';
            }

            // Add payer type specific rules
            if ($request->payer_type === 'ics_member') {
                $rules['user_email'] = 'required|email|exists:users,email';
            } else if ($request->payer_type === 'non_ics_member') {
                // For non-ICS members, user_email should not be required
                $rules['user_email'] = 'nullable'; // Make it nullable instead of required

                // Basic Non-ICS member fields
                $rules['non_ics_email'] = 'required|email';
                $rules['non_ics_fullname'] = 'required|string|max:100';
                $rules['course_year_section'] = 'required|string|max:50';
                $rules['non_ics_mobile'] = 'nullable|string|max:20';

                \Log::info('Using non-ICS member validation rules', [
                    'has_user_email' => $request->has('user_email'),
                    'user_email_value' => $request->input('user_email')
                ]);

                // Additional Non-ICS member fields
                $rules['student_id'] = 'nullable|string|max:50';
                $rules['payment_status'] = 'nullable|string|in:None,Pending,Paid';
            }



            $messages = [
                'officer_in_charge.required' => 'The officer in charge field is required when payment method is CASH.',
                'receipt_control_number.required' => 'The receipt control number field is required when payment method is CASH.',
                'receipt_control_number.integer' => 'The receipt control number must be an integer.',
                'purpose.required' => 'The purpose field is required.',
                'gcash_proof_of_payment.required' => 'The proof of payment is required when payment method is GCASH.',
                'gcash_proof_of_payment.mimes' => 'The proof of payment must be a JPG file.',
                'cash_proof_of_payment.required' => 'The proof of payment is required when payment method is CASH.',
                'cash_proof_of_payment.mimes' => 'The proof of payment must be a JPG file.',
                'payer_type.required' => 'The payer type field is required.',
                'non_ics_email.required' => 'The NPC email field is required for non-ICS members.',
                'non_ics_email.email' => 'The NPC email must be a valid email address.',
                'non_ics_fullname.required' => 'The full name field is required for non-ICS members.',
                'course_year_section.required' => 'The course, year & section field is required for non-ICS members.',
            ];

            $validated = $request->validate($rules, $messages);

            // Get the user or non-ICS member based on the payer type
            $user = null;
            $nonIcsMember = null;

            if ($validated['payer_type'] === 'ics_member') {
                // For ICS members, get the user from the database
                $user = User::where('email', $validated['user_email'])->firstOrFail();
                \Log::info('ICS Member selected:', ['user_id' => $user->id, 'email' => $user->email]);
            } else if ($validated['payer_type'] === 'non_ics_member') {
                // For non-ICS members, find or create a record in the non_ics_members table
                try {
                    \Log::info('Non-ICS Member selected, checking database');

                    // Check if the non-ICS member already exists
                    $existingMember = NonIcsMember::where('email', $validated['non_ics_email'])->first();

                    if ($existingMember) {
                        $nonIcsMember = $existingMember;
                        \Log::info('Existing Non-ICS Member found:', ['id' => $nonIcsMember->id, 'email' => $nonIcsMember->email]);

                        // Update the existing member with the new data
                        $nonIcsMember->fullname = $validated['non_ics_fullname'];
                        $nonIcsMember->course_year_section = $validated['course_year_section'];
                        $nonIcsMember->mobile_no = $validated['non_ics_mobile'] ?? null;
                        $nonIcsMember->purpose = $validated['purpose'] ?? null;
                        $nonIcsMember->total_price = $validated['total_price'] ?? null;
                        $nonIcsMember->method = $validated['payment_method'];
                        $nonIcsMember->description = $validated['description'] ?? null;
                        $nonIcsMember->placed_on = now();

                        // Update payment method specific fields
                        if ($validated['payment_method'] === 'CASH') {
                            $nonIcsMember->receipt_control_number = $validated['receipt_control_number'] ?? null;
                            // Cash proof path will be set later after file upload
                        } else if ($validated['payment_method'] === 'GCASH') {
                            $nonIcsMember->gcash_name = $validated['gcash_name'] ?? null;
                            $nonIcsMember->gcash_num = $validated['gcash_num'] ?? null;
                            $nonIcsMember->reference_number = $validated['reference_number'] ?? null;
                            // GCash proof path will be set later after file upload
                        }

                        // Update additional fields if they exist in the request
                        if (isset($validated['student_id'])) $nonIcsMember->student_id = $validated['student_id'];
                        if (isset($validated['payment_status'])) $nonIcsMember->payment_status = $validated['payment_status'];

                        $nonIcsMember->save();
                        \Log::info('Existing Non-ICS Member updated');
                    } else {
                        \Log::info('Creating new Non-ICS Member record');
                        // Prepare data for NonIcsMember creation
                        $nonIcsMemberData = [
                            'email' => $validated['non_ics_email'],
                            'fullname' => $validated['non_ics_fullname'],
                            'course_year_section' => $validated['course_year_section'],
                            'mobile_no' => $validated['non_ics_mobile'] ?? null,
                            'student_id' => $validated['student_id'] ?? null,
                            'payment_status' => $validated['payment_status'] ?? 'None',
                            'purpose' => $validated['purpose'] ?? null,
                            'total_price' => $validated['total_price'] ?? null,
                            'method' => $validated['payment_method'],
                            'description' => $validated['description'] ?? null,
                            'placed_on' => now()
                        ];

                        // Add payment method specific fields
                        if ($validated['payment_method'] === 'CASH') {
                            $nonIcsMemberData['receipt_control_number'] = $validated['receipt_control_number'] ?? null;
                            // Cash proof path will be set later after file upload
                        } else if ($validated['payment_method'] === 'GCASH') {
                            $nonIcsMemberData['gcash_name'] = $validated['gcash_name'] ?? null;
                            $nonIcsMemberData['gcash_num'] = $validated['gcash_num'] ?? null;
                            $nonIcsMemberData['reference_number'] = $validated['reference_number'] ?? null;
                            // GCash proof path will be set later after file upload
                        }

                        // Use the create method to ensure proper model creation
                        $nonIcsMember = NonIcsMember::create($nonIcsMemberData);
                        \Log::info('New Non-ICS Member created:', ['id' => $nonIcsMember->id, 'email' => $nonIcsMember->email]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Error processing Non-ICS Member:', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'data' => $validated
                    ]);
                    throw $e;
                }
            } else {
                throw new \Exception('Invalid payer type: ' . $validated['payer_type']);
            }

            // GCash amount validation removed

            // Handle file uploads
            $gcashProofPath = null;
            $cashProofPath = null;

            if ($request->hasFile('gcash_proof_of_payment') && $validated['payment_method'] === 'GCASH') {
                $gcashProofFile = $request->file('gcash_proof_of_payment');
                $gcashProofPath = 'proofs/gcash_' . time() . '_' . $gcashProofFile->getClientOriginalName();
                $gcashProofFile->move(public_path('proofs'), $gcashProofPath);

                // Update the NonIcsMember record with the proof path if it's a non-ICS member
                if ($validated['payer_type'] === 'non_ics_member' && $nonIcsMember) {
                    $nonIcsMember->gcash_proof_path = $gcashProofPath;
                    $nonIcsMember->save();
                    \Log::info('Updated NonIcsMember with GCash proof path', [
                        'id' => $nonIcsMember->id,
                        'gcash_proof_path' => $gcashProofPath
                    ]);
                }
            }

            if ($request->hasFile('cash_proof_of_payment') && $validated['payment_method'] === 'CASH') {
                $cashProofFile = $request->file('cash_proof_of_payment');
                $cashProofPath = 'proofs/cash_' . time() . '_' . $cashProofFile->getClientOriginalName();
                $cashProofFile->move(public_path('proofs'), $cashProofPath);

                // Update the NonIcsMember record with the proof path if it's a non-ICS member
                if ($validated['payer_type'] === 'non_ics_member' && $nonIcsMember) {
                    $nonIcsMember->cash_proof_path = $cashProofPath;
                    $nonIcsMember->save();
                    \Log::info('Updated NonIcsMember with Cash proof path', [
                        'id' => $nonIcsMember->id,
                        'cash_proof_path' => $cashProofPath
                    ]);
                }
            }

            // Create the payment record
            try {
                $orderData = [
                    'method' => $validated['payment_method'],
                    'total_price' => $validated['total_price'],
                    'purpose' => $validated['purpose'],
                    'description' => $validated['description'] ?? null,
                    // GCash details
                    'gcash_name' => $validated['gcash_name'] ?? null,
                    'gcash_num' => $validated['gcash_num'] ?? null,
                    'reference_number' => $validated['reference_number'] ?? null,
                    'gcash_proof_path' => $gcashProofPath,
                    'gcash_amount' => null, // Set to null explicitly
                    // Cash details
                    'officer_in_charge' => $validated['officer_in_charge'] ?? null,
                    'receipt_control_number' => $validated['receipt_control_number'] ?? null,
                    'cash_proof_path' => $cashProofPath,
                    'placed_on' => now()->format('Y-m-d H:i:s'),
                    'payment_status' => $validated['payment_status']
                ];

                // Add user or non-ICS member details
                if ($validated['payer_type'] === 'ics_member') {
                    $orderData['user_id'] = $user->id;
                    $orderData['is_non_ics_member'] = false;
                    $orderData['non_ics_member_id'] = null; // Explicitly set to null
                    $orderData['email'] = $user->email; // Set email from user

                    \Log::info('Creating payment for ICS Member:', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->firstname . ' ' . $user->lastname
                    ]);
                } else if ($validated['payer_type'] === 'non_ics_member') {
                    // For non-ICS members, ensure we have a valid non_ics_member_id
                    if (!$nonIcsMember || !$nonIcsMember->id) {
                        throw new \Exception('Failed to create or find Non-ICS member record');
                    }

                    $orderData['user_id'] = null; // Explicitly set to null
                    $orderData['non_ics_member_id'] = $nonIcsMember->id;
                    $orderData['email'] = $nonIcsMember->email;
                    $orderData['course_year_section'] = $nonIcsMember->course_year_section;
                    $orderData['is_non_ics_member'] = true;

                    \Log::info('Creating payment for Non-ICS Member:', [
                        'non_ics_member_id' => $nonIcsMember->id,
                        'email' => $nonIcsMember->email,
                        'fullname' => $nonIcsMember->fullname,
                        'course_year_section' => $nonIcsMember->course_year_section,
                        'mobile_no' => $nonIcsMember->mobile_no,
                        'student_id' => $nonIcsMember->student_id,
                        'payment_status' => $nonIcsMember->payment_status
                    ]);
                } else {
                    throw new \Exception('Invalid payer type: ' . $validated['payer_type']);
                }
            } catch (\Exception $e) {
                throw $e;
            }

            try {
                // Check if this is a non-ICS payment submission
                if ($isNonIcsPayment && $validated['payer_type'] === 'non_ics_member' && $nonIcsMember) {
                    \Log::info('Processing as Non-ICS payment - updating NonIcsMember record directly', [
                        'non_ics_member_id' => $nonIcsMember->id,
                        'email' => $nonIcsMember->email
                    ]);

                    // Update the NonIcsMember record with payment details
                    $nonIcsMember->payment_status = $validated['payment_status'];
                    $nonIcsMember->purpose = $validated['purpose'];
                    $nonIcsMember->total_price = $validated['total_price'];

                    // Payment method specific fields
                    if ($validated['payment_method'] === 'CASH') {
                        $nonIcsMember->receipt_control_number = $validated['receipt_control_number'] ?? null;
                        $nonIcsMember->cash_proof_path = $cashProofPath;
                    } else if ($validated['payment_method'] === 'GCASH') {
                        $nonIcsMember->gcash_name = $validated['gcash_name'] ?? null;
                        $nonIcsMember->gcash_num = $validated['gcash_num'] ?? null;
                        $nonIcsMember->reference_number = $validated['reference_number'] ?? null;
                        $nonIcsMember->gcash_proof_path = $gcashProofPath;
                    }

                    $nonIcsMember->save();

                    \Log::info('NonIcsMember record updated successfully', [
                        'id' => $nonIcsMember->id,
                        'payment_status' => $nonIcsMember->payment_status,
                        'total_price' => $nonIcsMember->total_price
                    ]);
                }

                // Only create an order if this is NOT a non-ICS payment
                if (!($isNonIcsPayment && $validated['payer_type'] === 'non_ics_member')) {
                    // Log the order data before creation
                    \Log::info('Order Data Before Creation:', $orderData);

                    // Create the order using the create method
                    $order = Order::create($orderData);

                    // Log the created order
                    \Log::info('Order Created:', ['id' => $order->id, 'data' => $order->toArray()]);
                } else {
                    \Log::info('Skipping Order creation for Non-ICS member payment');
                    $order = null; // Set to null since we're not creating an order
                }

                // Double-check that the relationship is properly established for non-ICS members
                // Only if an order was created and it's for a non-ICS member
                if ($order && $validated['payer_type'] === 'non_ics_member' && $nonIcsMember) {
                    // Ensure the non_ics_member_id is set correctly
                    if ($order->non_ics_member_id != $nonIcsMember->id) {
                        \Log::warning('Order created with incorrect non_ics_member_id, fixing...', [
                            'order_id' => $order->id,
                            'current_non_ics_member_id' => $order->non_ics_member_id,
                            'expected_non_ics_member_id' => $nonIcsMember->id
                        ]);

                        $order->non_ics_member_id = $nonIcsMember->id;
                        $order->is_non_ics_member = true;
                        $order->save();

                        \Log::info('Order Updated After Creation:', [
                            'id' => $order->id,
                            'non_ics_member_id' => $order->non_ics_member_id,
                            'is_non_ics_member' => $order->is_non_ics_member
                        ]);
                    } else {
                        \Log::info('Order correctly linked to Non-ICS Member:', [
                            'order_id' => $order->id,
                            'non_ics_member_id' => $order->non_ics_member_id,
                            'non_ics_member_email' => $nonIcsMember->email
                        ]);
                    }

                    // Verify the relationship works
                    $relatedNonIcsMember = $order->nonIcsMember;
                    if ($relatedNonIcsMember) {
                        \Log::info('Relationship verification successful:', [
                            'order_id' => $order->id,
                            'related_non_ics_member_id' => $relatedNonIcsMember->id,
                            'related_non_ics_member_email' => $relatedNonIcsMember->email
                        ]);
                    } else {
                        \Log::warning('Relationship verification failed - nonIcsMember relationship returned null', [
                            'order_id' => $order->id,
                            'non_ics_member_id' => $order->non_ics_member_id
                        ]);
                    }
                }

                // Prepare success message based on payment type
                $successMessage = $isNonIcsPayment && $validated['payer_type'] === 'non_ics_member'
                    ? 'Non-ICS member payment recorded successfully.'
                    : 'Payment recorded successfully.';

                // Redirect to payments index
                return redirect()->route('admin.payments.index')
                    ->with('success', $successMessage);
            } catch (\Exception $e) {
                \Log::error('Payment Creation Failed:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'data' => $orderData ?? []
                ]);

                return redirect()->back()
                    ->with('error', 'Failed to record payment: ' . $e->getMessage())
                    ->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to record payment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        $payment = Order::findOrFail($id);
        $user = Auth::user();

        // Allow admins to view any payment
        // For regular members, only allow them to view their own payments
        if (!$user->is_admin && $payment->user_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit($id)
    {
        $payment = Order::findOrFail($id);
        $user = Auth::user();

        // Only admins can edit any payment
        if (!$user->is_admin) {
            abort(403, 'Unauthorized.');
        }

        return view('payments.edit', compact('payment'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $payment = Order::findOrFail($id);
            $user = Auth::user();

            // Only admins can update any payment
            if (!$user->is_admin) {
                abort(403, 'Unauthorized.');
            }

            $validated = $request->validate([
                'total_price' => 'required|numeric|min:0',
                'payment_method' => 'required|string|in:CASH,GCASH',
                'payment_status' => 'required|string|in:Paid,Pending,Failed,Refunded',
                'description' => 'nullable|string',
                // GCASH specific fields
                'gcash_name' => 'required_if:payment_method,GCASH|string|nullable',
                'gcash_num' => 'required_if:payment_method,GCASH|string|nullable',

                'reference_number' => 'required_if:payment_method,GCASH|string|nullable',
                // CASH specific fields
                'officer_in_charge' => 'required_if:payment_method,CASH|string|nullable',
                'receipt_control_number' => 'required_if:payment_method,CASH|integer|nullable',
            ], [
                'officer_in_charge.required_if' => 'The officer in charge field is required when payment method is CASH.',
                'receipt_control_number.required_if' => 'The receipt control number field is required when payment method is CASH.',
                'receipt_control_number.integer' => 'The receipt control number must be an integer.',
            ]);



            $payment->update([
                'method' => $validated['payment_method'],
                'total_price' => $validated['total_price'],
                'description' => $validated['description'] ?? null,
                // GCash details
                'gcash_name' => $validated['gcash_name'] ?? null,
                'gcash_num' => $validated['gcash_num'] ?? null,
                'reference_number' => $validated['reference_number'] ?? null,
                // Cash details
                'officer_in_charge' => $validated['officer_in_charge'] ?? null,
                'receipt_control_number' => $validated['receipt_control_number'] ?? null,
                'payment_status' => $validated['payment_status']
            ]);

            return redirect()->route('admin.payments.show', $payment->id)
                ->with('success', 'Payment updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Payment update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update payment. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy($id)
    {
        try {
            $payment = Order::findOrFail($id);
            $user = Auth::user();

            // Only admins can delete payments
            if (!$user->is_admin) {
                abort(403, 'Unauthorized.');
            }

            $payment->delete();

            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Payment deletion failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to delete payment. Please try again.');
        }
    }

    /**
     * Approve a pending payment.
     */
    public function approve($id)
    {
        try {
            $payment = Order::findOrFail($id);
            $user = Auth::user();

            // Only admins can approve payments
            if (!$user->is_admin) {
                abort(403, 'Unauthorized.');
            }

            if ($payment->payment_status !== 'Pending') {
                return redirect()->back()
                    ->with('error', 'Only pending payments can be approved.');
            }

            $payment->update([
                'payment_status' => 'Paid',
                'officer_in_charge' => $user->firstname . ' ' . $user->lastname
            ]);

            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment approved successfully.');
        } catch (\Exception $e) {
            \Log::error('Payment approval failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to approve payment. Please try again.');
        }
    }

    /**
     * Reject a pending payment.
     */
    public function reject($id)
    {
        try {
            $payment = Order::findOrFail($id);
            $user = Auth::user();

            // Only admins can reject payments
            if (!$user->is_admin) {
                abort(403, 'Unauthorized.');
            }

            if ($payment->payment_status !== 'Pending') {
                return redirect()->back()
                    ->with('error', 'Only pending payments can be rejected.');
            }

            $payment->update([
                'payment_status' => 'Rejected',
                'officer_in_charge' => $user->firstname . ' ' . $user->lastname
            ]);

            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment rejected successfully.');
        } catch (\Exception $e) {
            \Log::error('Payment rejection failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to reject payment. Please try again.');
        }
    }

    /**
     * Approve a pending non-ICS member payment.
     */
    public function approveNonIcs($id)
    {
        try {
            $nonIcsMember = NonIcsMember::findOrFail($id);
            $user = Auth::user();

            // Only admins can approve payments
            if (!$user->is_admin) {
                abort(403, 'Unauthorized.');
            }

            if ($nonIcsMember->payment_status !== 'Pending') {
                return redirect()->back()
                    ->with('error', 'Only pending payments can be approved.');
            }

            $nonIcsMember->update([
                'payment_status' => 'Paid',
                'officer_in_charge' => $user->firstname . ' ' . $user->lastname
            ]);

            return redirect()->route('admin.payments.index')
                ->with('success', 'Non-ICS member payment approved successfully.');
        } catch (\Exception $e) {
            \Log::error('Non-ICS member payment approval failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to approve payment. Please try again.');
        }
    }

    /**
     * Reject a pending non-ICS member payment.
     */
    public function rejectNonIcs($id)
    {
        try {
            $nonIcsMember = NonIcsMember::findOrFail($id);
            $user = Auth::user();

            // Only admins can reject payments
            if (!$user->is_admin) {
                abort(403, 'Unauthorized.');
            }

            if ($nonIcsMember->payment_status !== 'Pending') {
                return redirect()->back()
                    ->with('error', 'Only pending payments can be rejected.');
            }

            $nonIcsMember->update([
                'payment_status' => 'Rejected',
                'officer_in_charge' => $user->firstname . ' ' . $user->lastname
            ]);

            return redirect()->route('admin.payments.index')
                ->with('success', 'Non-ICS member payment rejected successfully.');
        } catch (\Exception $e) {
            \Log::error('Non-ICS member payment rejection failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to reject payment. Please try again.');
        }
    }

    /**
     * Show non-ICS member payment details.
     */
    public function showNonIcs($id)
    {
        try {
            $nonIcsMember = NonIcsMember::findOrFail($id);
            $user = Auth::user();

            // Only admins can view non-ICS member payment details
            if (!$user->is_admin) {
                abort(403, 'Unauthorized.');
            }

            return view('payments.show-non-ics', compact('nonIcsMember'));
        } catch (\Exception $e) {
            \Log::error('Failed to show non-ICS member payment: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to show payment details. Please try again.');
        }
    }

    public function clientIndex(Request $request)
    {
        $user = auth()->user();

        // Base query for the authenticated user's payments
        $query = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply payment status filter
        if ($request->has('payment_status') && $request->payment_status !== '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Get paginated results
        $payments = $query->paginate(10);

        // Calculate statistics - using separate queries to avoid query builder issues
        $totalPayments = Order::where('user_id', $user->id)
            ->where('payment_status', 'Paid')
            ->sum('total_price');

        $thisMonthPayments = Order::where('user_id', $user->id)
            ->where('payment_status', 'Paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $pendingPayments = Order::where('user_id', $user->id)
            ->where('payment_status', 'Pending')
            ->sum('total_price');

        return view('payments.member', compact('payments', 'totalPayments', 'thisMonthPayments', 'pendingPayments'));
    }

    /**
     * Show the form for creating a new payment for members.
     */
    public function memberCreate()
    {
        $user = Auth::user();

        // Only allow non-admin users (members) to access this page
        if ($user->is_admin) {
            return redirect()->route('admin.payments.create')
                ->with('error', 'Please use the admin payment creation form.');
        }

        // Get the current user's full name
        $memberName = trim(implode(' ', array_filter([
            $user->firstname,
            $user->middlename,
            $user->lastname,
            $user->suffix
        ])));

        return view('payments.member-create', compact('user', 'memberName'));
    }

    /**
     * Store a newly created payment from a member.
     */
    public function memberStore(Request $request)
    {
        $user = Auth::user();

        // Only allow non-admin users (members) to use this method
        if ($user->is_admin) {
            return redirect()->route('admin.payments.index')
                ->with('error', 'Please use the admin payment creation form.');
        }

        try {
            $validated = $request->validate([
                'total_price' => 'required|numeric|min:0',
                'payment_method' => 'required|string|in:CASH,GCASH',
                'purpose' => 'required|string',
                'description' => 'nullable|string',
                // GCASH specific fields
                'gcash_name' => 'required_if:payment_method,GCASH|string|nullable',
                'gcash_num' => 'required_if:payment_method,GCASH|string|nullable',

                'reference_number' => 'required_if:payment_method,GCASH|string|nullable',
                'gcash_proof_of_payment' => 'required_if:payment_method,GCASH|file|mimes:jpg,jpeg|max:2048|nullable',
                // CASH specific fields
                'officer_in_charge' => 'required_if:payment_method,CASH|string|nullable',
                'receipt_control_number' => 'required_if:payment_method,CASH|integer|nullable',
                'cash_proof_of_payment' => 'required_if:payment_method,CASH|file|mimes:jpg,jpeg|max:2048',
            ], [
                'officer_in_charge.required_if' => 'The officer in charge field is required when payment method is CASH.',
                'receipt_control_number.required_if' => 'The receipt control number field is required when payment method is CASH.',
                'receipt_control_number.integer' => 'The receipt control number must be an integer.',
                'purpose.required' => 'The purpose field is required.',
                'gcash_proof_of_payment.required_if' => 'The proof of payment is required when payment method is GCASH.',
                'gcash_proof_of_payment.mimes' => 'The proof of payment must be a JPG file.',
                'cash_proof_of_payment.required_if' => 'The proof of payment is required when payment method is CASH.',
                'cash_proof_of_payment.mimes' => 'The proof of payment must be a JPG file.',
            ]);



            // Handle file uploads
            $gcashProofPath = null;
            $cashProofPath = null;

            if ($request->hasFile('gcash_proof_of_payment') && $validated['payment_method'] === 'GCASH') {
                $gcashProofFile = $request->file('gcash_proof_of_payment');
                $gcashProofPath = 'proofs/gcash_' . time() . '_' . $gcashProofFile->getClientOriginalName();
                $gcashProofFile->move(public_path('proofs'), $gcashProofPath);
            }

            if ($request->hasFile('cash_proof_of_payment') && $validated['payment_method'] === 'CASH') {
                $cashProofFile = $request->file('cash_proof_of_payment');
                $cashProofPath = 'proofs/cash_' . time() . '_' . $cashProofFile->getClientOriginalName();
                $cashProofFile->move(public_path('proofs'), $cashProofPath);
            }

            // Create the payment record
            $payment = Order::create([
                'user_id' => $user->id,
                'method' => $validated['payment_method'],
                'total_price' => $validated['total_price'],
                'purpose' => $validated['purpose'],
                'description' => $validated['description'] ?? null,
                // GCash details
                'gcash_name' => $validated['gcash_name'] ?? null,
                'gcash_num' => $validated['gcash_num'] ?? null,
                'gcash_amount' => $validated['gcash_amount'] ?? null,
                'reference_number' => $validated['reference_number'] ?? null,
                'gcash_proof_path' => $gcashProofPath,
                // Cash details
                'receipt_control_number' => $validated['receipt_control_number'] ?? null,
                'cash_proof_path' => $cashProofPath,
                'placed_on' => now()->format('Y-m-d H:i:s'),
                'payment_status' => 'Pending' // Members can only submit pending payments
            ]);

            return redirect()->route('client.payments.index')
                ->with('success', 'Payment #' . $payment->id . ' submitted successfully. It is pending approval from an administrator.');

        } catch (\Exception $e) {
            \Log::error('Member payment submission failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to submit payment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing a member payment.
     */
    public function memberEdit($id)
    {
        $user = Auth::user();

        // Only allow non-admin users (members) to access this page
        if ($user->is_admin) {
            return redirect()->route('admin.payments.edit', $id)
                ->with('error', 'Please use the admin payment edit form.');
        }

        // Find the payment and ensure it belongs to the current user
        $payment = Order::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$payment) {
            return redirect()->route('client.payments.index')
                ->with('error', 'Payment not found or you do not have permission to edit it.');
        }

        // Only allow editing of pending payments
        if ($payment->payment_status !== 'Pending') {
            return redirect()->route('client.payments.index')
                ->with('error', 'Only pending payments can be edited.');
        }

        // Get the current user's full name
        $memberName = trim(implode(' ', array_filter([
            $user->firstname,
            $user->middlename,
            $user->lastname,
            $user->suffix
        ])));

        return view('payments.member-edit', compact('payment', 'user', 'memberName'));
    }

    /**
     * Update a member payment.
     */
    public function memberUpdate(Request $request, $id)
    {
        $user = Auth::user();

        // Only allow non-admin users (members) to use this method
        if ($user->is_admin) {
            return redirect()->route('admin.payments.index')
                ->with('error', 'Please use the admin payment edit form.');
        }

        // Find the payment and ensure it belongs to the current user
        $payment = Order::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$payment) {
            return redirect()->route('client.payments.index')
                ->with('error', 'Payment not found or you do not have permission to edit it.');
        }

        // Only allow editing of pending payments
        if ($payment->payment_status !== 'Pending') {
            return redirect()->route('client.payments.index')
                ->with('error', 'Only pending payments can be edited.');
        }

        try {
            $validated = $request->validate([
                'total_price' => 'required|numeric|min:0',
                'payment_method' => 'required|string|in:CASH,GCASH',
                'purpose' => 'required|string',
                'description' => 'nullable|string',
                // GCASH specific fields
                'gcash_name' => 'required_if:payment_method,GCASH|string|nullable',
                'gcash_num' => 'required_if:payment_method,GCASH|string|nullable',
                'gcash_amount' => 'required_if:payment_method,GCASH|numeric|min:0|nullable',
                'reference_number' => 'required_if:payment_method,GCASH|string|nullable',
                'gcash_proof_of_payment' => 'nullable|file|mimes:jpg,jpeg|max:2048',
                // CASH specific fields
                'officer_in_charge' => 'required_if:payment_method,CASH|string|nullable',
                'receipt_control_number' => 'required_if:payment_method,CASH|integer|nullable',
                'cash_proof_of_payment' => 'required_if:payment_method,CASH|file|mimes:jpg,jpeg|max:2048',
            ], [
                'officer_in_charge.required_if' => 'The officer in charge field is required when payment method is CASH.',
                'receipt_control_number.required_if' => 'The receipt control number field is required when payment method is CASH.',
                'receipt_control_number.integer' => 'The receipt control number must be an integer.',
                'purpose.required' => 'The purpose field is required.',
                'gcash_proof_of_payment.mimes' => 'The proof of payment must be a JPG file.',
                'cash_proof_of_payment.mimes' => 'The proof of payment must be a JPG file.',
            ]);

            // Validate that GCash amount is sufficient
            if ($request->payment_method === 'GCASH' && isset($validated['gcash_amount'], $validated['total_price'])) {
                if ($validated['gcash_amount'] < $validated['total_price']) {
                    return redirect()->back()
                        ->with('error', 'GCash amount must be greater than or equal to the total price.')
                        ->withInput();
                }
            }

            // Handle file uploads
            $gcashProofPath = $payment->gcash_proof_path;
            $cashProofPath = $payment->cash_proof_path;

            if ($request->hasFile('gcash_proof_of_payment') && $validated['payment_method'] === 'GCASH') {
                $gcashProofFile = $request->file('gcash_proof_of_payment');
                $gcashProofPath = 'proofs/gcash_' . time() . '_' . $gcashProofFile->getClientOriginalName();
                $gcashProofFile->move(public_path('proofs'), $gcashProofPath);

                // Delete old file if it exists
                if ($payment->gcash_proof_path && file_exists(public_path($payment->gcash_proof_path))) {
                    unlink(public_path($payment->gcash_proof_path));
                }
            }

            if ($request->hasFile('cash_proof_of_payment') && $validated['payment_method'] === 'CASH') {
                $cashProofFile = $request->file('cash_proof_of_payment');
                $cashProofPath = 'proofs/cash_' . time() . '_' . $cashProofFile->getClientOriginalName();
                $cashProofFile->move(public_path('proofs'), $cashProofPath);

                // Delete old file if it exists
                if ($payment->cash_proof_path && file_exists(public_path($payment->cash_proof_path))) {
                    unlink(public_path($payment->cash_proof_path));
                }
            }

            // Update the payment record
            $payment->update([
                'method' => $validated['payment_method'],
                'total_price' => $validated['total_price'],
                'purpose' => $validated['purpose'],
                'description' => $validated['description'] ?? null,
                // GCash details
                'gcash_name' => $validated['gcash_name'] ?? null,
                'gcash_num' => $validated['gcash_num'] ?? null,
                'gcash_amount' => $validated['gcash_amount'] ?? null,
                'reference_number' => $validated['reference_number'] ?? null,
                'gcash_proof_path' => $validated['payment_method'] === 'GCASH' ? $gcashProofPath : null,
                // Cash details
                'officer_in_charge' => $validated['officer_in_charge'] ?? null,
                'receipt_control_number' => $validated['receipt_control_number'] ?? null,
                'cash_proof_path' => $validated['payment_method'] === 'CASH' ? $cashProofPath : null,
            ]);

            return redirect()->route('client.payments.index')
                ->with('success', 'Payment updated successfully. It is still pending approval from an administrator.');

        } catch (\Exception $e) {
            \Log::error('Member payment update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update payment: ' . $e->getMessage())
                ->withInput();
        }
    }
}