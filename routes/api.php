<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\API\UserController;
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
    // Route::put('/{id}', [ProcurementController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProcurementController::class, 'destroy'])->name('delete');
});