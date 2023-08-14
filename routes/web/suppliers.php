<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'profile:gestor_fornecedores'])->group(function () {
    Route::group(['prefix' => 'suppliers'], function () {
        Route::get('/', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers');
        Route::get('/view/{id}', [App\Http\Controllers\SupplierController::class, 'supplier'])->name('supplier');
        Route::get('/register', [App\Http\Controllers\SupplierController::class, 'showRegistrationForm'])->name('supplier.form');

        Route::post('/delete/{id}', [App\Http\Controllers\SupplierController::class, 'delete']);
        Route::post('/update/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');
    });
});
