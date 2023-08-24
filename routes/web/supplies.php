<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'profile:suprimentos_hkm,suprimentos_inp'])->group(function () {

    Route::group(['prefix' => 'supplies'], function () {
        Route::get('index', [App\Http\Controllers\SuppliesController::class, 'index'])->name('supplies.index');

        Route::middleware(['supplies.group:suprimentos_inp,suprimentos_hkm'])->group(function () {
            Route::get('service', [App\Http\Controllers\SuppliesController::class, 'service'])->name('supplies.service');
            Route::get('product', [App\Http\Controllers\SuppliesController::class, 'product'])->name('supplies.product');
            Route::get('contract', [App\Http\Controllers\SuppliesController::class, 'contract'])->name('supplies.contract');
        });

        Route::get('service/{id}/details', [App\Http\Controllers\ServiceController::class, 'details'])->name('supplies.service.detail');
        Route::get('product/{id}/details', [App\Http\Controllers\ProductController::class, 'details'])->name('supplies.product.detail');
        Route::get('contract/{id}/details', [App\Http\Controllers\ContractController::class, 'details'])->name('supplies.contract.detail');

        Route::post('request/status/update/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'updateStatusFromSupplies'])->name('supplies.request.status.update');
        Route::post('request/service/amount/update/{id}', [App\Http\Controllers\ServiceController::class, 'updateService'])->name('supplies.request.service.amount.update');
        Route::post('request/contract/amount/update/{id}', [App\Http\Controllers\ContractController::class, 'updateContract'])->name('supplies.request.contract.amount.update');
        Route::post('request/product/amount/update/{id}', [App\Http\Controllers\ProductController::class, 'updateProduct'])->name('supplies.request.product.amount.update');
    });
});
