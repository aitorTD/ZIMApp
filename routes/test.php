<?php

use App\Models\Candidate;
use App\Models\User;
use App\Models\CandidateNote;
use Illuminate\Support\Facades\Route;

Route::get('/test/candidate-notes', function () {
    // Create a test user if not exists
    $user = User::first();
    
    if (!$user) {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    // Create a test candidate
    $candidate = Candidate::create([
        'first_name' => 'Test',
        'last_name' => 'Candidate',
        'email' => 'test.candidate@example.com',
        'user_id' => $user->id,
        'status' => 'pending',
        'application_date' => now(),
    ]);

    // Add some test notes
    $note1 = $candidate->notes()->create([
        'user_id' => $user->id,
        'content' => 'This is a public test note',
        'is_private' => false,
    ]);

    $note2 = $candidate->notes()->create([
        'user_id' => $user->id,
        'content' => 'This is a private test note',
        'is_private' => true,
    ]);

    return [
        'candidate_id' => $candidate->id,
        'notes' => $candidate->notes->toArray(),
    ];
});
