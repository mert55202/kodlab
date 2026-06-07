<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PaymentPlan;
use App\Models\Subscription;
use App\Models\Payment;
use App\Services\Payment\IyzicoService;
use App\Services\Payment\StripeService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout($planId)
    {
        $plan = PaymentPlan::where('is_active', true)->findOrFail($planId);
        $user = auth()->user();

        if ($plan->price <= 0) {
            return redirect()->route('plans')->with('error', 'Bu plan ücretsiz.');
        }

        return view('frontend.payment.checkout', compact('plan', 'user'));
    }

    public function payWithStripe(Request $request, $planId)
    {
        $plan = PaymentPlan::findOrFail($planId);
        $user = auth()->user();

        $stripe = new StripeService();
        $session = $stripe->createCheckoutSession($plan, $user, route('payment.callback', ['gateway' => 'stripe']));

        Subscription::create([
            'user_id' => $user->id,
            'payment_plan_id' => $plan->id,
            'status' => 'pending',
            'billing_type' => $plan->interval ?? 'monthly',
            'starts_at' => now(),
            'stripe_subscription_id' => $session->id ?? null,
        ]);

        return redirect($session->url);
    }

    public function payWithIyzico(Request $request, $planId)
    {
        $plan = PaymentPlan::findOrFail($planId);
        $user = auth()->user();

        Subscription::create([
            'user_id' => $user->id,
            'payment_plan_id' => $plan->id,
            'status' => 'pending',
            'billing_type' => $plan->interval ?? 'monthly',
            'starts_at' => now(),
            'stripe_subscription_id' => 'IYZICO-' . time(),
        ]);

        return redirect()->away('https://sandbox-api.iyzipay.com/payment/checkoutform');
    }

    public function callback(Request $request, $gateway)
    {
        if ($gateway === 'stripe') {
            return $this->handleStripeCallback($request);
        }
        return $this->handleIyzicoCallback($request);
    }

    protected function handleStripeCallback(Request $request)
    {
        $sessionId = $request->session_id;
        if (!$sessionId) {
            return redirect()->route('plans')->with('error', 'Ödeme iptal edildi.');
        }

        try {
            $stripe = new StripeService();
            $session = $stripe->verifySession($sessionId);

            $subscription = Subscription::where('stripe_subscription_id', $sessionId)->first();
            if ($subscription) {
                $subscription->update([
                    'status' => 'active',
                    'stripe_subscription_id' => $session->subscription ?? $sessionId,
                ]);
                $subscription->user->update(['is_premium' => true]);
            }

            Payment::create([
                'user_id' => $subscription->user_id ?? auth()->id(),
                'subscription_id' => $subscription->id ?? null,
                'amount' => ($session->amount_total ?? 0) / 100,
                'currency' => 'TRY',
                'status' => 'completed',
                'payment_method' => 'stripe',
                'stripe_payment_id' => $session->payment_intent ?? $sessionId,
                'paid_at' => now(),
            ]);

            return view('frontend.payment.success');
        } catch (\Exception $e) {
            return redirect()->route('plans')->with('error', 'Ödeme doğrulama hatası: ' . $e->getMessage());
        }
    }

    protected function handleIyzicoCallback(Request $request)
    {
        $paymentId = $request->paymentId;
        if (!$paymentId) {
            return redirect()->route('plans')->with('error', 'Ödeme iptal edildi.');
        }

        $subscription = Subscription::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($subscription) {
            $subscription->update(['status' => 'active']);
            $subscription->user->update(['is_premium' => true]);
        }

        Payment::create([
            'user_id' => auth()->id(),
            'subscription_id' => $subscription->id ?? null,
            'amount' => $subscription->plan->price ?? 0,
            'currency' => 'TRY',
            'status' => 'completed',
            'payment_method' => 'iyzico',
            'stripe_payment_id' => $paymentId,
            'paid_at' => now(),
        ]);

        return view('frontend.payment.success');
    }

    public function mySubscriptions()
    {
        $user = auth()->user();
        $subscriptions = Subscription::where('user_id', $user->id)
            ->with('plan')
            ->latest()
            ->get();
        $plans = PaymentPlan::where('is_active', true)->orderBy('order')->get();

        return view('frontend.payment.my-subscriptions', compact('subscriptions', 'plans', 'user'));
    }

    public function cancelSubscription($id)
    {
        $subscription = Subscription::where('user_id', auth()->id())->findOrFail($id);
        $subscription->update(['status' => 'canceled', 'ends_at' => now()]);
        auth()->user()->update(['is_premium' => false]);

        return back()->with('success', 'Aboneliğiniz iptal edildi.');
    }
}
