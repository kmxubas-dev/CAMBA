<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayMongoService
{
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('services.paymongo.secret_key');
        $this->baseUrl = 'https://api.paymongo.com/v1';
    }

    protected function request($method, $endpoint, $data = [])
    {
        return Http::withBasicAuth($this->secretKey, '')
            ->acceptJson()
            ->$method("{$this->baseUrl}/{$endpoint}", $data)
            ->json();
    }

    /**
     * Create a GCash/GrabPay Source
     */
    public function createEwalletSource($amount, $type, $redirect)
    {
        return $this->request('post', 'sources', [
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'redirect' => $redirect,
                    'type' => $type, // 'gcash', 'grab_pay'
                    'currency' => 'PHP',
                ],
            ],
        ]);
    }

    /**
     * Create a PaymentIntent for card payments
     */
    public function createPaymentIntent($amount)
    {
        return $this->request('post', 'payment_intents', [
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'payment_method_allowed' => ['card'],
                    'payment_method_types' => ['card'],
                    'currency' => 'PHP',
                ],
            ],
        ]);
    }

    /**
     * Attach PaymentMethod to PaymentIntent (used in card flow)
     */
    public function attachPaymentIntent(string $intentId, string $paymentMethodId)
    {
        return $this->request('post', "payment_intents/{$intentId}/attach", [
            'data' => [
                'attributes' => [
                    'payment_method' => $paymentMethodId,
                ],
            ],
        ]);
    }

    /**
     * Retrieve a Source or PaymentIntent (for webhook verification)
     */
    public function retrieve(string $type, string $id)
    {
        return $this->request('get', "{$type}/{$id}");
    }
}
