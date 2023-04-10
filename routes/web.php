<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/registerPersonView', [App\Http\Controllers\PersonController::class, 'registerPersonView'])->name('registerPersonView');
Route::post('/registerPerson', [App\Http\Controllers\PersonController::class, 'registerPerson'])->name('registerPerson');
