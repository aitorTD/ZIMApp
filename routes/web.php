<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', function () {
    return view('index');
})->name('home');

// Include admin routes
require __DIR__.'/admin.php';

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard with user info and candidates list
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Candidate management
    Route::resource('candidates', \App\Http\Controllers\CandidateController::class)->except(['show', 'edit', 'index']);
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';
