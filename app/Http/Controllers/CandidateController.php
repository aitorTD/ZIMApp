<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    /**
     * Display a listing of the candidates.
     */
    public function index()
    {
        $candidates = Candidate::latest()->get();
        return view('dashboard', compact('candidates'));
    }

    /**
     * Store a newly created candidate in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:candidates,email',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $candidate = Candidate::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'added_by' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Candidate added successfully!');
    }

    /**
     * Display the specified candidate.
     */
    public function show(Candidate $candidate)
    {
        return view('candidates.show', compact('candidate'));
    }

    /**
     * Show the form for editing the specified candidate.
     */
    public function edit(Candidate $candidate)
    {
        return view('candidates.edit', compact('candidate'));
    }

    /**
     * Update the specified candidate in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:candidates,email,' . $candidate->id,
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $candidate->update($validated);

        return redirect()->route('dashboard')->with('success', 'Candidate updated successfully!');
    }
}
