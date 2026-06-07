@extends('layouts.app')

@section('title', 'Aboneliklerim')

@section('content')
<div class="bg-kodlab text-white py-4">
    <div class="container">
        <h4 class="fw-bold mb-0"><i class="bi bi-star me-2"></i>Aboneliklerim</h4>
    </div>
</div>

<div class="container my-4">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($user->is_premium)
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill me-2"></i><strong>Premium üyesiniz!</strong> Tüm ayrıcalıklardan faydalanıyorsunuz.
    </div>
    @endif

    @if($subscriptions->count() > 0)
    <div class="kodlab-card card p-4">
        <table class="table">
            <thead><tr><th>Plan</th><th>Durum</th><th>Başlangıç</th><th>Bitiş</th><th></th></tr></thead>
            <tbody>
                @foreach($subscriptions as $sub)
                <tr>
                    <td>{{ $sub->plan->name ?? '-' }}</td>
                    <td>
                        @if($sub->status === 'active')
                            <span class="badge bg-success">Aktif</span>
                        @elseif($sub->status === 'canceled')
                            <span class="badge bg-danger">İptal</span>
                        @elseif($sub->status === 'pending')
                            <span class="badge bg-warning">Beklemede</span>
                        @else
                            <span class="badge bg-secondary">Sonlandı</span>
                        @endif
                    </td>
                    <td>{{ $sub->starts_at?->format('d.m.Y') ?? '-' }}</td>
                    <td>{{ $sub->ends_at?->format('d.m.Y') ?? '-' }}</td>
                    <td>
                        @if($sub->status === 'active')
                        <form action="{{ route('payment.cancel', $sub) }}" method="POST" onsubmit="return confirm('Aboneliğinizi iptal etmek istediğinize emin misiniz?')">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger">İptal</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-star display-1 text-muted"></i>
        <h5 class="mt-3">Henüz aboneliğiniz yok</h5>
        <p class="text-muted">Premium ayrıcalıklardan faydalanmak için bir plan seçin.</p>
        <a href="{{ route('plans') }}" class="btn btn-kodlab">Planları Gör</a>
    </div>
    @endif
</div>
@endsection
