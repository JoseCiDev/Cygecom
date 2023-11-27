<?php

use Illuminate\Support\Facades\{Auth, Route};

Auth::routes();

require __DIR__ . '/web/supplies.php';
require __DIR__ . '/web/requests.php';
require __DIR__ . '/web/users.php';
require __DIR__ . '/web/suppliers.php';
require __DIR__ . '/web/reports.php';
require __DIR__ . '/web/abilities.php';

Route::middleware(['auth'])->group(function () {
    Route::middleware('can:get.home')->get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::middleware('can:get.profile')->get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('profile');
});

Route::fallback(function () {
    return view('components.errors.404');
});
