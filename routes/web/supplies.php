<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'profile:suprimentos_hkm,suprimentos_inp'])->group(function () {
    Route::get('/supplies/index', [App\Http\Controllers\SuppliesController::class, 'index'])->name('supplies.index');

    Route::middleware(['supplies.group:inp,hkm'])->group(function () {
        Route::get('/supplies/service/{suppliesGroup}/status/{status?}', [App\Http\Controllers\SuppliesController::class, 'service'])->name('supplies.service.filter');
        Route::get('/supplies/product/{suppliesGroup}/status/{status?}', [App\Http\Controllers\SuppliesController::class, 'product'])->name('supplies.product.filter');
        Route::get('/supplies/contract/{suppliesGroup}/status/{status?}', [App\Http\Controllers\SuppliesController::class, 'contract'])->name('supplies.contract.filter');
    });

    Route::get('/supplies/service/{id}/details', [App\Http\Controllers\ServiceController::class, 'serviceDetails'])->name('supplies.service.detail');
    Route::get('/supplies/product/{id}/details', [App\Http\Controllers\ProductController::class, 'productDetails'])->name('supplies.product.detail');
    Route::get('/supplies/contract/{id}/details', [App\Http\Controllers\ContractController::class, 'contractDetails'])->name('supplies.contract.detail');

    Route::post('supplies/request/status/update/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'updateStatusFromSupplies'])->name('supplies.request.status.update');
});
