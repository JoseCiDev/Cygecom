<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'suppliers'], function () {
        Route::middleware('can:get.suppliers.index')->get('/', [App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers.index');
        Route::middleware('can:get.suppliers.edit')->get('/edit/{id}', [App\Http\Controllers\SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::middleware('can:get.suppliers.create')->get('/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('suppliers.create');
        Route::middleware('can:post.suppliers.store')->post('/store', [App\Http\Controllers\SupplierController::class, 'store'])->name('suppliers.store');
        Route::middleware('can:post.suppliers.update')->post('/update/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('suppliers.update');
    });
});
