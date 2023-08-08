<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'profile:admin'])->group(function () {
    Route::get('/email', [App\Http\Controllers\EmailController::class, 'index'])->name('email');
    Route::post('/email', [App\Http\Controllers\EmailController::class, 'store']);

    Route::get('/requests', [App\Http\Controllers\PurchaseRequestController::class, 'index'])->name('requests');
});
