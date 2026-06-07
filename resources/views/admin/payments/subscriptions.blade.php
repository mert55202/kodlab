@extends('admin.layouts.app')

@section('title', 'Abonelikler')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="page-title mb-0"><i class="bi bi-star me-2 text-kodlab"></i>Abonelikler</h5>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-kodlab btn-sm">Ödemeler</a>
</div>

<div class="card card-dashboard">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>#</th><th>Kullanıcı</th><th>Plan</th><th>Durum</th><th>Başlangıç</th><th>Bitiş</th></tr></thead>
            <tbody>
                @foreach($subscriptions as $sub)
                <tr>
                    <td>{{ $sub->id }}</td>
                    <td>{{ $sub->user->name ?? '-' }}</td>
                    <td>{{ $sub->plan->name ?? '-' }}</td>
                    <td>{!! $sub->status === 'active' ? '<span class="badge bg-success">Aktif</span>' : ($sub->status === 'canceled' ? '<span class="badge bg-danger">İptal</span>' : '<span class="badge bg-secondary">Sonlandı</span>') !!}</td>
                    <td><small>{{ $sub->starts_at?->format('d.m.Y') ?? '-' }}</small></td>
                    <td><small>{{ $sub->ends_at?->format('d.m.Y') ?? '-' }}</small></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $subscriptions->links() }}</div>
@endsection
