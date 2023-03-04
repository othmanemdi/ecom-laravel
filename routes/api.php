<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Api\CartProductsController;
use App\Http\Controllers\Api\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('categories', [CategoryController::class, 'index']);
// Route::get('categories/{category}', [CategoryController::class, 'show']);


Route::post('auth/register', Auth\RegisterController::class);
Route::post('auth/login', Auth\LoginController::class);


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::get('profile', [Auth\ProfileController::class, 'show']);
    Route::put('profile', [Auth\ProfileController::class, 'update']);
    Route::put('password_update', Auth\PasswordUpdateController::class);
    Route::post('auth/logout', Auth\LogoutController::class);

    Route::apiResource('products', ProductController::class);

    // Cart
    Route::get('cart/cartList', [CartProductsController::class, 'cartList']);
    Route::post('cart/addToCart', [CartProductsController::class, 'addToCart']);
    Route::put('cart/incrementCart', [CartProductsController::class, 'incrementCart']);

    Route::put('cart/decrementCart', [CartProductsController::class, 'decrementCart']);

    Route::delete('cart/removeFromCart', [CartProductsController::class, 'removeFromCart']);

    Route::get('cart/getTotal', [CartProductsController::class, 'getTotal']);

    Route::get('order/orderList', [CartProductsController::class, 'orderList']);
    Route::post('order/createOrder', [CartProductsController::class, 'createOrder']);
});
