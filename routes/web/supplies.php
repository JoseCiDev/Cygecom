<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'supplies'], function () {
        Route::middleware('can:get.supplies.index')->get('/', [App\Http\Controllers\SuppliesController::class, 'index'])->name('supplies.index');

        Route::group(['prefix' => 'service'], function () {
            Route::middleware('can:get.supplies.service.index')->get('/index', [App\Http\Controllers\SuppliesController::class, 'serviceIndex'])->name('supplies.service.index');
            Route::middleware('can:get.supplies.service.show')->get('/show/{id}', [App\Http\Controllers\ServiceController::class, 'show'])->name('supplies.service.show');
            Route::middleware('can:post.supplies.service.update')->post('/update/{purchaseRequest}', [App\Http\Controllers\SuppliesController::class, 'updateService'])->name('supplies.service.update');
        });

        Route::group(['prefix' => 'product'], function () {
            Route::middleware('can:get.supplies.product.index')->get('/index', [App\Http\Controllers\SuppliesController::class, 'productIndex'])->name('supplies.product.index');
            Route::middleware('can:get.supplies.product.show')->get('/show/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('supplies.product.show');
            Route::middleware('can:post.supplies.product.update')->post('/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('supplies.product.update');
        });

        Route::group(['prefix' => 'contract'], function () {
            Route::middleware('can:get.supplies.contract.index')->get('/index', [App\Http\Controllers\SuppliesController::class, 'contractIndex'])->name('supplies.contract.index');
            Route::middleware('can:get.supplies.contract.show')->get('/show/{id}', [App\Http\Controllers\ContractController::class, 'show'])->name('supplies.contract.show');
            Route::middleware('can:post.supplies.contract.update')->post('/update/{id}', [App\Http\Controllers\ContractController::class, 'update'])->name('supplies.contract.update');
        });
    });
});
