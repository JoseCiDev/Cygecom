<?php

use Illuminate\Support\Facades\{Auth, Route};

Auth::routes();

require __DIR__ . '/web/supplies.php';
require __DIR__ . '/web/requests.php';
require __DIR__ . '/web/users.php';
require __DIR__ . '/web/suppliers.php';
require __DIR__ . '/web/reports.php';
require __DIR__ . '/web/profile.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/users/{id}', [App\Http\Controllers\Auth\UserController::class, 'edit'])->name('user.edit');
});

Route::fallback(function () {
    return view('components.errors.404');
});
