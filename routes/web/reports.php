<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::group(['prefix' => 'reports'], function () {
        Route::middleware('can:get.reports.index.view')->get('/index', [App\Http\Controllers\ReportController::class, 'indexView'])->name('reports.index.view');
    });
});
