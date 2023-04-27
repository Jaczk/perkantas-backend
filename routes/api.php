<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GoodController;
use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\API\Item_LoanController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProcurementController;

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

Route::name('auth.')->group(function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
        Route::get('user', [UserController::class, 'fetch'])->name('fetch');
    });
});

Route::prefix('loan')->middleware('auth:sanctum')->name('loan.')->group(function () {
    Route::get('/', [LoanController::class, 'fetch'])->name('fetch');
    Route::post('/', [LoanController::class, 'create'])->name('create');
    Route::put('/{id}', [LoanController::class, 'update'])->name('update');
    Route::delete('/{id}', [LoanController::class, 'destroy'])->name('delete');
});

Route::prefix('procurement')->middleware('auth:sanctum')->name('procurement.')->group(function () {
    Route::get('/', [ProcurementController::class, 'fetch'])->name('fetch');
    Route::post('/', [ProcurementController::class, 'create'])->name('create');
    Route::put('/{id}', [ProcurementController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProcurementController::class, 'destroy'])->name('delete');
});

Route::prefix('category')->middleware('auth:sanctum')->name('category.')->group(function () {
    Route::get('/', [CategoryController::class, 'fetch'])->name('fetch');
    Route::post('/', [CategoryController::class, 'create'])->name('create');
    Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('delete');
});

Route::prefix('goods')->middleware('auth:sanctum')->name('goods.')->group(function () {
    Route::get('/', [GoodController::class, 'fetch'])->name('fetch');
    Route::post('/', [GoodController::class, 'create'])->name('create');
    Route::post('/update/{id}', [GoodController::class, 'update'])->name('update');
    Route::delete('/{id}', [GoodController::class, 'destroy'])->name('delete');
});

Route::prefix('items')->middleware('auth:sanctum')->name('items.')->group(function () {
    Route::get('/', [Item_LoanController::class, 'fetch'])->name('fetch');
    Route::post('/', [Item_LoanController::class, 'create'])->name('create');
    Route::post('/update/{id}', [Item_LoanController::class, 'update'])->name('update');
    Route::delete('/{id}', [Item_LoanController::class, 'destroy'])->name('delete');
});