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
    
    // 1. LIVEWIRE: The Create Idea Form Page (STATIC ROUTE - Must come first)
    Route::get('/ideas/create', CreateIdea::class)->name('idea.create');
    
    // 2. AUTHENTICATION: Dashboard (redirected to your index page)
    Route::get('/dashboard', function () {
        return redirect()->route('idea.index');
    })->name('dashboard');
    
});


// =======================================================
// C. DYNAMIC PUBLIC ROUTES (Must come last to avoid conflicts)
// =======================================================

// LIVEWIRE: Idea Detail Page (The Show Page)
Route::get('/ideas/{idea:id}', ShowIdea::class)->name('idea.show');
