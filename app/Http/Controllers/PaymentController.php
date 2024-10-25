<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
        $this->middleware('auth:api');
    }

    public function processPayment(Request $request)
    {
        $user = $request->user();
        $amount = $request->amount;
        $stripeToken = $request->stripeToken;

        $response = $this->paymentService->processPayment($user, $amount, $stripeToken);

        return response()->json($response, $response['status']);
    }
}
