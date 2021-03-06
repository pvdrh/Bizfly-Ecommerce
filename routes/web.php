<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\LoginController;

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
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login.store');
Route::get('/auth/redirect', [LoginController::class, 'redirect'])->name('login.social');
Route::get('/callback', [LoginController::class, 'callback'])->name('login.callback');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/support', [DashboardController::class, 'support'])->name('support');

    //Quản lý sản phẩm
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, 'index'])
            ->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])
            ->name('products.create');
        Route::post('/store', [ProductController::class, 'store'])
            ->name('products.store');
        Route::post('/deleteAll', [ProductController::class, 'deleteAll'])
            ->name('products.deleteAll');
        Route::get('/update/{id}', [ProductController::class, 'edit'])
            ->name('products.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])
            ->name('products.update');
        Route::post('/delete/{id}', [ProductController::class, 'destroy'])
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
        Route::any('/deleteAll', [UserController::class, 'deleteAll'])
            ->name('users.deleteAll');
        Route::any('/export-excel', [UserController::class, 'exportExcel'])
            ->name('users.export');
        Route::post('/change-password/{id}', [UserController::class, 'changePassword'])
            ->name('users.changePass');
        Route::get('/update/{id}', [UserController::class, 'edit'])
            ->name('users.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])
            ->name('users.update');
        Route::post('/delete/{id}', [UserController::class, 'destroy'])
            ->name('users.destroy');
    });

    //Quản lý danh mục
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])
            ->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])
            ->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])
            ->name('categories.store');
        Route::post('/deleteAll', [CategoryController::class, 'deleteAll'])
            ->name('categories.deleteAll');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])
            ->name('categories.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])
            ->name('categories.update');
        Route::post('/delete/{id}', [CategoryController::class, 'destroy'])
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
        Route::post('/deleteAll', [CompanyController::class, 'deleteAll'])
            ->name('companies.deleteAll');
        Route::get('/edit/{id}', [CompanyController::class, 'edit'])
            ->name('companies.edit');
        Route::post('/update/{id}', [CompanyController::class, 'update'])
            ->name('companies.update');
        Route::post('/delete/{id}', [CompanyController::class, 'destroy'])
            ->name('companies.destroy');
    });

    //Quản lý khách hàng
    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', [CustomerController::class, 'index'])
            ->name('customers.index');
        Route::get('/create', [CustomerController::class, 'create'])
            ->name('customers.create');
        Route::get('/trashed', [CustomerController::class, 'trashed'])
            ->name('customers.trashed');
        Route::any('/export-excel', [CustomerController::class, 'exportExcel'])
            ->name('customers.export');
        Route::get('/export-excel-sample', [CustomerController::class, 'exportExcelSample'])
            ->name('customers.export-sample');
        Route::get('/get-list-orders/{id}', [CustomerController::class, 'getListOrders'])
            ->name('customers.get-list-orders');
        Route::get('/get-history/{id}', [CustomerController::class, 'getHistoryUpdate'])
            ->name('customers.history');
        Route::post('/deleteAllHistory', [CustomerController::class, 'deleteAllHistory'])
            ->name('customers.deleteAllHistory');
        Route::post('/import-excel', [CustomerController::class, 'importExcel'])
            ->name('customers.import');
        Route::post('/store', [CustomerController::class, 'store'])
            ->name('customers.store');
        Route::post('/restore', [CustomerController::class, 'restore'])
            ->name('customers.restore');
        Route::post('/deleteAll', [CustomerController::class, 'deleteAll'])
            ->name('customers.deleteAll');
        Route::get('/show/{id}', [CustomerController::class, 'show'])
            ->name('customers.show')->middleware('checkRole');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])
            ->name('customers.edit')->middleware('checkRole');
        Route::post('/update/{id}', [CustomerController::class, 'update'])
            ->name('customers.update')->middleware('checkRole');
        Route::post('/delete/{id}', [CustomerController::class, 'destroy'])
            ->name('customers.destroy')->middleware('checkRole');
    });

    //Quản lý đơn hàng
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [OrderController::class, 'index'])
            ->name('orders.index');
        Route::get('/create', [OrderController::class, 'create'])
            ->name('orders.create');
        Route::post('/store', [OrderController::class, 'store'])
            ->name('orders.store');
        Route::post('/deleteAll', [OrderController::class, 'deleteAll'])
            ->name('orders.deleteAll');
        Route::any('/export-excel', [OrderController::class, 'exportExcel'])
            ->name('orders.export');
        Route::get('/export-excel-sample', [OrderController::class, 'exportExcelSample'])
            ->name('orders.export-sample');
        Route::post('/import-excel', [OrderController::class, 'importExcel'])
            ->name('orders.import');
        Route::get('/show/{id}', [OrderController::class, 'show'])
            ->name('orders.show');
        Route::get('/accept/{id}', [OrderController::class, 'acceptOrder'])
            ->name('orders.accept');
        Route::get('/return/{id}', [OrderController::class, 'returnOrder'])
            ->name('orders.return');
        Route::get('/cancel/{id}', [OrderController::class, 'cancelOrder'])
            ->name('orders.cancel');
    });
});
