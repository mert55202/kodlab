@extends('admin.layouts.app')

@section('title', 'Ödemeler')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="page-title mb-0"><i class="bi bi-credit-card me-2 text-kodlab"></i>Ödemeler</h5>
    <a href="{{ route('admin.payments.subscriptions') }}" class="btn btn-outline-kodlab btn-sm">Abonelikler</a>
</div>

<div class="card card-dashboard">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>#</th><th>Kullanıcı</th><th>Tutar</th><th>Durum</th><th>Yöntem</th><th>Tarih</th></tr></thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->user->name ?? '-' }}</td>
                    <td><strong>{{ number_format($payment->amount, 2) }} ₺</strong></td>
                    <td>{!! $payment->status === 'completed' ? '<span class="badge bg-success">Başarılı</span>' : ($payment->status === 'pending' ? '<span class="badge bg-warning">Beklemede</span>' : '<span class="badge bg-danger">Başarısız</span>') !!}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td><small>{{ $payment->created_at->format('d.m.Y H:i') }}</small></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $payments->links() }}</div>
@endsection
