<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'abilities'], function () {
        Route::middleware('can:get.abilities.index')->get('/', [App\Http\Controllers\AbilitiesController::class, 'index'])->name('abilities.index');
        Route::middleware('can:get.abilities.profile.create')->get('/profile', [App\Http\Controllers\AbilitiesController::class, 'profile'])->name('abilities.profile.create');
        Route::middleware('can:post.abilities.profile.store')->post('/profile/store', [App\Http\Controllers\AbilitiesController::class, 'store'])->name('abilities.profile.store');
        Route::middleware('can:get.abilities.user')->get('/abilities/user/{id}', [App\Http\Controllers\AbilitiesController::class, 'user'])->name('abilities.user');
    });
});
