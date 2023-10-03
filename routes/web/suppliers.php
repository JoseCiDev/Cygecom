<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'profile:gestor_fornecedores'])->group(function () {
    Route::group(['prefix' => 'suppliers'], function () {
        Route::get('/', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers');
        Route::get('/view/{id}', [App\Http\Controllers\SupplierController::class, 'supplier'])->name('supplier');
        Route::get('/register', [App\Http\Controllers\SupplierController::class, 'showRegistrationForm'])->name('supplier.form');

        Route::post('/delete/{id}', [App\Http\Controllers\SupplierController::class, 'delete']);
        Route::post('/update/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');

        // acessar detalhes de suprimentos
        Route::get('/service/{id}/details', [App\Http\Controllers\ServiceController::class, 'details'])->name('supplier.service.detail');
        Route::get('/product/{id}/details', [App\Http\Controllers\ProductController::class, 'details'])->name('supplier.product.detail');
        Route::get('/contract/{id}/details', [App\Http\Controllers\ContractController::class, 'details'])->name('supplier.contract.detail');
    });
});
