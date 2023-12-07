<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'user'], function () {
        Route::middleware('can:get.register')->get('/register', [App\Http\Controllers\Auth\UserController::class, 'create'])->name('register');
        Route::middleware('can:post.store')->post('/register', [App\Http\Controllers\Auth\UserController::class, 'store']);
        Route::middleware('can:post.destroy')->post('/delete/{id}', [App\Http\Controllers\Auth\UserController::class, 'destroy']);
    });

    Route::group(['prefix' => 'users'], function () {
        Route::middleware('can:get.users')->get('/', [App\Http\Controllers\Auth\UserController::class, 'index'])->name('users');
        Route::middleware('can:get.user')->get('/{id}', [App\Http\Controllers\Auth\UserController::class, 'edit'])->name('user');
        Route::middleware('can:post.user.update')->post('/{user}', [App\Http\Controllers\Auth\UserController::class, 'update'])->name('user.update');
    });
});
