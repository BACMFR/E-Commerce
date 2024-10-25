<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->middleware('auth:api');
    }

    public function checkout(Request $request)
    {
        $response = $this->orderService->checkout($request->user()->id);
        return response()->json($response, $response['status']);
    }

    public function viewOrders(Request $request)
    {
        $response = $this->orderService->getUserOrders($request->user()->id);
        return response()->json($response, $response['status']);
    }
}
