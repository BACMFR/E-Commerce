<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;

class CartService
{
    public function addToCart($userId, $productId, $quantity)
    {
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        $cartItem = CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $productId],
            ['quantity' => $quantity]
        );

        return ['status' => 200, 'cartItem' => $cartItem];
    }

    public function removeFromCart($id)
    {
        $cartItem = CartItem::find($id);

        if ($cartItem && $cartItem->delete()) {
            return ['status' => 200, 'message' => 'Item removed from cart'];
        }

        return ['status' => 400, 'error' => 'Item not removed from cart'];
    }

    public function getCartItems($userId)
    {
        $cart = Cart::where('user_id', $userId)->first();

        if ($cart) {
            $cartItems = $cart->cartItems;
            return ['status' => 200, 'cartItems' => $cartItems];
        }

        return ['status' => 404, 'error' => 'Cart not found'];
    }
}
