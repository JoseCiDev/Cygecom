<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'files'], function () {
        Route::middleware('can:get.files.show')->get('/show/{path}', [App\Http\Controllers\FileController::class, 'show'])->where('path', '.*')->name('files.show');
    });
});
