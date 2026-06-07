<?php
namespace App\Services\Payment;

use App\Models\PaymentPlan;
use App\Models\User;

class IyzicoService
{
    protected $apiKey;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.iyzico.api_key');
        $this->secretKey = config('services.iyzico.secret_key');
        $this->baseUrl = config('services.iyzico.sandbox') ? 'https://sandbox-api.iyzipay.com' : 'https://api.iyzipay.com';
    }

    public function createCheckoutForm(PaymentPlan $plan, User $user, $returnUrl)
    {
        $request = [
            'locale' => 'tr',
            'conversationId' => 'KC' . time(),
            'price' => (string) $plan->price,
            'paidPrice' => (string) $plan->price,
            'basketId' => 'B' . $plan->id,
            'paymentGroup' => 'SUBSCRIPTION',
            'buyer' => [
                'id' => (string) $user->id,
                'name' => $user->name,
                'surname' => '',
                'email' => $user->email,
                'identityNumber' => '11111111111',
                'registrationAddress' => 'Istanbul, Turkey',
                'city' => 'Istanbul',
                'country' => 'Turkey',
            ],
            'basketItems' => [
                [
                    'id' => (string) $plan->id,
                    'name' => $plan->name,
                    'category1' => 'Education',
                    'itemType' => 'VIRTUAL',
                    'price' => (string) $plan->price,
                ]
            ],
            'callbackUrl' => $returnUrl,
        ];

        return $request;
    }

    public function verifyPayment($paymentId)
    {
        return ['status' => 'success', 'payment_id' => $paymentId];
    }
}
