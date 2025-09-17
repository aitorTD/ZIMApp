<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', function () {
    return view('index');
})->name('home');

// Include admin routes
require __DIR__.'/admin.php';

// Include test routes
require __DIR__.'/test-html.php';
require __DIR__.'/test-show.php';
require __DIR__.'/test-minimal.php';

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard with user info and candidates list
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Test route for debugging candidate notes (JSON)
    Route::get('/test/candidate/{candidate}', function(\App\Models\Candidate $candidate) {
        $candidate->load(['notes.user', 'user']);
        return response()->json([
            'candidate' => $candidate->toArray(),
            'notes' => $candidate->notes->toArray(),
            'user' => $candidate->user->toArray()
        ]);
    });

    // Test route for HTML view
    Route::get('/test-view', function() {
        return view('test');
    });

    // Test candidate show route
    Route::get('/test-candidate/{candidate}', function(\App\Models\Candidate $candidate) {
        $candidate->load(['notes.user', 'user']);
        return view('candidates.show', [
            'candidate' => $candidate,
            'notes' => $candidate->notes
        ]);
    });
    
    // Candidate management - protected by register-candidate gate
    Route::middleware(['can:register-candidate'])->group(function () {
        Route::resource('candidates', \App\Http\Controllers\CandidateController::class)->except(['index']);
        
        // Candidate registration form - only accessible to admins/members
        Route::get('/candidates/register', [\App\Http\Controllers\CandidateController::class, 'create'])
            ->name('candidates.register');
    });
    
    // Candidate notes routes (nested under candidates) - protected by register-candidate gate
    Route::middleware(['can:register-candidate'])->group(function () {
        Route::resource('candidates.notes', \App\Http\Controllers\CandidateNoteController::class)
            ->only(['store', 'update', 'destroy'])
            ->names([
                'store' => 'candidates.notes.store',
                'update' => 'candidates.notes.update',
                'destroy' => 'candidates.notes.destroy'
            ]);
    });
    
    // Sponsor routes
    Route::prefix('sponsor')->name('sponsor.')->group(function () {
        Route::get('/my-candidates', [\App\Http\Controllers\SponsorController::class, 'myCandidates'])
            ->name('my-candidates');
        Route::get('/create', [\App\Http\Controllers\SponsorController::class, 'create'])
            ->name('create');
        Route::post('/', [\App\Http\Controllers\SponsorController::class, 'store'])
            ->name('store');
        Route::put('/{id}', [\App\Http\Controllers\SponsorController::class, 'update'])
            ->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\SponsorController::class, 'destroy'])
            ->name('destroy');
    });
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';

// Test routes - only in local environment
if (app()->environment('local')) {
    require __DIR__.'/test.php';
}
