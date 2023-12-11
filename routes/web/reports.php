<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::group(['prefix' => 'reports'], function () {
        Route::middleware('can:get.reports.index')->get('/index', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    });
});
