<?php

use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Front\TagController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

////0686255811

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout',[AuthController::class, 'logout']);
    Route::get('/current-user',[AuthController::class, 'currentUser']);
   
});

//Route::post('/logout',[AuthController::class, 'logout']);

Route::get('/get-orders/{id}',[OrderController::class, 'getOrders']);
Route::post('/create-order',[OrderController::class, 'createOrder']);

Route::get('/tags', [TagController::class, 'index']);
Route::get('/top-tags', [TagController::class, 'topTags']);
Route::get('/get-tag/{id}', [TagController::class, 'getTag']);
Route::get('/products-tag/{id}', [TagController::class, 'productsByTag']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/top-categories', [CategoryController::class, 'topCategories']);
Route::get('/get-category/{id}', [CategoryController::class, 'getCategory']);
Route::get('/products-category/{id}', [CategoryController::class, 'productsByCategory']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/related/{id}', [ProductController::class, 'related']);
Route::get('/views/{id}', [ProductController::class, 'addViews']);

