<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GoodController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\ItemLoanController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\LoginController as UserLoginController;
use App\Http\Controllers\Admin\ProcurementController;

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
    Route::view('/', 'admin.auth')->name('login'); //LoginPage

    Route::get('admin/login', [LoginController::class, 'index'])->name('admin.login');
    Route::post('admin/login', [LoginController::class, 'authenticate'])->name('admin.login.auth');

    Route::group(['prefix'=>'admin', 'middleware'=>['admin.auth']], function(){
        // Route::view('/', 'admin.dashboard')->name('admin.dashboard');
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

        Route::group(['prefix'=>'category'], function(){
            Route::get('/', [CategoryController::class, 'index'])->name('admin.category');
            Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
            Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
            Route::put('/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
            Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
        });

        Route::group(['prefix'=>'good'], function(){
            Route::get('/', [GoodController::class, 'index'])->name('admin.good');
            Route::get('/create', [GoodController::class, 'create'])->name('admin.good.create');
            Route::post('/store', [GoodController::class, 'store'])->name('admin.good.store');
            Route::get('/edit/{id}', [GoodController::class, 'edit'])->name('admin.good.edit');
            Route::put('/update/{id}', [GoodController::class, 'update'])->name('admin.good.update');
            Route::delete('/destroy/{id}', [GoodController::class, 'destroy'])->name('admin.good.destroy');
        });

        Route::group(['prefix'=>'user'], function(){
            Route::get('/', [UserController::class, 'index'])->name('admin.user');
            Route::get('/edit{id}', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::put('/update{id}', [UserController::class, 'update'])->name('admin.user.update');
            Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
            Route::put('/reset', [UserController::class, 'userAccess'])->name('admin.user.access');
        });

        Route::group(['prefix'=>'procurement'], function(){
            Route::get('/',[ProcurementController::class, 'index'])->name('admin.procurement');
            Route::get('/edit/{id}', [ProcurementController::class, 'edit'])->name('admin.procurement.edit');
            Route::put('/update/{id}',[ProcurementController::class, 'update'])->name('admin.procurement.update');
            Route::delete('/destroy/{id}',[ProcurementController::class, 'destroy'])->name('admin.procurement.destroy');
        });

        Route::group(['prefix'=>'loan'], function(){
            Route::get('/', [ItemLoanController::class, 'index'])->name('admin.loan');
            Route::delete('/destroy/{id}', [ItemLoanController::class, 'destroy'])->name('admin.loan.destroy');
        });

    });

    Route::group(['prefix'=>'user', 'middleware'=>['admin.auth']], function() {
        Route::get('/', [UserDashboardController::class, 'index'])->name('user.dashboard');

        Route::get('/logout', [UserLoginController::class, 'logout'])->name('user.logout');
    });




    // Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

