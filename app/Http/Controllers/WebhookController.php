<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function stripe(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret_key'));

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            return response('Webhook error: ' . $e->getMessage(), 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $subscription = Subscription::where('stripe_subscription_id', $session->id)->first();
                if ($subscription) {
                    $subscription->update([
                        'status' => 'active',
                        'stripe_subscription_id' => $session->subscription ?? $session->id,
                    ]);
                    User::where('id', $subscription->user_id)->update(['is_premium' => true]);
                }
                break;

            case 'customer.subscription.deleted':
                $stripeSub = $event->data->object;
                $subscription = Subscription::where('stripe_subscription_id', $stripeSub->id)->first();
                if ($subscription) {
                    $subscription->update(['status' => 'canceled', 'ends_at' => now()]);
                    User::where('id', $subscription->user_id)->update(['is_premium' => false]);
                }
                break;
        }

        return response('OK', 200);
    }

    public function iyzico(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $status = $request->input('status');

        if ($status === 'success') {
            $subscription = Subscription::where('stripe_subscription_id', 'LIKE', 'IYZICO-%')
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($subscription) {
                $subscription->update(['status' => 'active']);
                User::where('id', $subscription->user_id)->update(['is_premium' => true]);
            }

            Payment::create([
                'user_id' => auth()->id() ?? $subscription->user_id ?? null,
                'subscription_id' => $subscription->id ?? null,
                'amount' => $subscription->plan->price ?? 0,
                'currency' => 'TRY',
                'status' => 'completed',
                'payment_method' => 'iyzico',
                'stripe_payment_id' => $paymentId,
                'paid_at' => now(),
            ]);
        }

        return response('OK', 200);
    }
}
