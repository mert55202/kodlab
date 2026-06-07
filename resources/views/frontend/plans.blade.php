@extends('layouts.app')

@section('title', 'Paketler')

@section('content')
<div class="bg-kodlab text-white py-4">
    <div class="container text-center">
        <h3 class="fw-bold mb-2"><i class="bi bi-star me-2"></i>Premium Paketler</h3>
        <p class="mb-0 opacity-75">Reklamsız deneyim, sertifikalar ve daha fazlası</p>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4 justify-content-center">
        @foreach($plans as $plan)
        <div class="col-md-4">
            <div class="kodlab-card card p-4 text-center h-100 {{ $plan->is_popular ? 'border border-kodlab' : '' }}">
                @if($plan->is_popular)
                <span class="badge bg-kodlab position-absolute top-0 start-50 translate-middle">Popüler</span>
                @endif
                <div class="card-body">
                    <i class="{{ $plan->icon ?? 'bi bi-star-fill' }} display-5 mb-3 text-kodlab"></i>
                    <h5 class="fw-bold">{{ $plan->name }}</h5>
                    @if($plan->price > 0)
                        <div class="display-5 fw-bold my-3">{{ number_format($plan->price, 0, ',', '.') }}<small class="fs-6 text-muted">₺/{{ $plan->interval === 'monthly' ? 'ay' : 'yıl' }}</small></div>
                    @else
                        <div class="display-5 fw-bold my-3 text-success">Ücretsiz</div>
                    @endif
                    <ul class="list-unstyled text-start mt-4">
                        @foreach($plan->features ?? [] as $feature)
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-kodlab me-2"></i>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    @if($plan->price > 0)
                        @auth
                            <a href="{{ route('payment.checkout', $plan->id) }}" class="btn btn-kodlab w-100 mt-3">Abone Ol</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-kodlab w-100 mt-3">Giriş Yap</a>
                        @endauth
                    @else
                        <a href="{{ route('register') }}" class="btn btn-outline-kodlab w-100 mt-3">Ücretsiz Başla</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
