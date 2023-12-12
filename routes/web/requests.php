<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'requests'], function () {
        Route::middleware('can:get.requests.index')->get('/', [App\Http\Controllers\PurchaseRequestController::class, 'index'])->name('requests.index');
        Route::middleware('can:get.requests.index.own')->get('/own', [App\Http\Controllers\PurchaseRequestController::class, 'indexOwn'])->name('requests.index.own');
        Route::middleware('can:get.requests.dashboard')->get('/dashboard', [App\Http\Controllers\PurchaseRequestController::class, 'dashboard'])->name('requests.dashboard');
        Route::middleware('can:get.requests.edit')->get('/{type}/edit/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'edit'])->name('requests.edit');
        Route::middleware('can:post.requests.destroy')->post('/destroy/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'destroy'])->name('requests.destroy');
        Route::middleware('can:delete.requests.file.delete')->delete('/remove-file/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'fileDelete'])->name('requests.file.delete');

        Route::group(['prefix' => 'service'], function () {
            Route::middleware('can:get.requests.service.create')->get('/create/{id?}', [App\Http\Controllers\ServiceController::class, 'create'])->name('requests.service.create');
            Route::middleware('can:post.requests.service.store')->post('/store', [App\Http\Controllers\ServiceController::class, 'store'])->name('requests.service.store');
            Route::middleware('can:post.requests.service.update')->post('/update/{id}', [App\Http\Controllers\ServiceController::class, 'update'])->name('requests.service.update');
        });

        Route::group(['prefix' => 'product'], function () {
            Route::middleware('can:get.requests.product.create')->get('/create/{id?}', [App\Http\Controllers\ProductController::class, 'create'])->name('requests.product.create');
            Route::middleware('can:post.requests.product.store')->post('/store', [App\Http\Controllers\ProductController::class, 'store'])->name('requests.product.store');
            Route::middleware('can:post.requests.product.update')->post('/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('requests.product.update');
        });

        Route::group(['prefix' => 'contract'], function () {
            Route::middleware('can:get.requests.contract.create')->get('/create/{id?}', [App\Http\Controllers\ContractController::class, 'create'])->name('requests.contract.create');
            Route::middleware('can:post.requests.contract.store')->post('/store', [App\Http\Controllers\ContractController::class, 'store'])->name('requests.contract.store');
            Route::middleware('can:post.requests.contract.update')->post('/update/{id}', [App\Http\Controllers\ContractController::class, 'update'])->name('requests.contract.update');
        });
    });
});
