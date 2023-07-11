<?php

use Illuminate\Support\Facades\{Auth, Route};

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::middleware(['profile:suprimentosNutrition'])->group(function () {
        Route::get('/supplies/index', [App\Http\Controllers\SuppliesController::class, 'index'])->name('supplies.index');
        Route::get('/supplies/service', [App\Http\Controllers\SuppliesController::class, 'service'])->name('supplies.service');
        Route::get('/supplies/product', [App\Http\Controllers\SuppliesController::class, 'product'])->name('supplies.product');
        Route::get('/supplies/contract', [App\Http\Controllers\SuppliesController::class, 'contract'])->name('supplies.contract');
    });

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('profile');

    Route::post('/users/{id}', [App\Http\Controllers\Auth\UserController::class, 'userUpdate'])->name('userUpdate');

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

    Route::middleware(['profile:admin'])->group(function () {
        Route::get('/user/register', [App\Http\Controllers\Auth\UserController::class, 'showRegistrationForm'])->name('register');
        Route::post('/user/register', [App\Http\Controllers\Auth\UserController::class, 'register']);
        Route::post('/user/delete/{id}', [App\Http\Controllers\Auth\UserController::class, 'delete']);

        Route::get('/users', [App\Http\Controllers\Auth\UserController::class, 'showUsers'])->name('users');
        Route::get('/users/{id}', [App\Http\Controllers\Auth\UserController::class, 'showUser'])->name('user');

        Route::get('/email', [App\Http\Controllers\EmailController::class, 'index'])->name('email');
        Route::post('/email', [App\Http\Controllers\EmailController::class, 'store']);

        Route::get('/suppliers', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers');
        Route::get('/suppliers/view/{id}', [App\Http\Controllers\SupplierController::class, 'supplier'])->name('supplier');
        Route::get('/suppliers/register', [App\Http\Controllers\SupplierController::class, 'showRegistrationForm'])->name('supplierRegister');

        Route::post('/suppliers/register', [App\Http\Controllers\SupplierController::class, 'register']);
        Route::post('/suppliers/delete/{id}', [App\Http\Controllers\SupplierController::class, 'delete']);
        Route::post('/suppliers/update/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplierUpdate');

        Route::get('/requests', [App\Http\Controllers\PurchaseRequestController::class, 'index'])->name('requests');
    });
});
