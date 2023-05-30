<?php

use Illuminate\Support\Facades\{Auth, Route};

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('profile');
    Route::post('/users/{id}', [App\Http\Controllers\Auth\UserController::class, 'userUpdate'])->name('userUpdate');

    Route::get('/requests', [App\Http\Controllers\OrderRequestController::class, 'index'])->name('requests');
    Route::get('/request/register', [App\Http\Controllers\OrderRequestController::class, 'showRegistrationForm'])->name('requestRegister');

    Route::get('/quotations', [App\Http\Controllers\QuoteController::class, 'index'])->name('quotations');
    Route::get('/quotation/register', [App\Http\Controllers\QuoteController::class, 'showRegistrationForm'])->name('quotationRegister');

    Route::get('/suppliers', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers');
    Route::get('/supplier/register', [App\Http\Controllers\SupplierController::class, 'showRegistrationForm'])->name('supplierRegister');

    Route::middleware(['isAdmin'])->group(function () {
        Route::get('/user/register', [App\Http\Controllers\Auth\UserController::class, 'showRegistrationForm'])->name('register');
        Route::post('/user/register', [App\Http\Controllers\Auth\UserController::class, 'register']);
        Route::post('/user/delete/{id}', [App\Http\Controllers\Auth\UserController::class, 'delete']);

        Route::get('/users', [App\Http\Controllers\Auth\UserController::class, 'showUsers'])->name('users');
        Route::get('/users/{id}', [App\Http\Controllers\Auth\UserController::class, 'showUser'])->name('user');

        Route::get('/email', [App\Http\Controllers\EmailController::class, 'index'])->name('email');
        Route::post('/email', [App\Http\Controllers\EmailController::class, 'store']);

        Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
        Route::get('/products/register', [App\Http\Controllers\ProductController::class, 'form'])->name('productRegister');
        Route::post('/products/register', [App\Http\Controllers\ProductController::class, 'register']);

        Route::get('/products/product/{id}', [App\Http\Controllers\ProductController::class, 'product'])->name('product');
        Route::post('/products/product/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('updateProduct');
        Route::post('/products/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete']);
    });
});
