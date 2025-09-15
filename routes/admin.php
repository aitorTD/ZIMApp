<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

// Admin routes group with auth and role middleware
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Members resource routes
        Route::prefix('members')->name('members.')->group(function () {
            Route::get('/', [AdminController::class, 'members'])->name('index');
            Route::get('/create', [AdminController::class, 'createMember'])->name('create');
            Route::post('/', [AdminController::class, 'storeMember'])->name('store');
            Route::get('/{user}/edit', [AdminController::class, 'editMember'])->name('edit');
            Route::put('/{user}', [AdminController::class, 'updateMember'])->name('update');
            Route::delete('/{user}', [AdminController::class, 'deleteMember'])->name('destroy');
        });

        // Candidates resource routes
        Route::prefix('candidates')->name('candidates.')->group(function () {
            Route::get('/', [AdminController::class, 'candidates'])->name('index');
            Route::get('/create', [AdminController::class, 'createCandidate'])->name('create');
            Route::post('/', [AdminController::class, 'storeCandidate'])->name('store');
            Route::get('/{user}/edit', [AdminController::class, 'editCandidate'])->name('edit');
            Route::put('/{user}', [AdminController::class, 'updateCandidate'])->name('update');
            Route::delete('/{user}', [AdminController::class, 'deleteCandidate'])->name('destroy');
        });
    });
