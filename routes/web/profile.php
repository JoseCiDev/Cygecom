<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::middleware('can:get.profile.create')->get('/profile', [App\Http\Controllers\UserProfileController::class, 'create'])->name('profile.create');
        Route::middleware('can:post.profile.store')->post('/profile/store', [App\Http\Controllers\UserProfileController::class, 'store'])->name('profile.store');
    });
});
