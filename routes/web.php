<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
//Admin
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\BatchController;


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

 Route::get('/user', function () {
    return $request->user();
});

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::post('/verify', [HomeController::class, 'verify'])->name('verify');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);
//Admin

Route::group(['middleware' => 'auth'], function () {
    Route::namespace ('Admin')->group(function () {
        Route::match(['get','post'],'/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/admin/get_state_wise', [DashboardController::class, 'get_state_wise'])->name('get_state_wise');
        Route::get('/admin/get_state_wise_detail', [DashboardController::class, 'get_state_wise_detail'])->name('get_state_wise_detail');
        Route::get('/admin/get_map_data', [DashboardController::class, 'get_map_data'])->name('get_map_data');
        Route::post('/admin/export_all_code', [DashboardController::class, 'export_all_code'])->name('export_all_code');
        Route::resource('/admin/users', 'UserController');

        Route::get('/admin/getusers', [UserController::class, 'getusers'])->name('getusers');
        Route::post('/admin/user_status/{id}', [UserController::class, 'statusChange'])->name('user_status');

        Route::resource('/admin/products', 'ProductController');
        Route::get('/admin/getproducts', [ProductController::class, 'getproducts'])->name('getproducts');
        Route::get('/admin/verified-products', [ProductController::class, 'verified'])->name('products.verified');
        Route::get('/admin/getverifiedproducts', [ProductController::class, 'getverifiedProducts'])->name('getverifiedproducts');

        Route::resource('/admin/batch', 'BatchController');
        Route::get('/admin/getbatch', [BatchController::class, 'getbatch'])->name('getbatch');
        Route::get('/admin/getbatchpro', [BatchController::class, 'getbatchpro'])->name('getbatchpro');
        Route::get('/admin/getbatch/{id}', [BatchController::class, 'getbatchpdf'])->name('getbatchpdf');
        Route::get('/admin/loadMore', [BatchController::class, 'loadMore'])->name('loadMore');
        Route::post('/admin/import_code', [BatchController::class, 'import_code'])->name('import_code');
        Route::resource('/admin/roles', 'RoleController');
        Route::get('/admin/getlist', [RoleController::class, 'getlist'])->name('rolelist');
        Route::get('/admin/permission/{id}', [RoleController::class, 'permission'])->name('permission');
        Route::put('/admin/permission_update', [RoleController::class, 'permission_update'])->name('permission_update');
        Route::match(['get','post'],'/admin/change-password', [LoginController::class, 'change_password'])->name('admin-change-password');
    });
});
//frontpages

