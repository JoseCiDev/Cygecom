<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'profile:admin'])->group(function () {
    Route::get('/user/register', [App\Http\Controllers\Auth\UserController::class, 'showRegistrationForm'])->name('register');
    Route::post('/user/register', [App\Http\Controllers\Auth\UserController::class, 'register']);
    Route::post('/user/delete/{id}', [App\Http\Controllers\Auth\UserController::class, 'delete']);

    Route::get('/users', [App\Http\Controllers\Auth\UserController::class, 'showUsers'])->name('users');
    Route::get('/users/{id}', [App\Http\Controllers\Auth\UserController::class, 'showUser'])->name('user');

    Route::get('/email', [App\Http\Controllers\EmailController::class, 'index'])->name('email');
    Route::post('/email', [App\Http\Controllers\EmailController::class, 'store']);

    Route::get('/suppliers', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers');
    Route::get('/suppliers/view/{id}', [App\Http\Controllers\SupplierController::class, 'supplier'])->name('supplier');
    Route::get('/suppliers/register', [App\Http\Controllers\SupplierController::class, 'showRegistrationForm'])->name('supplier.form');

    Route::post('/suppliers/delete/{id}', [App\Http\Controllers\SupplierController::class, 'delete']);
    Route::post('/suppliers/update/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');

    Route::get('/requests', [App\Http\Controllers\PurchaseRequestController::class, 'index'])->name('requests');

    Route::get('/supplies/service', [App\Http\Controllers\SuppliesController::class, 'service'])->name('supplies.service');
    Route::get('/supplies/product', [App\Http\Controllers\SuppliesController::class, 'product'])->name('supplies.product');
    Route::get('/supplies/contract', [App\Http\Controllers\SuppliesController::class, 'contract'])->name('supplies.contract');
});
