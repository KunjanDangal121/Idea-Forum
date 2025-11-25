<?php

use App\Livewire\CreateIdea;
use App\Livewire\IdeasIndex;
use App\Livewire\ShowIdea;
use Illuminate\Support\Facades\Route;

// =======================================================
// A. FIXES AND UNPROTECTED (Public) Routes
// =======================================================

// FIX: Defines the 'home' route used by authentication scaffolding.
Route::get('/home', function () {
    return redirect()->route('idea.index');
})->name('home');

// LIVEWIRE: Idea Index Page (Your Homepage)
Route::get('/', IdeasIndex::class)->name('idea.index');


// =======================================================
// B. PROTECTED ROUTES (Requiring Login)
// =======================================================

Route::middleware(['auth'])->group(function () {
    
    // 1. LIVEWIRE: The Create Idea Form Page (STATIC ROUTE)
    Route::get('/ideas/create', CreateIdea::class)->name('idea.create');
    
    // 2. AUTHENTICATION: Dashboard (redirected to your index page)
    Route::get('/dashboard', function () {
        return redirect()->route('idea.index');
    })->name('dashboard');
    
    
    // === NEW: MISSING PROFILE/SETTINGS PLACEHOLDER ROUTES ===
    
    // FIX: Placeholder for 'profile.edit' to resolve sidebar crash
    Route::get('/profile/settings', function () {
        return view('dashboard');
    })->name('profile.edit');
    
    // FIX: Placeholder for 'profile.update' (used by forms)
    Route::put('/profile/update', function () {
        return redirect()->back();
    })->name('profile.update');
    
    // FIX: Placeholder for 'profile.destroy' (used by forms)
    Route::delete('/profile/delete', function () {
        return redirect()->route('idea.index');
    })->name('profile.destroy');

});


// =======================================================
// C. DYNAMIC PUBLIC ROUTES (Must come last to avoid conflicts)
// =======================================================

// LIVEWIRE: Idea Detail Page
Route::get('/ideas/{idea:id}', ShowIdea::class)->name('idea.show');
