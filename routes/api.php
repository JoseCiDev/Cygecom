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
    Route::group(['prefix' => 'users'], function () {
        Route::middleware('can:get.api.users.show')->get('/show/{id}', [UserController::class, 'showJson'])->name('api.user.show');
        Route::middleware('can:post.api.user.abilities.store')->post('/abilities/store/{userId}', [App\Http\Controllers\Auth\UserController::class, 'storeAbilities'])->name('api.user.abilities.store');
        Route::middleware('can:delete.api.users.destroy')->delete('/destroy/{user}', [App\Http\Controllers\Auth\UserController::class, 'destroy'])->name('api.users.destroy');
    });

    Route::group(['prefix' => 'suppliers'], function () {
        Route::middleware('can:get.api.suppliers.index')->get('/', [SupplierController::class, 'indexAPI'])->name('api.suppliers.index');
        Route::middleware('can:post.api.suppliers.register')->post('/register', [SupplierController::class, 'registerAPI'])->name('api.supplier.register');
        Route::middleware('can:delete.api.suppliers.destroy')->delete('/destroy/{supplier}', [App\Http\Controllers\SupplierController::class, 'destroy'])->name('api.suppliers.destroy');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::middleware('can:get.api.product.suggestion.index')->get('/suggestion', [ProductSuggestionController::class, 'index'])->name('api.product.suggestion.index');
    });

    Route::group(['prefix' => 'supplies'], function () {
        Route::middleware('can:post.api.supplies.files.upload')->post('/files/uppload', [PurchaseRequestController::class, 'uploadSuppliesFilesAPI'])->name('api.supplies.files.upload');
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::middleware('can:post.api.reports.requests.index')->post('/requests', [App\Http\Controllers\ReportController::class, 'requestsIndexAPI'])->name('api.reports.requests.index');
        Route::middleware('can:post.api.reports.productivity.index')->post('/productivity', [App\Http\Controllers\ReportController::class, 'productivityIndexAPI'])->name('api.reports.productivity.index');
    });

    Route::group(['prefix' => 'requests'], function () {
        Route::middleware('can:get.api.requests.show')->get('/show/{id}', [PurchaseRequestController::class, 'showAPI'])->name('api.requests.show');
        Route::middleware('can:delete.api.requests.destroy')->delete('/destroy/{purchaseRequest}', [App\Http\Controllers\PurchaseRequestController::class, 'destroy'])->name('api.requests.destroy');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::middleware('can:delete.api.userProfile.destroy')->delete('/destroy/{userProfile}', [App\Http\Controllers\UserProfileController::class, 'destroy'])->name('api.userProfile.destroy');
    });
});
