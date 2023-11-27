<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'abilities'], function () {
        Route::middleware('can:get.abilities.index')->get('/', [App\Http\Controllers\AbilitiesController::class, 'index'])->name('abilities.index');
    });
});
