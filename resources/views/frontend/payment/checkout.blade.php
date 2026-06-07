@extends('layouts.app')

@section('title', 'Ödeme - ' . $plan->name)

@section('content')
<div class="bg-kodlab text-white py-4">
    <div class="container">
        <h4 class="fw-bold mb-0"><i class="bi bi-credit-card me-2"></i>Ödeme</h4>
        <p class="mb-0 opacity-75">{{ $plan->name }} planına abone ol</p>
    </div>
</div>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="kodlab-card card p-4 text-center mb-4">
                <i class="{{ $plan->icon ?? 'bi bi-star-fill' }} display-4 text-kodlab mb-3"></i>
                <h5 class="fw-bold">{{ $plan->name }}</h5>
                <div class="display-5 fw-bold my-3">{{ number_format($plan->price, 0, ',', '.') }}<small class="fs-6 text-muted">₺/{{ $plan->interval === 'monthly' ? 'ay' : 'yıl' }}</small></div>
                <p class="text-muted">{{ $plan->description }}</p>
            </div>

            <div class="kodlab-card card p-4">
                <h6 class="fw-bold mb-3">Ödeme Yöntemi Seçin</h6>
                <div class="d-grid gap-3">
                    <form action="{{ route('payment.iyzico', $plan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-kodlab w-100 py-3">
                            <i class="bi bi-credit-card me-2"></i>Kredi Kartı ile Öde (İyzico)
                        </button>
                    </form>
                    <form action="{{ route('payment.stripe', $plan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-kodlab w-100 py-3">
                            <i class="bi bi-stripe me-2"></i>Stripe ile Öde
                        </button>
                    </form>
                </div>
                <p class="text-center text-muted small mt-3">
                    <i class="bi bi-lock me-1"></i>Ödeme güvenli bir şekilde işlenir.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
