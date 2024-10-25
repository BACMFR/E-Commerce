<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;

class OrderService
{
    public function checkout($userId)
    {
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return ['status' => 404, 'error' => 'Cart not found'];
        }

        $totalPrice = $cart->cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        $order = Order::create([
            'user_id' => $userId,
            'total_price' => $totalPrice
        ]);

        foreach ($cart->cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price
            ]);
        }

        $cart->cartItems()->delete();
        $cart->delete();

        return ['status' => 200, 'order' => $order];
    }

    public function getUserOrders($userId)
    {
        $orders = Order::where('user_id', $userId)->with('orderItems.product')->get();
        return ['status' => 200, 'orders' => $orders];
    }
}
