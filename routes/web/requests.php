<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/request/links', [App\Http\Controllers\PurchaseRequestController::class, 'formList'])->name('request.links');
    Route::get('/requests/own', [App\Http\Controllers\PurchaseRequestController::class, 'ownRequests'])->name('requests.own');

    Route::get('/request/service/register/{id?}', [App\Http\Controllers\ServiceController::class, 'serviceForm'])->name('request.service.register');
    Route::post('/request/service/register', [App\Http\Controllers\ServiceController::class, 'registerService']);
    Route::post('/request/service/update/{id}', [App\Http\Controllers\ServiceController::class, 'updateService'])->name('request.service.update');

    Route::get('/request/product/register/{id?}', [App\Http\Controllers\ProductController::class, 'productForm'])->name('request.product.register');
    Route::post('/request/product/register', [App\Http\Controllers\ProductController::class, 'registerProduct']);
    Route::post('/request/product/update/{id}', [App\Http\Controllers\ProductController::class, 'updateProduct'])->name('request.product.update');

    Route::get('/request/contract/register/{id?}', [App\Http\Controllers\ContractController::class, 'contractForm'])->name('request.contract.register');
    Route::post('/request/contract/register', [App\Http\Controllers\ContractController::class, 'registerContract']);
    Route::post('/request/contract/update/{id}', [App\Http\Controllers\ContractController::class, 'updateContract'])->name('request.contract.update');

    Route::get('/request/{type}/edit/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'edit'])->name('request.edit');

    Route::post('/request/delete/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'delete'])->name('request.delete');
    Route::delete('/request/remove-file/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'fileDelete'])->name('request.file.delete');
});
