<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CandidateSponsor;
use App\Http\Requests\StoreSponsorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorController extends Controller
{
    /**
     * Display a listing of the sponsored candidates for the current user.
     */
    public function myCandidates()
    {
        $sponsoredCandidates = Auth::user()->sponsoredCandidates()
            ->withPivot('status', 'notes')
            ->paginate(10);

        return view('sponsor.my-candidates', [
            'candidates' => $sponsoredCandidates,
        ]);
    }

    /**
     * Show the form for sponsoring a new candidate.
     */
    public function create()
    {
        $candidates = User::role('candidate')
            ->whereDoesntHave('sponsors', function($query) {
                $query->where('sponsor_id', Auth::id());
            })
            ->select('id', 'first_name', 'last_name', 'email')
            ->get();

        return view('sponsor.create', [
            'candidates' => $candidates,
        ]);
    }

    /**
     * Store a newly created sponsorship in storage.
     */
    public function store(StoreSponsorRequest $request)
    {
        $user = Auth::user();
        
        // Check if the user is allowed to be a sponsor
        if (!$user->isSponsor()) {
            return redirect()->back()->with('error', 'Only members can sponsor candidates.');
        }

        // Check if the candidate exists and is actually a candidate
        $candidate = User::findOrFail($request->candidate_id);
        if (!$candidate->isCandidate()) {
            return redirect()->back()->with('error', 'The selected user is not a candidate.');
        }

        // Create the sponsorship
        $user->sponsoredCandidates()->attach($candidate->id, [
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('sponsor.my-candidates')
            ->with('success', 'Sponsorship request sent successfully.');
    }

    /**
     * Update the specified sponsorship status.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,rejected',
        ]);

        $sponsorship = CandidateSponsor::findOrFail($id);
        
        // Only the candidate can update the status
        if ($sponsorship->candidate_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $sponsorship->update([
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Sponsorship updated successfully']);
    }

    /**
     * Remove the specified sponsorship.
     */
    public function destroy($id)
    {
        $sponsorship = CandidateSponsor::findOrFail($id);
        
        // Only the sponsor or admin can remove the sponsorship
        if ($sponsorship->sponsor_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $sponsorship->delete();

        return response()->json(['message' => 'Sponsorship removed successfully']);
    }
}
