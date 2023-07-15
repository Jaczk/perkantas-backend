<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoanController as UserLoanController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\GoodController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemLoanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FineController;
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

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/chart/ajax/{period}', [DashboardController::class, 'procurementChartAjax'])->name('admin.chart.ajax');
    Route::get('/itemChart/ajax/{period}', [DashboardController::class, 'itemLoanChartAjax'])->name('admin.itemchart.ajax');


    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
        Route::get('/trash', [CategoryController::class, 'trash'])->name('admin.category.trash');
        Route::put('/restore/{id}', [CategoryController::class, 'restore'])->name('admin.category.restore');
        Route::delete('/delete/{id}', [CategoryController::class, 'forceDelete'])->name('admin.category.delete');
    });

    Route::group(['prefix' => 'fine'], function () {
        Route::get('/', [FineController::class, 'index'])->name('admin.fine');
        Route::get('/create', [FineController::class, 'create'])->name('admin.fine.create');
        Route::post('/store', [FineController::class, 'store'])->name('admin.fine.store');
        Route::get('/edit/{id}', [FineController::class, 'edit'])->name('admin.fine.edit');
        Route::put('/update/{id}', [FineController::class, 'update'])->name('admin.fine.update');
        Route::delete('/destroy/{id}', [FineController::class, 'destroy'])->name('admin.fine.destroy');
        Route::get('/trash', [FineController::class, 'trash'])->name('admin.fine.trash');
        Route::put('/restore/{id}', [FineController::class, 'restore'])->name('admin.fine.restore');
        Route::delete('/delete/{id}', [FineController::class, 'forceDelete'])->name('admin.fine.delete');
    });

    Route::group(['prefix' => 'good'], function () {
        Route::get('/', [GoodController::class, 'index'])->name('admin.good');
        Route::get('/create', [GoodController::class, 'create'])->name('admin.good.create');
        Route::post('/store', [GoodController::class, 'store'])->name('admin.good.store');
        Route::get('/edit/{id}', [GoodController::class, 'edit'])->name('admin.good.edit');
        Route::put('/update/{id}', [GoodController::class, 'update'])->name('admin.good.update');
        Route::delete('/destroy/{id}', [GoodController::class, 'destroy'])->name('admin.good.destroy');
        Route::get('/trash', [GoodController::class, 'trash'])->name('admin.good.trash');
        Route::put('/restore/{id}', [GoodController::class, 'restore'])->name('admin.good.restore');
        Route::delete('/delete/{id}', [GoodController::class, 'forceDelete'])->name('admin.good.delete');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.user');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.user.edit');
        Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.user.update');
        Route::delete('/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.user.destroy');
        Route::put('/reset', [AdminController::class, 'userAccess'])->name('admin.user.access');
    });

    Route::group(['prefix' => 'loans'], function () {
        Route::get('/', [LoanController::class, 'index'])->name('admin.loans');
        Route::put('/return/{id}', [LoanController::class, 'return'])->name('admin.loans.return');
        Route::get('/chart/loan/{period}', [LoanController::class, 'loanChartAjax'])->name('admin.chart.loan.ajax');
        Route::delete('/destroy/{id}', [LoanController::class, 'destroy'])->name('admin.loans.destroy');
    });

    Route::group(['prefix' => 'procurement'], function () {
        Route::get('/', [ProcurementController::class, 'index'])->name('admin.procurement');
        Route::get('/edit/{id}', [ProcurementController::class, 'edit'])->name('admin.procurement.edit');
        Route::put('/update/{id}', [ProcurementController::class, 'update'])->name('admin.procurement.update');
        Route::delete('/destroy/{id}', [ProcurementController::class, 'destroy'])->name('admin.procurement.destroy');
    });

    // Route::group(['prefix' => 'loan'], function () {
    //     Route::get('/', [ItemLoanController::class, 'index'])->name('admin.loan');
    //     Route::delete('/destroy/{id}', [ItemLoanController::class, 'destroy'])->name('admin.loan.destroy');
    // });
});

Route::get('/register', [RegisterController::class, 'index'])->name('user.register');
Route::post('/register', [RegisterController::class, 'store'])->name('user.register.store');

Route::group(['prefix' => 'user', 'middleware' => ['admin.auth']], function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/logout', [UserLoginController::class, 'logout'])->name('user.logout');


    Route::group(['prefix' => 'good'], function () {
        Route::get('/', [UserGoodController::class, 'index'])->name('user.good');
        Route::get('/search', [UserGoodController::class, 'search'])->name('user.goods.search');
        Route::get('/good-category/{id}', [UserGoodController::class, 'sortedByCategory'])->name('user.good.category');
    });
    Route::group(['prefix' => 'procurement'], function () {
        Route::get('/', [UserProcurementController::class, 'index'])->name('user.procurement');
        Route::get('/create', [UserProcurementController::class, 'add'])->name('user.procurement.add');
        Route::get('/search', [UserProcurementController::class, 'search'])->name('user.procurement.search');
        Route::post('/store', [UserProcurementController::class, 'store'])->name('user.procurement.store');
        Route::delete('/destroy/{id}', [UserProcurementController::class, 'destroy'])->name('user.procurement.destroy');
    });

    Route::group(['prefix' => 'loan'], function () {
        Route::get('/', [UserLoanController::class, 'index'])->name('user.loan');
        Route::get('/return', [UserLoanController::class, 'return'])->name('user.return');
        Route::post('/store', [UserLoanController::class, 'store'])->name('user.loan.store');
        Route::get('/listItems/{loanId}', [UserLoanController::class, 'listItems'])->name('user.loan-items');
        Route::post('/addItem/{id}', [UserLoanController::class, 'addItems'])->name('user.loan.create');
        Route::get('/backSummary', [UserLoanController::class, 'backSummary'])->name('user.loan.back');
        Route::get('/summary', [UserLoanController::class, 'summary'])->name('user.loan-summary');
        Route::get('/userSummary/{loanId}', [UserLoanController::class, 'userSummary'])->name('user.user-summary');
        Route::post('/deleteItem/{id}', [UserLoanController::class, 'deleteItems'])->name('user.loan.delete-item');
        Route::post('/returnItems/{id}', [UserLoanController::class, 'returnItems'])->name('user.return-items');
        Route::delete('/destroy/{id}', [ItemUserLoanController::class, 'destroy'])->name('admin.loan.destroy');
        Route::get('/history', [UserLoanController::class, 'history'])->name('user.loan.history');
    });
});
