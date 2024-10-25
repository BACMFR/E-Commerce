<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;

Route::post('login', [AuthController::class, 'login'])->prefix('auth');
Route::post('signup', [AuthController::class, 'signup'])->prefix('auth');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);

    Route::post('cart', [CartController::class, 'addToCart']);
    Route::delete('cart/{id}', [CartController::class, 'removeFromCart']);
    Route::get('cart', [CartController::class, 'viewCart']);

    Route::post('payment', [PaymentController::class, 'processPayment']);

    Route::post('checkout', [OrderController::class, 'checkout']);
    Route::get('orders', [OrderController::class, 'viewOrders']);

    Route::post('payment', [PaymentController::class, 'processPayment']);

});


