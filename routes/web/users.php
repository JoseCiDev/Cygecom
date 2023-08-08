<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'profile:gestor_usuarios'])->group(function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('register', [App\Http\Controllers\Auth\UserController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [App\Http\Controllers\Auth\UserController::class, 'register']);
        Route::post('delete/{id}', [App\Http\Controllers\Auth\UserController::class, 'delete']);
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [App\Http\Controllers\Auth\UserController::class, 'showUsers'])->name('users');
        Route::get('/{id}', [App\Http\Controllers\Auth\UserController::class, 'showUser'])->name('user');
    });
});
