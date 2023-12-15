<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::middleware('can:get.profile.index')->get('/index', [App\Http\Controllers\UserProfileController::class, 'index'])->name('profile.index');
        Route::middleware('can:get.profile.create')->get('/create', [App\Http\Controllers\UserProfileController::class, 'create'])->name('profile.create');
        Route::middleware('can:get.profile.edit')->get('/edit/{userProfile}', [App\Http\Controllers\UserProfileController::class, 'edit'])->name('profile.edit');
        Route::middleware('can:post.profile.store')->post('/store', [App\Http\Controllers\UserProfileController::class, 'store'])->name('profile.store');
        Route::middleware('can:post.profile.update')->post('/update/{userProfile}', [App\Http\Controllers\UserProfileController::class, 'update'])->name('profile.update');
        Route::middleware('can:post.profile.destroy')->post('/destroy/{userProfile}', [App\Http\Controllers\UserProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
