<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'suppliers'], function () {
        Route::middleware('can:get.suppliers')->get('/', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers');
        Route::middleware('can:get.supplier')->get('/view/{id}', [App\Http\Controllers\SupplierController::class, 'supplier'])->name('supplier');
        Route::middleware('can:get.supplier.form')->get('/register', [App\Http\Controllers\SupplierController::class, 'showRegistrationForm'])->name('supplier.form');
        Route::middleware('can:post.supplier.register')->post('/register', [App\Http\Controllers\SupplierController::class, 'register'])->name('supplier.register');

        Route::middleware('can:post.delete')->post('/delete/{id}', [App\Http\Controllers\SupplierController::class, 'delete']);
        Route::middleware('can:post.supplier.update')->post('/update/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');

        // acessar detalhes de suprimentos
        Route::middleware('can:get.supplier.service.detail')->get('/service/{id}/details', [App\Http\Controllers\ServiceController::class, 'details'])->name('supplier.service.detail');
        Route::middleware('can:get.supplier.product.detail')->get('/product/{id}/details', [App\Http\Controllers\ProductController::class, 'details'])->name('supplier.product.detail');
        Route::middleware('can:get.supplier.contract.detail')->get('/contract/{id}/details', [App\Http\Controllers\ContractController::class, 'details'])->name('supplier.contract.detail');
    });
});
