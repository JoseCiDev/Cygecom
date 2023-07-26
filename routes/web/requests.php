<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/requests/own', [App\Http\Controllers\PurchaseRequestController::class, 'ownRequests'])->name('requests.own');

    Route::group(['prefix' => 'request'], function () {
        Route::get('/links', [App\Http\Controllers\PurchaseRequestController::class, 'formList'])->name('request.links');

        Route::get('/service/register/{id?}', [App\Http\Controllers\ServiceController::class, 'serviceForm'])->name('request.service.register');
        Route::post('/service/register', [App\Http\Controllers\ServiceController::class, 'registerService']);
        Route::post('/service/update/{id}', [App\Http\Controllers\ServiceController::class, 'updateService'])->name('request.service.update');

        Route::get('/product/register/{id?}', [App\Http\Controllers\ProductController::class, 'productForm'])->name('request.product.register');
        Route::post('/product/register', [App\Http\Controllers\ProductController::class, 'registerProduct']);
        Route::post('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'updateProduct'])->name('request.product.update');

        Route::get('/contract/register/{id?}', [App\Http\Controllers\ContractController::class, 'contractForm'])->name('request.contract.register');
        Route::post('/contract/register', [App\Http\Controllers\ContractController::class, 'registerContract']);
        Route::post('/contract/update/{id}', [App\Http\Controllers\ContractController::class, 'updateContract'])->name('request.contract.update');

        Route::get('/{type}/edit/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'edit'])->name('request.edit');

        Route::post('/delete/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'delete'])->name('request.delete');
    });
});
