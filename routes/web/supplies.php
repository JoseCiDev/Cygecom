<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'profile:suprimentos_hkm,suprimentos_inp'])->group(function () {

    Route::group(['prefix' => 'supplies'], function () {
        Route::get('index', [App\Http\Controllers\SuppliesController::class, 'index'])->name('supplies.index');

        Route::middleware(['supplies.group:inp,hkm'])->group(function () {
            Route::get('service', [App\Http\Controllers\SuppliesController::class, 'service'])->name('supplies.service');
            Route::get('product', [App\Http\Controllers\SuppliesController::class, 'product'])->name('supplies.product');
            Route::get('contract', [App\Http\Controllers\SuppliesController::class, 'contract'])->name('supplies.contract');
        });

        Route::get('service/{id}/details', [App\Http\Controllers\ServiceController::class, 'details'])->name('supplies.service.detail');
        Route::get('product/{id}/details', [App\Http\Controllers\ProductController::class, 'details'])->name('supplies.product.detail');
        Route::get('contract/{id}/details', [App\Http\Controllers\ContractController::class, 'details'])->name('supplies.contract.detail');

        Route::post('request/status/update/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'updateStatusFromSupplies'])->name('supplies.request.status.update');
    });
});
