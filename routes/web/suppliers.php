<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'suppliers'], function () {
        Route::middleware('can:get.suppliers.index')->get('/', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers.index');
        Route::middleware('can:get.suppliers.edit')->get('/edit/{id}', [App\Http\Controllers\SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::middleware('can:get.suppliers.create')->get('/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('suppliers.create');
        Route::middleware('can:post.suppliers.store')->post('/store', [App\Http\Controllers\SupplierController::class, 'store'])->name('suppliers.store');
        Route::middleware('can:post.suppliers.destroy')->post('/destroy/{id}', [App\Http\Controllers\SupplierController::class, 'destroy'])->name('suppliers.destroy');
        Route::middleware('can:post.suppliers.update')->post('/update/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('suppliers.update');

        // acessar detalhes de suprimentos
        Route::middleware('can:get.supplier.service.detail')->get('/service/{id}/details', [App\Http\Controllers\ServiceController::class, 'show'])->name('supplier.service.detail');
        Route::middleware('can:get.supplier.product.detail')->get('/product/{id}/details', [App\Http\Controllers\ProductController::class, 'show'])->name('supplier.product.detail');
        Route::middleware('can:get.supplier.contract.detail')->get('/contract/{id}/details', [App\Http\Controllers\ContractController::class, 'show'])->name('supplier.contract.detail');
    });
});
