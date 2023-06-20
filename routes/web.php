<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoanController;
use App\Http\Controllers\Admin\GoodController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemLoanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProcurementController;
use App\Http\Controllers\Admin\UserController as AdminController;
use App\Http\Controllers\User\GoodController as UserGoodController;
use App\Http\Controllers\User\LoginController as UserLoginController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProcurementController as UserProcurementController;
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

Route::view('/', 'user.auth')->name('login'); //LoginPage

Route::get('admin/login', [LoginController::class, 'index'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'authenticate'])->name('admin.login.auth');

Route::group(['prefix' => 'admin', 'middleware' => ['admin.auth']], function () {
    // Route::view('/', 'admin.dashboard')->name('admin.dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    });

    Route::group(['prefix' => 'good'], function () {
        Route::get('/', [GoodController::class, 'index'])->name('admin.good');
        Route::get('/create', [GoodController::class, 'create'])->name('admin.good.create');
        Route::post('/store', [GoodController::class, 'store'])->name('admin.good.store');
        Route::get('/edit/{id}', [GoodController::class, 'edit'])->name('admin.good.edit');
        Route::put('/update/{id}', [GoodController::class, 'update'])->name('admin.good.update');
        Route::delete('/destroy/{id}', [GoodController::class, 'destroy'])->name('admin.good.destroy');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.user');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.user.edit');
        Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.user.update');
        Route::delete('/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.user.destroy');
        Route::put('/reset', [AdminController::class, 'userAccess'])->name('admin.user.access');
    });

    Route::group(['prefix' => 'procurement'], function () {
        Route::get('/', [ProcurementController::class, 'index'])->name('admin.procurement');
        Route::get('/edit/{id}', [ProcurementController::class, 'edit'])->name('admin.procurement.edit');
        Route::put('/update/{id}', [ProcurementController::class, 'update'])->name('admin.procurement.update');
        Route::delete('/destroy/{id}', [ProcurementController::class, 'destroy'])->name('admin.procurement.destroy');
    });

    Route::group(['prefix' => 'loan'], function () {
        Route::get('/', [ItemLoanController::class, 'index'])->name('admin.loan');
        Route::delete('/destroy/{id}', [ItemLoanController::class, 'destroy'])->name('admin.loan.destroy');
    });
});

Route::get('/register', [RegisterController::class, 'index'])->name('user.register');
Route::post('/register', [RegisterController::class, 'store'])->name('user.register.store');

Route::group(['prefix' => 'user', 'middleware' => ['admin.auth']], function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/logout', [UserLoginController::class, 'logout'])->name('user.logout');


    Route::group(['prefix' => 'good'], function () {
        Route::get('/', [UserGoodController::class, 'index'])->name('user.good');
        Route::get('/goods/search', [UserGoodController::class, 'search'])->name('goods.search');
        Route::get('/good-category/{id}', [UserGoodController::class, 'sortedByCategory'])->name('user.good.category');
    });
    Route::group(['prefix' => 'procurement'], function () {
        Route::get('/', [UserProcurementController::class, 'index'])->name('user.procurement');
        Route::get('/create', [UserProcurementController::class, 'add'])->name('user.procurement.add');
        Route::post('/store', [UserProcurementController::class, 'store'])->name('user.procurement.store');
        Route::delete('/destroy/{id}', [UserProcurementController::class, 'destroy'])->name('user.procurement.destroy');
    });

    Route::group(['prefix' => 'loan'], function () {
        Route::get('/', [LoanController::class, 'index'])->name('user.loan');
        Route::get('/return', [LoanController::class, 'return'])->name('user.return');
        Route::post('/store', [LoanController::class, 'store'])->name('user.loan.store');
        Route::get('/summary', [LoanController::class, 'summary'])->name('user.loan-summary');
        Route::get('/userSummary/{loanId}', [LoanController::class, 'userSummary'])->name('user.user-summary');
        Route::post('/deleteItem/{id}', [LoanController::class, 'deleteItems'])->name('user.loan.delete-item');
        Route::get('/listItems/{loanId}', [LoanController::class, 'listItems'])->name('user.loan-items');
        Route::post('/addItem/{id}', [LoanController::class, 'addItems'])->name('user.loan.create');
        Route::post('/returnItems/{id}', [LoanController::class, 'returnItems'])->name('user.return-items');
        Route::delete('/destroy/{id}', [ItemLoanController::class, 'destroy'])->name('admin.loan.destroy');
    });
});
