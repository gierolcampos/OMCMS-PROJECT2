<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        // Check if user is admin
        $isAdmin = auth()->user()->is_admin;

        // Base query - for admin show all users, for regular users show only non-admin users
        $query = $isAdmin ? User::query() : User::where('is_admin', 0);

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('studentnumber', 'like', "%{$search}%");
            });
        }

        // Admin-specific filters
        if ($isAdmin) {
            // Apply role filter
            if ($request->has('role') && $request->role !== '') {
                $roleIsAdmin = $request->role === 'admin' ? 1 : 0;
                $query->where('is_admin', $roleIsAdmin);
            }

            // Apply status filter
            if ($request->has('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }
        }

        // Get paginated results
        $members = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate statistics
        if ($isAdmin) {
            // Admin statistics
            $totalUsers = User::count();
            $totalAdmins = User::where('is_admin', 1)->count();
            $totalMembers = User::where('is_admin', 0)->count();
            $activeUsers = User::where('status', 'active')->count();
            $inactiveUsers = User::where('status', 'inactive')->count();

            return view('members.index', compact(
                'members',
                'isAdmin',
                'totalUsers',
                'totalAdmins',
                'totalMembers',
                'activeUsers',
                'inactiveUsers'
            ));
        } else {
            // Regular user statistics
            $totalMembers = User::where('is_admin', 0)->count();
            $verifiedMembers = User::where('is_admin', 0)->whereNotNull('email_verified_at')->count();
            $unverifiedMembers = User::where('is_admin', 0)->whereNull('email_verified_at')->count();

            return view('members.index', compact(
                'members',
                'isAdmin',
                'totalMembers',
                'verifiedMembers',
                'unverifiedMembers'
            ));
        }
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'studentnumber' => 'required|string|max:6|unique:users',
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'suffix' => 'nullable|string|max:255',
                'course' => 'required|string|max:255',
                'major' => 'nullable|string|max:255',
                'year' => 'required|integer|min:1|max:5',
                'section' => 'required|string|max:255',
                'mobile_no' => 'required|string|max:11',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            User::create([
                'studentnumber' => $validated['studentnumber'],
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'middlename' => $validated['middlename'],
                'suffix' => $validated['suffix'],
                'course' => $validated['course'],
                'major' => $validated['major'],
                'year' => $validated['year'],
                'section' => $validated['section'],
                'mobile_no' => $validated['mobile_no'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'is_admin' => 0,
            ]);

            return redirect()->route('members.index')
                ->with('success', 'Member created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create member: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to create member: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified member.
     */
    public function show($id)
    {
        $member = User::findOrFail($id);
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit($id)
    {
        $member = User::findOrFail($id);
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $member = User::findOrFail($id);

            $validated = $request->validate([
                'studentnumber' => 'required|string|max:6|unique:users,studentnumber,' . $id,
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'suffix' => 'nullable|string|max:255',
                'course' => 'required|string|max:255',
                'major' => 'nullable|string|max:255',
                'year' => 'required|integer|min:1|max:5',
                'section' => 'required|string|max:255',
                'mobile_no' => 'required|string|max:11',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            ]);

            $member->update($validated);

            return redirect()->route('members.index')
                ->with('success', 'Member updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update member: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update member: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy($id)
    {
        try {
            $member = User::findOrFail($id);
            $member->delete();

            return redirect()->route('members.index')
                ->with('success', 'Member deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete member: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to delete member: ' . $e->getMessage());
        }
    }



    /**
     * Update the status of a member.
     */
    public function updateStatus($id, Request $request)
    {
        try {
            $member = User::findOrFail($id);
            $member->status = $request->status;
            $member->save();

            return redirect()->back()
                ->with('success', 'Member status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update member status: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update member status: ' . $e->getMessage());
        }
    }

    /**
     * Update the role of a member.
     */
    public function updateRole($id, Request $request)
    {
        try {
            $member = User::findOrFail($id);
            $member->is_admin = $request->role === 'admin' ? 1 : 0;
            $member->save();

            return redirect()->back()
                ->with('success', 'Member role updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update member role: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update member role: ' . $e->getMessage());
        }
    }
}
