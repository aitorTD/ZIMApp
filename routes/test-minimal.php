<?php

use App\Models\Candidate;
use Illuminate\Support\Facades\Route;

Route::get('/test-minimal/{candidate}', function(Candidate $candidate) {
    $candidate->load(['notes.user']);
    
    // Return a minimal HTML response
    return "<!DOCTYPE html>
    <html>
    <head><title>Test Minimal</title></head>
    <body>
        <h1>Test Candidate: {$candidate->id}</h1>
        <h2>Notes:</h2>
        <ul>";
        
        foreach($candidate->notes as $note) {
            echo "<li>{$note->content} (by {$note->user->name})</li>";
        }
        
        echo "</ul></body></html>";
});
