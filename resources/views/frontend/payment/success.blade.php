@extends('layouts.app')

@section('title', 'Ödeme Başarılı')

@section('content')
<div class="container my-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="kodlab-card card p-5">
                <i class="bi bi-check-circle-fill text-success display-1 mb-4"></i>
                <h3 class="fw-bold mb-2">Ödeme Başarılı!</h3>
                <p class="text-muted mb-4">Artık premium üyemizsiniz. Tüm ayrıcalıklardan faydalanabilirsiniz.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('profile.dashboard') }}" class="btn btn-kodlab">
                        <i class="bi bi-speedometer2 me-2"></i>Paneli Gör
                    </a>
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-kodlab">
                        <i class="bi bi-book me-2"></i>Derslere Başla
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
