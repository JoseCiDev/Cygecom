<?php

use App\Http\Controllers\{ProductSuggestionController, PurchaseRequestController, SupplierController};
use App\Http\Controllers\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', function (Request $request) {
            return $request->user();
        });

        Route::middleware('can:get.user.show.json')->get('/show/{id}', [UserController::class, 'showJson'])->name('user.show.json');
    });

    Route::group(['prefix' => 'suppliers'], function () {
        Route::middleware('can:get.api.suppliers.index')->get('/', [SupplierController::class, 'indexAPI'])->name('api.suppliers.index');
        Route::middleware('can:post.api.suppliers.register')->post('/register', [SupplierController::class, 'registerAPI'])->name('api.supplier.register');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::middleware('can:get.api.product.suggestion.index')->get('/suggestion', [ProductSuggestionController::class, 'index'])->name('api.product.suggestion.index');
    });

    Route::group(['prefix' => 'supplies'], function () {
        Route::middleware('can:post.api.supplies.files.upload')->post('/files/uppload', [PurchaseRequestController::class, 'uploadSuppliesFilesAPI'])->name('api.supplies.files.upload');
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::middleware('can:get.reports.index.json')->get('/index', [App\Http\Controllers\ReportController::class, 'indexJson'])->name('reports.index.json');
    });

    Route::group(['prefix' => 'abilities'], function () {
        Route::middleware('can:post.abilities.store.json')->post('/store/{userId}', [App\Http\Controllers\AbilitiesController::class, 'storeJson'])->name('abilities.store.json');
    });
});
