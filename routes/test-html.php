<?php

use App\Models\Candidate;
use Illuminate\Support\Facades\Route;

Route::get('/test-html', function () {
    $candidate = Candidate::with(['notes.user'])->find(10);
    
    // Return raw HTML without any layout
    return '<!DOCTYPE html><html><head><title>Test HTML</title></head><body>' . 
           view('components.candidate-notes', ['candidate' => $candidate])->render() . 
           '</body></html>';
});
