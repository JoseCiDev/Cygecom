<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'requests'], function () {
        Route::middleware('can:get.requests.own')->get('/own', [App\Http\Controllers\PurchaseRequestController::class, 'ownRequests'])->name('requests.own');
        Route::middleware('can:get.requests')->get('/', [App\Http\Controllers\PurchaseRequestController::class, 'index'])->name('requests');
    });

    Route::group(['prefix' => 'request'], function () {
        Route::middleware('can:get.request.links')->get('/links', [App\Http\Controllers\PurchaseRequestController::class, 'formList'])->name('request.links');

        Route::middleware('can:get.request.service.register')->get('/service/register/{id?}', [App\Http\Controllers\ServiceController::class, 'serviceForm'])->name('request.service.register');
        Route::middleware('can:post.request.service.register')->post('/service/register', [App\Http\Controllers\ServiceController::class, 'registerService']);
        Route::middleware('can:post.request.service.update')->post('/service/update/{id}', [App\Http\Controllers\ServiceController::class, 'updateService'])->name('request.service.update');

        Route::middleware('can:get.request.product.register')->get('/product/register/{id?}', [App\Http\Controllers\ProductController::class, 'productForm'])->name('request.product.register');
        Route::middleware('can:post.request.product.register')->post('/product/register', [App\Http\Controllers\ProductController::class, 'registerProduct']);
        Route::middleware('can:post.request.product.update')->post('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'updateProduct'])->name('request.product.update');

        Route::middleware('can:get.request.contract.register')->get('/contract/register/{id?}', [App\Http\Controllers\ContractController::class, 'contractForm'])->name('request.contract.register');
        Route::middleware('can:post.request.contract.register')->post('/contract/register', [App\Http\Controllers\ContractController::class, 'registerContract']);
        Route::middleware('can:post.request.contract.update')->post('/contract/update/{id}', [App\Http\Controllers\ContractController::class, 'updateContract'])->name('request.contract.update');

        Route::middleware('can:get.request.edit')->get('/{type}/edit/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'edit'])->name('request.edit');

        Route::middleware('can:delete.request.file.delete')->delete('/remove-file/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'fileDelete'])->name('request.file.delete');

        Route::middleware('can:post.request.delete')->post('/delete/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'delete'])->name('request.delete');
    });
});
