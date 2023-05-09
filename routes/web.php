<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GoodController;
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

    Route::group(['prefix'=>'admin'], function(){
        Route::view('/', 'admin.dashboard')->name('admin.dashboard');

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

    });


