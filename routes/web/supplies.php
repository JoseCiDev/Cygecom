<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'supplies'], function () {
        Route::middleware('can:get.supplies.index')->get('/index', [App\Http\Controllers\SuppliesController::class, 'index'])->name('supplies.index');

        Route::middleware('can:get.supplies.service')->get('/service', [App\Http\Controllers\SuppliesController::class, 'service'])->name('supplies.service');
        Route::middleware('can:get.supplies.product')->get('/product', [App\Http\Controllers\SuppliesController::class, 'product'])->name('supplies.product');
        Route::middleware('can:get.supplies.contract')->get('/contract', [App\Http\Controllers\SuppliesController::class, 'contract'])->name('supplies.contract');

        Route::middleware('can:get.supplies.service.detail')->get('/service/{id}/details', [App\Http\Controllers\ServiceController::class, 'details'])->name('supplies.service.detail');
        Route::middleware('can:get.supplies.product.detail')->get('/product/{id}/details', [App\Http\Controllers\ProductController::class, 'details'])->name('supplies.product.detail');
        Route::middleware('can:get.supplies.contract.detail')->get('/contract/{id}/details', [App\Http\Controllers\ContractController::class, 'details'])->name('supplies.contract.detail');

        Route::middleware('can:post.supplies.request.service.update')->post('/request/service/update/{id}', [App\Http\Controllers\ServiceController::class, 'updateService'])->name('supplies.request.service.update');
        Route::middleware('can:post.supplies.request.contract.update')->post('/request/contract/update/{id}', [App\Http\Controllers\ContractController::class, 'updateContract'])->name('supplies.request.contract.update');
        Route::middleware('can:post.supplies.request.product.update')->post('/request/product/update/{id}', [App\Http\Controllers\ProductController::class, 'updateProduct'])->name('supplies.request.product.update');
    });
});
