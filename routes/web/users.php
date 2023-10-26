<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'profile:gestor_usuarios'])->group(function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('register', [App\Http\Controllers\Auth\UserController::class, 'create'])->name('register');
        Route::post('register', [App\Http\Controllers\Auth\UserController::class, 'store']);
        Route::post('delete/{id}', [App\Http\Controllers\Auth\UserController::class, 'destroy']);
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [App\Http\Controllers\Auth\UserController::class, 'index'])->name('users');
        Route::get('/{id}', [App\Http\Controllers\Auth\UserController::class, 'edit'])->name('user');
    });
});
