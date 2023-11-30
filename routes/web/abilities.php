<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'abilities'], function () {
        Route::middleware('can:get.abilities.index')->get('/', [App\Http\Controllers\AbilitiesController::class, 'index'])->name('abilities.index');
        Route::get('/profile', [App\Http\Controllers\AbilitiesController::class, 'profile'])->name('abilities.profile');
        Route::post('/profile/create', [App\Http\Controllers\AbilitiesController::class, 'create'])->name('abilities.profile.create');
    });
});
