@extends('admin.layouts.app')

@section('title', 'Kullanıcı Düzenle')

@section('content')
<h5 class="page-title">Kullanıcı Düzenle: {{ $user->name }}</h5>

<div class="card card-dashboard p-4">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Ad</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">E-posta</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Puan</label>
                <input type="number" name="total_points" class="form-control" value="{{ old('total_points', $user->total_points ?? 0) }}">
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-check mt-4">
                    <input type="checkbox" name="is_premium" class="form-check-input" value="1" {{ old('is_premium', $user->is_premium) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold">Premium</label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-kodlab">Kaydet</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">İptal</a>
    </form>
</div>
@endsection
