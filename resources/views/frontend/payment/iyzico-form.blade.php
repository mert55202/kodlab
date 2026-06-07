@extends('layouts.app')

@section('title', 'İyzico ile Öde')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="kodlab-card card p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-credit-card me-2 text-kodlab"></i>İyzico ile Ödeme</h5>
                <p class="text-muted mb-4">{{ $plan->name }} planı: <strong>{{ number_format($plan->price, 0, ',', '.') }} ₺</strong></p>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>İyzico ödeme sayfasına yönlendiriliyorsunuz...
                </div>
                <form action="https://sandbox-api.iyzipay.com/payment/checkoutform" method="POST" id="iyzicoForm">
                    @foreach($formData as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $subKey => $subValue)
                                <input type="hidden" name="{{ $key }}[{{ $subKey }}]" value="{{ $subValue }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                </form>
                <button class="btn btn-kodlab w-100" onclick="document.getElementById('iyzicoForm').submit()">
                    <i class="bi bi-credit-card me-2"></i>Ödemeyi Tamamla
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
