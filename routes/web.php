<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

//Quản lý sản phẩm
Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, 'index'])
        ->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])
        ->name('products.create');
    Route::post('/store', [ProductController::class, 'store'])
        ->name('products.store');
    Route::get('/update/{id}', [ProductController::class, 'edit'])
        ->name('products.edit');
    Route::post('/update/{id}', [ProductController::class, 'update'])
        ->name('products.update');
    Route::delete('/delete/{id}', [ProductController::class, 'destroy'])
        ->name('products.destroy');
});

//Quản lý nhân viên
Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index'])
        ->name('users.index');
    Route::get('/create', [UserController::class, 'create'])
        ->name('users.create');
    Route::post('/store', [UserController::class, 'store'])
        ->name('users.store');
    Route::get('/update/{id}', [UserController::class, 'edit'])
        ->name('users.edit');
    Route::post('/update/{id}', [UserController::class, 'update'])
        ->name('users.update');
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])
        ->name('users.destroy');
});

//Quản lý chức vụ
Route::group(['prefix' => 'roles'], function () {
    Route::get('/', [RoleController::class, 'index'])
        ->name('roles.index');
    Route::get('/create', [RoleController::class, 'create'])
        ->name('roles.create');
    Route::post('/store', [RoleController::class, 'store'])
        ->name('roles.store');
    Route::get('/update/{id}', [RoleController::class, 'edit'])
        ->name('roles.edit');
    Route::post('/update/{id}', [RoleController::class, 'update'])
        ->name('roles.update');
    Route::delete('/delete/{id}', [RoleController::class, 'destroy'])
        ->name('roles.destroy');
});

//Quản lý danh mục
Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index'])
        ->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])
        ->name('categories.create');
    Route::post('/store', [CategoryController::class, 'store'])
        ->name('categories.store');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])
        ->name('categories.edit');
    Route::post('/update/{id}', [CategoryController::class, 'update'])
        ->name('categories.update');
    Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');
});

//Quản lý công ty
Route::group(['prefix' => 'companies'], function () {
    Route::get('/', [CompanyController::class, 'index'])
        ->name('companies.index');
    Route::get('/create', [CompanyController::class, 'create'])
        ->name('companies.create');
    Route::post('/store', [CompanyController::class, 'store'])
        ->name('companies.store');
    Route::get('/edit/{id}', [CompanyController::class, 'edit'])
        ->name('companies.edit');
    Route::post('/update/{id}', [CompanyController::class, 'update'])
        ->name('companies.update');
    Route::delete('/delete/{id}', [CompanyController::class, 'destroy'])
        ->name('companies.destroy');
});
