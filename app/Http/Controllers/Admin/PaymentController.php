<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\PaymentPlan;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index()
    {
        $payments = Payment::with('user', 'subscription')->latest()->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    public function subscriptions()
    {
        $subscriptions = Subscription::with('user', 'plan')->latest()->paginate(20);
        $plans = PaymentPlan::where('is_active', true)->get();
        return view('admin.payments.subscriptions', compact('subscriptions', 'plans'));
    }
}
