<?php

use Illuminate\Support\Facades\{Auth, Route};

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('profile');

    Route::post('/users/{id}', [App\Http\Controllers\Auth\UserController::class, 'userUpdate'])->name('userUpdate');

    Route::get('/requests/own', [App\Http\Controllers\QuoteRequestController::class, 'ownRequests'])->name('requests.own');
    Route::get('/requests/new', [App\Http\Controllers\QuoteRequestController::class, 'new'])->name('requests.new');
    Route::get('/request/product/{id?}', [App\Http\Controllers\QuoteRequestController::class, 'product'])->name('request.product');
    Route::get('/request/service/{id?}', [App\Http\Controllers\QuoteRequestController::class, 'service'])->name('request.service');
    Route::get('/request/contract/{id?}', [App\Http\Controllers\QuoteRequestController::class, 'contract'])->name('request.contract');
    //Route::get('/request/register/{id?}', [App\Http\Controllers\QuoteRequestController::class, 'form'])->name('request.register');
    Route::get('/request/view/{id}', [App\Http\Controllers\QuoteRequestController::class, 'edit'])->name('request.edit');

    Route::post('/request/register', [App\Http\Controllers\QuoteRequestController::class, 'register']);
    Route::post('/request/delete/{id}', [App\Http\Controllers\QuoteRequestController::class, 'delete'])->name('request.delete');
    Route::post('/request/update/{id}', [App\Http\Controllers\QuoteRequestController::class, 'update'])->name('request.update');

    Route::get('/quotations', [App\Http\Controllers\Quotation\QuotationController::class, 'index'])->name('quotations');
    Route::get('/quotations/register', [App\Http\Controllers\Quotation\QuotationController::class, 'showRegistrationForm'])
        ->name('quotationRegister');
    Route::post('/quotations/register', [App\Http\Controllers\Quotation\QuotationController::class, 'register']);

    Route::middleware(['isAdmin'])->group(function () {
        Route::get('/user/register', [App\Http\Controllers\Auth\UserController::class, 'showRegistrationForm'])
            ->name('register');
        Route::post('/user/register', [App\Http\Controllers\Auth\UserController::class, 'register']);
        Route::post('/user/delete/{id}', [App\Http\Controllers\Auth\UserController::class, 'delete']);

        Route::get('/users', [App\Http\Controllers\Auth\UserController::class, 'showUsers'])->name('users');
        Route::get('/users/{id}', [App\Http\Controllers\Auth\UserController::class, 'showUser'])->name('user');

        Route::get('/email', [App\Http\Controllers\EmailController::class, 'index'])->name('email');
        Route::post('/email', [App\Http\Controllers\EmailController::class, 'store']);

        Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
        Route::get('/products/register', [App\Http\Controllers\ProductController::class, 'form'])
            ->name('productRegister');
        Route::post('/products/register', [App\Http\Controllers\ProductController::class, 'register']);

        Route::get('/products/product/{id}', [App\Http\Controllers\ProductController::class, 'product'])
            ->name('product');
        Route::post('/products/product/{id}', [App\Http\Controllers\ProductController::class, 'update'])
            ->name('updateProduct');
        Route::post('/products/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete']);

        Route::get('/suppliers', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers');
        Route::get('/suppliers/view/{id}', [App\Http\Controllers\SupplierController::class, 'supplier'])->name('supplier');
        Route::get('/suppliers/register', [App\Http\Controllers\SupplierController::class, 'showRegistrationForm'])->name('supplierRegister');

        Route::post('/suppliers/register', [App\Http\Controllers\SupplierController::class, 'register']);
        Route::post('/suppliers/delete/{id}', [App\Http\Controllers\SupplierController::class, 'delete']);
        Route::post('/suppliers/update/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplierUpdate');

        Route::get('/requests', [App\Http\Controllers\QuoteRequestController::class, 'index'])->name('requests');
    });
});
