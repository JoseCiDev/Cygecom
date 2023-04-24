<?php

use Illuminate\Support\Facades\{Auth, Route};

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile');

    Route::middleware(['check_profile'])->group(function () {
        Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
    });
});
