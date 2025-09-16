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
     * Show the form for creating a new candidate.
     */
    public function create()
    {
        return view('candidates.create');
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
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
            'biography' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $candidate = Candidate::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'country' => $validated['country'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'biography' => $validated['biography'] ?? null,
            'status' => 'pending',
            'user_id' => Auth::id(),
            'application_date' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Candidate added successfully!');
    }

    /**
     * Display the specified candidate.
     */
    public function show(Candidate $candidate)
    {
        // Eager load all necessary relationships
        $candidate->load([
            'user',
            'notes' => function($query) {
                $query->with('user')->latest();
            }
        ]);
        
        // Debug output - can be removed later
        \Log::info('Candidate data:', $candidate->toArray());
        
        return view('candidates.show', [
            'candidate' => $candidate
        ]);
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
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $candidate->update($validated);

        return redirect()->route('dashboard')->with('success', 'Candidate updated successfully!');
    }
}
