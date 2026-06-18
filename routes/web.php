<?php

use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Upload
Route::get('/upload', [UploadController::class, 'create'])->name('upload.create');
Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');

// Inbox
Route::get('/inbox', fn () => view('inbox'))->name('inbox');

// Explorer
Route::get('/explorer', fn () => view('explorer'))->name('explorer');
