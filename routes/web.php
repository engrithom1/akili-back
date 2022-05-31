<?php

use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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

Auth::routes(['register' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('admin');
Route::get('/user/subscribers', [UserController::class, 'Subscribers'])->name('subscribers');
Route::get('/user/admins', [UserController::class, 'Admins'])->name('admins');
Route::get('/user/permissions', [UserController::class, 'Permissions'])->name('permissions');

Route::get('/order/done', [OrderController::class, 'doneOrder'])->name('done');
Route::get('/order/rejected', [OrderController::class, 'rejectedOrder'])->name('rejected');
Route::get('/product/inactive', [ProductController::class, 'inActive'])->name('inactive');

Route::resource('order', OrderController::class);
Route::resource('product', ProductController::class);
Route::resource('discount', DiscountController::class);
Route::resource('tags', TagsController::class);
Route::resource('category', CategoryController::class);

Route::any('{query}', function() { return redirect('/'); })->where('query', '.*');
