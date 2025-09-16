<?php

use App\Models\Candidate;
use Illuminate\Support\Facades\Route;

Route::get('/test-show/{candidate}', function(Candidate $candidate) {
    $candidate->load(['notes.user', 'user']);
    
    // Return raw HTML without any layout
    $content = view('candidates.show', [
        'candidate' => $candidate,
        'notes' => $candidate->notes
    ])->render();
    
    return $content;
});
