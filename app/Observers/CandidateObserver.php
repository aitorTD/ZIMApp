<?php

namespace App\Observers;

use App\Models\Candidate;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CandidateObserver
{
    /**
     * Handle the Candidate "created" event.
     */
    public function created(Candidate $candidate): void
    {
        //
    }

    /**
     * Handle the Candidate "updated" event.
     */
    public function updated(Candidate $candidate): void
    {
        // Check if status was changed to 'accepted' and user_id is not already set
        if ($candidate->isDirty('status') && $candidate->status === 'accepted') {
            \Log::info('Candidate status changed to accepted', [
                'candidate_id' => $candidate->id,
                'user_id' => $candidate->user_id,
                'email' => $candidate->email
            ]);
            
            if (!$candidate->user_id) {
                $this->createMemberFromCandidate($candidate);
            } else {
                // If user already exists but status was updated, ensure they have the member role
                $user = $candidate->user;
                if ($user && !$user->hasRole('member')) {
                    $user->assignRole('member');
                    if ($user->hasRole('candidate')) {
                        $user->removeRole('candidate');
                    }
                    \Log::info('Assigned member role to existing user', [
                        'user_id' => $user->id,
                        'email' => $user->email
                    ]);
                }
            }
        }
    }
    
    /**
     * Create a new member from an accepted candidate
     */
    protected function createMemberFromCandidate(Candidate $candidate): void
    {
        \DB::beginTransaction();
        
        try {
            // Check if a user with this email already exists
            $existingUser = User::where('email', $candidate->email)->first();
            
            if ($existingUser) {
                \Log::info('Found existing user for candidate', [
                    'candidate_id' => $candidate->id,
                    'user_id' => $existingUser->id,
                    'email' => $candidate->email
                ]);
                
                // Update existing user with candidate data
                $existingUser->update([
                    'first_name' => $candidate->first_name,
                    'last_name' => $candidate->last_name ?: $candidate->nickname,
                    'nickname' => $candidate->nickname,
                    'phone' => $candidate->phone,
                    'date_of_birth' => $candidate->date_of_birth,
                    'address' => $candidate->address,
                    'city' => $candidate->city,
                    'country' => $candidate->country,
                    'postal_code' => $candidate->postal_code,
                    'biography' => $candidate->biography,
                    'membership_status' => 'active',
                ]);
                
                // Assign member role if not already assigned
                if (!$existingUser->hasRole('member')) {
                    $existingUser->assignRole('member');
                    \Log::info('Assigned member role to existing user', [
                        'user_id' => $existingUser->id,
                        'email' => $existingUser->email
                    ]);
                }
                
                // Remove candidate role if it exists
                if ($existingUser->hasRole('candidate')) {
                    $existingUser->removeRole('candidate');
                    \Log::info('Removed candidate role from user', [
                        'user_id' => $existingUser->id,
                        'email' => $existingUser->email
                    ]);
                }
                
                // Update candidate with user_id
                $candidate->user_id = $existingUser->id;
                
            } else {
                // Generate a random password
                $password = Str::random(12);
                
                // Create new user
                $user = User::create([
                    'first_name' => $candidate->first_name,
                    'last_name' => $candidate->last_name ?: $candidate->nickname,
                    'nickname' => $candidate->nickname,
                    'email' => $candidate->email,
                    'password' => Hash::make($password),
                    'phone' => $candidate->phone,
                    'date_of_birth' => $candidate->date_of_birth,
                    'address' => $candidate->address,
                    'city' => $candidate->city,
                    'country' => $candidate->country,
                    'postal_code' => $candidate->postal_code,
                    'biography' => $candidate->biography,
                    'membership_status' => 'active',
                    'email_verified_at' => now(),
                ]);
                
                // Assign member role
                $user->assignRole('member');
                
                // Update candidate with user_id
                $candidate->user_id = $user->id;
                
                \Log::info('Created new user for candidate', [
                    'candidate_id' => $candidate->id,
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
                
                // Here you might want to send an email to the user with their credentials
                // Mail::to($user->email)->send(new NewMemberWelcome($user, $password));
            }
            
            // Update candidate status and timestamp
            $candidate->status = 'accepted';
            $candidate->status_updated_at = now();
            $candidate->save();
            
            \DB::commit();
            
            \Log::info('Successfully processed candidate acceptance', [
                'candidate_id' => $candidate->id,
                'user_id' => $candidate->user_id,
                'status' => $candidate->status
            ]);
            
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error processing candidate acceptance', [
                'candidate_id' => $candidate->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-throw the exception to ensure the update fails
            throw $e;
        }
    }

    /**
     * Handle the Candidate "deleted" event.
     */
    public function deleted(Candidate $candidate): void
    {
        //
    }

    /**
     * Handle the Candidate "restored" event.
     */
    public function restored(Candidate $candidate): void
    {
        //
    }

    /**
     * Handle the Candidate "force deleted" event.
     */
    public function forceDeleted(Candidate $candidate): void
    {
        //
    }
}
