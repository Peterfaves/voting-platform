<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    protected $secretKey;
    protected $publicKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('paystack.secretKey');
        $this->publicKey = config('paystack.publicKey');
        $this->baseUrl = config('paystack.paymentUrl', 'https://api.paystack.co');

        // Log if keys are missing
        if (empty($this->secretKey) || empty($this->publicKey)) {
            Log::error('Paystack keys not configured', [
                'has_secret' => !empty($this->secretKey),
                'has_public' => !empty($this->publicKey),
            ]);
        }
    }

    /**
     * Initialize a payment transaction
     */
    public function initializeTransaction($email, $amount, $reference, $metadata = [], $callbackUrl = null)
    {
        if (empty($this->secretKey)) {
            throw new \Exception('Paystack secret key not configured');
        }

        $url = $this->baseUrl . '/transaction/initialize';

        $fields = [
            'email' => $email,
            'amount' => $amount * 100, // Convert to kobo
            'reference' => $reference,
            'metadata' => $metadata,
            'callback_url' => $callbackUrl,
        ];

        Log::info('Paystack Initialize Request', [
            'url' => $url,
            'fields' => $fields,
            'has_secret_key' => !empty($this->secretKey),
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post($url, $fields);

            $result = $response->json();

            Log::info('Paystack Initialize Response', [
                'status_code' => $response->status(),
                'response' => $result,
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Paystack Initialize Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Verify a transaction
     */
    public function verifyTransaction($reference)
    {
        if (empty($this->secretKey)) {
            throw new \Exception('Paystack secret key not configured');
        }

        $url = $this->baseUrl . '/transaction/verify/' . $reference;

        Log::info('Paystack Verify Request', [
            'url' => $url,
            'reference' => $reference,
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
            ])->get($url);

            $result = $response->json();

            Log::info('Paystack Verify Response', [
                'status_code' => $response->status(),
                'response' => $result,
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Paystack Verify Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Get public key
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }
}