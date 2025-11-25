<?php

use App\Livewire\IdeasIndex;
use App\Livewire\ShowIdea;
use Illuminate\Support\Facades\Route;

// 1. FIX: Define the 'home' route. Starter kits like Breeze/Jetstream
//    redirect here after successful login/registration. We point it to the Idea Index.
Route::get('/home', function () {
    return redirect()->route('idea.index');
})->name('home');

// 2. LIVEWIRE: Idea Index Page (Your Homepage)
Route::get('/', IdeasIndex::class)->name('idea.index');

// 3. LIVEWIRE: Idea Detail Page (The Show Page)
Route::get('/ideas/{idea:id}', ShowIdea::class)->name('idea.show');


// 4. AUTHENTICATION (Dashboard/Profile Routes)
//    These routes are typically included if you ran 'php artisan breeze:install' or similar.
Route::middleware([
    'auth', // <--- MUST be 'auth', not 'auth:sanctum'
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // CHANGE THIS LINE to redirect to your Idea Index Page
        return redirect()->route('idea.index');
    })->name('dashboard');
});
