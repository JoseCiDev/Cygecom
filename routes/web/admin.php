<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'profile:admin'])->group(function () {
    Route::get('/email', [App\Http\Controllers\EmailController::class, 'index'])->name('email');
    Route::post('/email', [App\Http\Controllers\EmailController::class, 'store']);

    Route::group(['prefix' => 'suppliers'], function () {
        Route::get('/', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers');
        Route::get('/view/{id}', [App\Http\Controllers\SupplierController::class, 'supplier'])->name('supplier');
        Route::get('/register', [App\Http\Controllers\SupplierController::class, 'showRegistrationForm'])->name('supplier.form');

        Route::post('/delete/{id}', [App\Http\Controllers\SupplierController::class, 'delete']);
        Route::post('/update/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');
    });

    Route::get('/requests', [App\Http\Controllers\PurchaseRequestController::class, 'index'])->name('requests');
});
