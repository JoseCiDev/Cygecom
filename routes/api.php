<?php

use App\Http\Controllers\{ProductSuggestionController, PurchaseRequestController, SupplierController};
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'suppliers'], function () {
        Route::get('/', [SupplierController::class, 'indexAPI'])->name('api.suppliers.index');
        Route::post('/register', [SupplierController::class, 'registerAPI'])->name('api.supplier.register');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/suggestion', [ProductSuggestionController::class, 'index'])->name('api.product.suggestion.index');
    });

    Route::group(['prefix' => 'supplies'], function () {
        Route::post('/files/uppload', [PurchaseRequestController::class, 'uploadSuppliesFilesAPI'])->name('api.supplies.files.upload');
    });
});
