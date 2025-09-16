<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\CandidateNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CandidateNoteController extends Controller
{
    /**
     * Store a newly created note for a candidate.
     */
    public function store(Request $request, Candidate $candidate)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
            'is_private' => 'sometimes|boolean',
        ]);

        $note = $candidate->notes()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_private' => $request->boolean('is_private', false),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note added successfully',
                'note' => $note->load('user:id,name')
            ], 201);
        }

        return redirect()->back()->with('success', 'Note added successfully');
    }

    /**
     * Update the specified note.
     */
    public function update(Request $request, Candidate $candidate, CandidateNote $note)
    {
        // Ensure the note belongs to the candidate
        if ($note->candidate_id !== $candidate->id) {
            abort(404);
        }

        // Only the note creator can update it
        $this->authorize('update', $note);

        $request->validate([
            'content' => 'required|string|max:2000',
            'is_private' => 'sometimes|boolean',
        ]);

        $note->update([
            'content' => $request->content,
            'is_private' => $request->boolean('is_private', $note->is_private),
        ]);

        return response()->json([
            'message' => 'Note updated successfully',
            'note' => $note->load('user:id,name')
        ]);
    }

    /**
     * Remove the specified note.
     */
    public function destroy(Request $request, Candidate $candidate, CandidateNote $note)
    {
        // Ensure the note belongs to the candidate
        if ($note->candidate_id !== $candidate->id) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Note not found'], 404);
            }
            abort(404);
        }

        // Only the note creator can delete it
        $this->authorize('delete', $note);

        $note->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note deleted successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Note deleted successfully');
    }
}
