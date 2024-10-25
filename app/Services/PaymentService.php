<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Order;
use App\Notifications\PaymentConfirmed;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function processPayment($user, $amount, $stripeToken)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'description' => 'Order Payment',
                'source' => $stripeToken,
                'receipt_email' => $user->email,
            ]);

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $amount,
                'status' => 'completed'
            ]);

            $user->notify(new PaymentConfirmed($order));

            return ['status' => 200, 'message' => 'Payment successful', 'order' => $order];
        } catch (\Stripe\Exception\CardException $e) {
            Log::error('Card error: ' . $e->getMessage());
            return ['status' => 400, 'error' => 'Card declined. Please try again with another card.'];
        } catch (\Stripe\Exception\RateLimitException $e) {
            Log::error('Rate limit error: ' . $e->getMessage());
            return ['status' => 429, 'error' => 'Too many requests. Please try again later.'];
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            Log::error('Invalid request error: ' . $e->getMessage());
            return ['status' => 400, 'error' => 'Invalid payment request. Please check your details and try again.'];
        } catch (\Stripe\Exception\AuthenticationException $e) {
            Log::error('Authentication error: ' . $e->getMessage());
            return ['status' => 401, 'error' => 'Authentication failed. Please try again later.'];
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            Log::error('API connection error: ' . $e->getMessage());
            return ['status' => 502, 'error' => 'Connection error. Please try again later.'];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('API error: ' . $e->getMessage());
            return ['status' => 500, 'error' => 'Payment processing error. Please try again later.'];
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());
            return ['status' => 500, 'error' => 'An unexpected error occurred. Please try again later.'];
        }
    }
}
