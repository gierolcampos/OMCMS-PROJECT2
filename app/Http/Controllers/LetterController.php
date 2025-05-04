<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // We're not actually querying the database, just showing the UI
        // In a real implementation, we would query the letters table

        return view('letters.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $letterTypes = ['Official', 'Memo', 'Invitation', 'Request', 'Other'];
        return view('letters.create', compact('letterTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'letter_type' => 'nullable|string|max:255',
            'recipient' => 'nullable|string|max:255',
            'status' => 'required|in:draft,finished',
            'purpose' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);

        // We're not actually storing the letter, just redirecting
        // In a real implementation, we would create a new Letter record

        return redirect()->route('admin.letters.index')
            ->with('success', 'Letter created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Letter $letter)
    {
        return view('letters.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Letter $letter)
    {
        return view('letters.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Letter $letter)
    {
        return redirect()->route('admin.letters.index')
            ->with('success', 'Letter updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Letter $letter)
    {
        return redirect()->route('admin.letters.index')
            ->with('success', 'Letter deleted successfully.');
    }
}
