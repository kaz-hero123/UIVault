<?php

use App\Http\Controllers\UploadController;
use App\Models\UiInspiration;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return UiInspiration::inInbox()->exists()
        ? redirect()->route('inbox')
        : redirect()->route('explorer');
});

// Upload
Route::get('/upload', [UploadController::class, 'create'])->name('upload.create');
Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');

// Inbox
Route::get('/inbox', fn () => view('inbox'))->name('inbox');

// Explorer
Route::get('/explorer', fn () => view('explorer'))->name('explorer');

// Categories
Route::get('/categories', fn () => view('categories'))->name('categories');

// Edit Inspiration
Route::get('/inspirations/{inspiration}/edit', function (UiInspiration $inspiration) {
    return view('inspirations.edit', compact('inspiration'));
})->name('inspirations.edit');
