<?php

namespace App\Policies;

use App\Models\CandidateNote;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CandidateNotePolicy
{
    /**
     * Determine whether the user can view any models.
     * Users can view all non-private notes or their own private notes.
     */
    public function viewAny(User $user): bool
    {
        return true; // Handled in the controller
    }

    /**
     * Determine whether the user can view the model.
     * Users can view the note if it's not private or if they are the author.
     */
    public function view(User $user, CandidateNote $candidateNote): bool
    {
        return !$candidateNote->is_private || $user->id === $candidateNote->user_id;
    }

    /**
     * Determine whether the user can create models.
     * Any authenticated user can create notes.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * Only the note creator can update it.
     */
    public function update(User $user, CandidateNote $candidateNote): bool
    {
        return $user->id === $candidateNote->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * Only the note creator can delete it.
     */
    public function delete(User $user, CandidateNote $candidateNote): bool
    {
        return $user->id === $candidateNote->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CandidateNote $candidateNote): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CandidateNote $candidateNote): bool
    {
        return false;
    }
}
