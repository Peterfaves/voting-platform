<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidatePaystackWebhook
{
    public function handle(Request $request, Closure $next)
    {
        $signature = $request->header('x-paystack-signature');
        
        if (!$signature) {
            \Log::warning('Webhook received without signature');
            return response()->json(['error' => 'No signature provided'], 401);
        }

        $paymentSetting = \App\Models\PaymentSetting::where('is_active', true)->first();
        
        if (!$paymentSetting) {
            \Log::error('No active payment setting for webhook validation');
            return response()->json(['error' => 'Configuration error'], 500);
        }

        $body = $request->getContent();
        $computedSignature = hash_hmac('sha512', $body, $paymentSetting->secret_key);

        if ($signature !== $computedSignature) {
            \Log::warning('Invalid webhook signature', [
                'received' => $signature,
                'expected' => $computedSignature,
                'ip' => $request->ip()
            ]);
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        return $next($request);
    }
}