<?php

use Illuminate\Support\Facades\{Auth, Route};

Auth::routes();

require __DIR__ . '/web/supplies.php';
require __DIR__ . '/web/admin.php';
require __DIR__ . '/web/requests.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('profile');
    Route::post('/users/{id}', [App\Http\Controllers\Auth\UserController::class, 'update'])->name('user.update');
    Route::post('/suppliers/register', [App\Http\Controllers\SupplierController::class, 'register'])->name('supplier.register');
});

Route::fallback(function () {
    return view('components.errors.404');
});
