<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'updateProfile']);

    Route::middleware(['check_profile'])->group(function () {
        Route::get('/user/register', [App\Http\Controllers\Auth\UserController::class, 'showRegistrationForm'])->name('register');
        Route::post('/user/register', [App\Http\Controllers\Auth\UserController::class, 'register']);

        Route::get('/users', [App\Http\Controllers\Auth\UserController::class, 'showUsers'])->name('users');
        Route::get('/user/{id}', [App\Http\Controllers\Auth\UserController::class, 'showUser'])->name('user');

        Route::post('/user/{id}', [App\Http\Controllers\Auth\UserController::class, 'userUpdate'])->name('userUpdate');
    });
});
