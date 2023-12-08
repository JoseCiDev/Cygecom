<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::middleware('can:get.profile.index')->get('/index', [App\Http\Controllers\UserProfileController::class, 'index'])->name('profile.index');
        Route::middleware('can:get.profile.create')->get('/create', [App\Http\Controllers\UserProfileController::class, 'create'])->name('profile.create');
        Route::middleware('can:post.profile.store')->post('/store', [App\Http\Controllers\UserProfileController::class, 'store'])->name('profile.store');
        Route::middleware('can:post.profile.destroy')->post('/destroy/{name}', [App\Http\Controllers\UserProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
