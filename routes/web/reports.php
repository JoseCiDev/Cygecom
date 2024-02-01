<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::group(['prefix' => 'reports'], function () {
        Route::middleware('can:get.reports.requests.index')->get('/requests', [App\Http\Controllers\ReportController::class, 'requestsIndex'])->name('reports.requests.index');
        Route::middleware('can:get.reports.productivity.index')->get('/productivity', [App\Http\Controllers\ReportController::class, 'productivityIndex'])->name('reports.productivity.index');
    });
});
