<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('auth:api');
    }

    public function addToCart(Request $request)
    {
        $response = $this->cartService->addToCart($request->user()->id, $request->product_id, $request->quantity);
        return response()->json($response, $response['status']);
    }

    public function removeFromCart($id)
    {
        $response = $this->cartService->removeFromCart($id);
        return response()->json($response, $response['status']);
    }

    public function viewCart(Request $request)
    {
        $response = $this->cartService->getCartItems($request->user()->id);
        return response()->json($response, $response['status']);
    }
}
