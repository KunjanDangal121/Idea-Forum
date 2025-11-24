<?php

use App\Livewire\IdeasIndex;
use Illuminate\Support\Facades\Route;

// This loads your "Ideas List" component as the homepage
Route::get('/', IdeasIndex::class)->name('idea.index');

// If you have a dashboard or auth routes (like login/register), 
// they usually go below here. If your file had other code below, 
// make sure to keep it! 
//
// For example, standard auth routes often look like this:
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'), // Or just 'auth' depending on your setup
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
