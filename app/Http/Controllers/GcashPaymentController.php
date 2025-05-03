<?php

namespace App\Http\Controllers;

use App\Models\GcashPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GcashPaymentController extends Controller
{
    /**
     * Display a listing of the GCash payments.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user->is_admin) {
            abort(403, 'Unauthorized.');
        }

        $query = GcashPayment::with('user');

        // Apply search filter
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('firstname', 'like', '%' . $search . '%')
                        ->orWhere('lastname', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }

        // Apply status filter
        if (request('status')) {
            $query->where('payment_status', request('status'));
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate statistics
        $totalPayments = GcashPayment::where('payment_status', 'Paid')->sum('total_price');
        $thisMonthPayments = GcashPayment::where('payment_status', 'Paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');
        $pendingPayments = GcashPayment::where('payment_status', 'Pending')->sum('total_price');

        // Redirect to the main payments page instead of trying to render a non-existent view
        return redirect()->route('admin.payments.index')
            ->with('info', 'Viewing all payments. GCash payments are included in this list.');
    }

    /**
     * Display a listing of the GCash payments for the client.
     */
    public function clientIndex()
    {
        $user = Auth::user();

        $query = GcashPayment::where('user_id', $user->id);

        // Apply search filter
        if (request('search')) {
            $search = request('search');
            $query->where('id', 'like', '%' . $search . '%');
        }

        // Apply status filter
        if (request('payment_status') && request('payment_status') !== '') {
            $query->where('payment_status', request('payment_status'));
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate statistics
        $totalPayments = GcashPayment::where('user_id', $user->id)
            ->where('payment_status', 'Paid')
            ->sum('total_price');

        $thisMonthPayments = GcashPayment::where('user_id', $user->id)
            ->where('payment_status', 'Paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $pendingPayments = GcashPayment::where('user_id', $user->id)
            ->where('payment_status', 'Pending')
            ->sum('total_price');

        return view('payments.gcash.client', compact(
            'payments',
            'totalPayments',
            'thisMonthPayments',
            'pendingPayments'
        ));
    }

    /**
     * Show the form for creating a new GCash payment.
     */
    public function create()
    {
        $admin = Auth::user();

        // Restrict payment creation to admin users only
        if (!$admin->is_admin) {
            return redirect()->route('client.gcash-payments.index')
                ->with('error', 'You do not have permission to create payments as admin.');
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

        return view('payments.gcash.create', compact('users'));
    }

    /**
     * Store a newly created GCash payment in storage.
     */
    public function store(Request $request)
    {
        // Restrict payment creation to admin users only
        if (!auth()->user()->is_admin) {
            return redirect()->route('client.gcash-payments.index')
                ->with('error', 'You do not have permission to create payments as admin.');
        }

        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'total_price' => 'required|numeric|min:0',
                'payment_status' => 'required|string|in:Paid,Pending,Rejected,Refunded',
                'purpose' => 'required|string',
                'description' => 'nullable|string',
                'gcash_name' => 'required|string',
                'gcash_num' => 'required|string',
                'reference_number' => 'required|string',
                'gcash_proof_of_payment' => 'required|file|mimes:jpg,jpeg|max:2048',
            ], [
                'user_id.required' => 'Please select a member.',
                'gcash_name.required' => 'The GCash name field is required.',
                'gcash_num.required' => 'The GCash number field is required.',
                'reference_number.required' => 'The reference number field is required.',
                'purpose.required' => 'The purpose field is required.',
                'gcash_proof_of_payment.required' => 'The proof of payment is required.',
                'gcash_proof_of_payment.mimes' => 'The proof of payment must be a JPG file.',
            ]);

            // Get the user
            $user = User::findOrFail($validated['user_id']);

            // Handle file upload
            $gcashProofPath = null;
            if ($request->hasFile('gcash_proof_of_payment')) {
                $gcashProofFile = $request->file('gcash_proof_of_payment');
                $gcashProofPath = 'proofs/gcash_' . time() . '_' . $gcashProofFile->getClientOriginalName();
                $gcashProofFile->move(public_path('proofs'), $gcashProofPath);
            }

            // Create the payment record
            $payment = GcashPayment::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'total_price' => $validated['total_price'],
                'purpose' => $validated['purpose'],
                'placed_on' => now(),
                'payment_status' => $validated['payment_status'],
                'gcash_name' => $validated['gcash_name'],
                'gcash_num' => $validated['gcash_num'],
                'reference_number' => $validated['reference_number'],
                'gcash_proof_path' => $gcashProofPath,
                'description' => $validated['description'] ?? null,
            ]);

            Log::info('GCash payment created:', ['id' => $payment->id, 'user_id' => $user->id]);

            return redirect()->route('admin.gcash-payments.index')
                ->with('success', 'GCash payment recorded successfully.');
        } catch (\Exception $e) {
            Log::error('GCash Payment Creation Failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Failed to record payment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified GCash payment.
     */
    public function show($id)
    {
        $payment = GcashPayment::findOrFail($id);
        $user = Auth::user();

        // Allow admins to view any payment
        // For regular members, only allow them to view their own payments
        if (!$user->is_admin && $payment->user_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified GCash payment.
     */
    public function edit($id)
    {
        $payment = GcashPayment::findOrFail($id);
        $user = Auth::user();

        // Only admins can edit any payment
        if (!$user->is_admin) {
            abort(403, 'Unauthorized.');
        }

        // Fetch all active members
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

        return view('payments.gcash.edit', compact('payment', 'users'));
    }

    /**
     * Update the specified GCash payment in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $payment = GcashPayment::findOrFail($id);
            $user = Auth::user();

            // Only admins can update any payment
            if (!$user->is_admin) {
                abort(403, 'Unauthorized.');
            }

            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'total_price' => 'required|numeric|min:0',
                'payment_status' => 'required|string|in:Paid,Pending,Rejected,Refunded',
                'purpose' => 'required|string',
                'description' => 'nullable|string',
                'gcash_name' => 'required|string',
                'gcash_num' => 'required|string',
                'reference_number' => 'required|string',
                'gcash_proof_of_payment' => 'nullable|file|mimes:jpg,jpeg|max:2048',
            ], [
                'user_id.required' => 'Please select a member.',
                'gcash_name.required' => 'The GCash name field is required.',
                'gcash_num.required' => 'The GCash number field is required.',
                'reference_number.required' => 'The reference number field is required.',
                'purpose.required' => 'The purpose field is required.',
                'gcash_proof_of_payment.mimes' => 'The proof of payment must be a JPG file.',
            ]);

            // Get the user
            $memberUser = User::findOrFail($validated['user_id']);

            // Handle file upload
            $gcashProofPath = $payment->gcash_proof_path;
            if ($request->hasFile('gcash_proof_of_payment')) {
                $gcashProofFile = $request->file('gcash_proof_of_payment');
                $gcashProofPath = 'proofs/gcash_' . time() . '_' . $gcashProofFile->getClientOriginalName();
                $gcashProofFile->move(public_path('proofs'), $gcashProofPath);

                // Delete old file if it exists
                if ($payment->gcash_proof_path && file_exists(public_path($payment->gcash_proof_path))) {
                    unlink(public_path($payment->gcash_proof_path));
                }
            }

            // Update the payment record
            $payment->update([
                'user_id' => $memberUser->id,
                'email' => $memberUser->email,
                'total_price' => $validated['total_price'],
                'purpose' => $validated['purpose'],
                'payment_status' => $validated['payment_status'],
                'gcash_name' => $validated['gcash_name'],
                'gcash_num' => $validated['gcash_num'],
                'reference_number' => $validated['reference_number'],
                'gcash_proof_path' => $gcashProofPath,
                'description' => $validated['description'] ?? null,
            ]);

            return redirect()->route('admin.gcash-payments.show', $payment->id)
                ->with('success', 'GCash payment updated successfully.');
        } catch (\Exception $e) {
            Log::error('GCash payment update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update payment. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified GCash payment from storage.
     */
    public function destroy($id)
    {
        try {
            $payment = GcashPayment::findOrFail($id);
            $user = Auth::user();

            // Only admins can delete payments
            if (!$user->is_admin) {
                abort(403, 'Unauthorized.');
            }

            $payment->delete();

            return redirect()->route('admin.gcash-payments.index')
                ->with('success', 'GCash payment deleted successfully.');
        } catch (\Exception $e) {
            Log::error('GCash payment deletion failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to delete payment. Please try again.');
        }
    }

    /**
     * Approve a pending GCash payment.
     */
    public function approve($id)
    {
        try {
            $payment = GcashPayment::findOrFail($id);
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
                'payment_status' => 'Paid'
            ]);

            return redirect()->route('admin.payments.index')
                ->with('success', "GCash payment #{$payment->id} approved successfully.");
        } catch (\Exception $e) {
            Log::error('GCash payment approval failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to approve payment. Please try again.');
        }
    }

    /**
     * Reject a pending GCash payment.
     */
    public function reject($id)
    {
        try {
            $payment = GcashPayment::findOrFail($id);
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
                'payment_status' => 'Rejected'
            ]);

            return redirect()->route('admin.payments.index')
                ->with('success', "GCash payment #{$payment->id} rejected successfully.");
        } catch (\Exception $e) {
            Log::error('GCash payment rejection failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to reject payment. Please try again.');
        }
    }

    /**
     * Show the form for creating a new payment for members.
     */
    public function memberCreate()
    {
        $user = Auth::user();

        // Only allow non-admin users (members) to access this page
        if ($user->is_admin) {
            return redirect()->route('admin.gcash-payments.create')
                ->with('error', 'Please use the admin payment creation form.');
        }

        // Get the current user's full name
        $memberName = trim(implode(' ', array_filter([
            $user->firstname,
            $user->middlename,
            $user->lastname,
            $user->suffix
        ])));

        return view('payments.gcash.member-create', compact('user', 'memberName'));
    }

    /**
     * Store a newly created payment from a member.
     */
    public function memberStore(Request $request)
    {
        $user = Auth::user();

        // Only allow non-admin users (members) to use this method
        if ($user->is_admin) {
            return redirect()->route('admin.gcash-payments.index')
                ->with('error', 'Please use the admin payment creation form.');
        }

        try {
            $validated = $request->validate([
                'total_price' => 'required|numeric|min:0',
                'purpose' => 'required|string',
                'description' => 'nullable|string',
                'gcash_name' => 'required|string',
                'gcash_num' => 'required|string',
                'reference_number' => 'required|string',
                'gcash_proof_of_payment' => 'required|file|mimes:jpg,jpeg|max:2048',
            ], [
                'gcash_name.required' => 'The GCash name field is required.',
                'gcash_num.required' => 'The GCash number field is required.',
                'reference_number.required' => 'The reference number field is required.',
                'purpose.required' => 'The purpose field is required.',
                'gcash_proof_of_payment.required' => 'The proof of payment is required.',
                'gcash_proof_of_payment.mimes' => 'The proof of payment must be a JPG file.',
            ]);

            // Handle file upload
            $gcashProofPath = null;
            if ($request->hasFile('gcash_proof_of_payment')) {
                $gcashProofFile = $request->file('gcash_proof_of_payment');
                $gcashProofPath = 'proofs/gcash_' . time() . '_' . $gcashProofFile->getClientOriginalName();
                $gcashProofFile->move(public_path('proofs'), $gcashProofPath);
            }

            // Create the payment record
            $payment = GcashPayment::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'total_price' => $validated['total_price'],
                'purpose' => $validated['purpose'],
                'placed_on' => now(),
                'payment_status' => 'Pending', // Members can only submit pending payments
                'gcash_name' => $validated['gcash_name'],
                'gcash_num' => $validated['gcash_num'],
                'reference_number' => $validated['reference_number'],
                'gcash_proof_path' => $gcashProofPath,
                'description' => $validated['description'] ?? null,
            ]);

            Log::info('Member GCash payment created:', ['id' => $payment->id, 'user_id' => $user->id]);

            return redirect()->route('client.gcash-payments.index')
                ->with('success', 'Payment submitted successfully. It is pending approval from an administrator.');
        } catch (\Exception $e) {
            Log::error('Member GCash payment submission failed: ' . $e->getMessage());
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
            return redirect()->route('admin.gcash-payments.edit', $id)
                ->with('error', 'Please use the admin payment edit form.');
        }

        // Find the payment and ensure it belongs to the current user
        $payment = GcashPayment::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$payment) {
            return redirect()->route('client.gcash-payments.index')
                ->with('error', 'Payment not found or you do not have permission to edit it.');
        }

        // Only allow editing of pending payments
        if ($payment->payment_status !== 'Pending') {
            return redirect()->route('client.gcash-payments.index')
                ->with('error', 'Only pending payments can be edited.');
        }

        // Get the current user's full name
        $memberName = trim(implode(' ', array_filter([
            $user->firstname,
            $user->middlename,
            $user->lastname,
            $user->suffix
        ])));

        return view('payments.gcash.member-edit', compact('payment', 'user', 'memberName'));
    }

    /**
     * Update a member payment.
     */
    public function memberUpdate(Request $request, $id)
    {
        $user = Auth::user();

        // Only allow non-admin users (members) to use this method
        if ($user->is_admin) {
            return redirect()->route('admin.gcash-payments.index')
                ->with('error', 'Please use the admin payment edit form.');
        }

        // Find the payment and ensure it belongs to the current user
        $payment = GcashPayment::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$payment) {
            return redirect()->route('client.gcash-payments.index')
                ->with('error', 'Payment not found or you do not have permission to edit it.');
        }

        // Only allow editing of pending payments
        if ($payment->payment_status !== 'Pending') {
            return redirect()->route('client.gcash-payments.index')
                ->with('error', 'Only pending payments can be edited.');
        }

        try {
            $validated = $request->validate([
                'total_price' => 'required|numeric|min:0',
                'purpose' => 'required|string',
                'description' => 'nullable|string',
                'gcash_name' => 'required|string',
                'gcash_num' => 'required|string',
                'reference_number' => 'required|string',
                'gcash_proof_of_payment' => 'nullable|file|mimes:jpg,jpeg|max:2048',
            ], [
                'gcash_name.required' => 'The GCash name field is required.',
                'gcash_num.required' => 'The GCash number field is required.',
                'reference_number.required' => 'The reference number field is required.',
                'purpose.required' => 'The purpose field is required.',
                'gcash_proof_of_payment.mimes' => 'The proof of payment must be a JPG file.',
            ]);

            // Handle file upload
            $gcashProofPath = $payment->gcash_proof_path;
            if ($request->hasFile('gcash_proof_of_payment')) {
                $gcashProofFile = $request->file('gcash_proof_of_payment');
                $gcashProofPath = 'proofs/gcash_' . time() . '_' . $gcashProofFile->getClientOriginalName();
                $gcashProofFile->move(public_path('proofs'), $gcashProofPath);

                // Delete old file if it exists
                if ($payment->gcash_proof_path && file_exists(public_path($payment->gcash_proof_path))) {
                    unlink(public_path($payment->gcash_proof_path));
                }
            }

            // Update the payment record
            $payment->update([
                'total_price' => $validated['total_price'],
                'purpose' => $validated['purpose'],
                'gcash_name' => $validated['gcash_name'],
                'gcash_num' => $validated['gcash_num'],
                'reference_number' => $validated['reference_number'],
                'gcash_proof_path' => $gcashProofPath,
                'description' => $validated['description'] ?? null,
            ]);

            return redirect()->route('client.gcash-payments.index')
                ->with('success', 'Payment updated successfully. It is still pending approval from an administrator.');
        } catch (\Exception $e) {
            Log::error('Member GCash payment update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update payment: ' . $e->getMessage())
                ->withInput();
        }
    }
}
