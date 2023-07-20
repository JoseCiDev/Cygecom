<?php

use Illuminate\Support\Facades\{Auth, Route};

Auth::routes();

require __DIR__ . '/web/supplies.php';
require __DIR__ . '/web/admin.php';
require __DIR__ . '/web/requests.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('profile');
    Route::post('/users/{id}', [App\Http\Controllers\Auth\UserController::class, 'userUpdate'])->name('userUpdate');

    Route::post('/suppliers/register/{is_modal?}', [App\Http\Controllers\SupplierController::class, 'register'])->name('supplier.register');
});
