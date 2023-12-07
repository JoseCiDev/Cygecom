<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'users'], function () {
        Route::middleware('can:get.users.index')->get('/', [App\Http\Controllers\Auth\UserController::class, 'index'])->name('users.index');
        Route::middleware('can:get.users.create')->get('/create', [App\Http\Controllers\Auth\UserController::class, 'create'])->name('users.create');
        Route::middleware('can:post.users.store')->post('/store', [App\Http\Controllers\Auth\UserController::class, 'store'])->name('users.store');
        Route::middleware('can:get.users.show')->get('/user/{id}', [App\Http\Controllers\Auth\UserController::class, 'show'])->name('users.show');
        Route::middleware('can:post.users.update')->post('/{user}', [App\Http\Controllers\Auth\UserController::class, 'update'])->name('users.update');
        Route::middleware('can:post.users.destroy')->post('/delete/{id}', [App\Http\Controllers\Auth\UserController::class, 'destroy'])->name('users.destroy');
    });
});
