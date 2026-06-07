<?php
namespace App\Services\Payment;

use App\Models\PaymentPlan;
use App\Models\User;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret_key'));
    }

    public function createCheckoutSession(PaymentPlan $plan, User $user, $returnUrl)
    {
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'try',
                    'product_data' => ['name' => $plan->name],
                    'unit_amount' => $plan->price * 100,
                    'recurring' => $plan->interval === 'monthly'
                        ? ['interval' => 'month']
                        : ['interval' => 'year'],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => $returnUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $returnUrl . '?canceled=1',
            'metadata' => ['user_id' => $user->id, 'plan_id' => $plan->id],
        ]);

        return $session;
    }

    public function verifySession($sessionId)
    {
        return Session::retrieve($sessionId);
    }
}
