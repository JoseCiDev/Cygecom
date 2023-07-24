<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'profile:suprimentos_hkm,suprimentos_inp'])->group(function () {
    Route::get('/supplies/index', [App\Http\Controllers\SuppliesController::class, 'index'])->name('supplies.index');
    Route::get('/supplies/service/{filter?}', [App\Http\Controllers\SuppliesController::class, 'service'])->name('supplies.service');
    Route::get('/supplies/product/{filter?}', [App\Http\Controllers\SuppliesController::class, 'product'])->name('supplies.product');
    Route::get('/supplies/contract/{filter?}', [App\Http\Controllers\SuppliesController::class, 'contract'])->name('supplies.contract');

    Route::get('/supplies/service/{id}/detail', [App\Http\Controllers\ServiceController::class, 'serviceDetails'])->name('supplies.service.detail');
    Route::get('/supplies/product/{id}/details', [App\Http\Controllers\ProductController::class, 'productDetails'])->name('supplies.product.detail');
    Route::get('/supplies/contract/{id}/details', [App\Http\Controllers\ContractController::class, 'contractDetails'])->name('supplies.contract.detail');
});
