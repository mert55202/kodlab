@extends('layouts.app')

@section('title', 'Panel')

@section('content')
<div class="bg-kodlab text-white py-4">
    <div class="container">
        <h4 class="fw-bold mb-0"><i class="bi bi-speedometer2 me-2"></i>Panel</h4>
        <p class="mb-0 opacity-75">Hoş geldin, {{ $user->name }}!</p>
    </div>
</div>

<div class="container my-4">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="kodlab-card card p-3 text-center">
                <div class="display-5 text-kodlab">{{ $completedLessons }}</div>
                <small class="text-muted">Tamamlanan Ders</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kodlab-card card p-3 text-center">
                <div class="display-5 text-kodlab">{{ $quizAttempts }}</div>
                <small class="text-muted">Quiz Denemesi</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kodlab-card card p-3 text-center">
                <div class="display-5 text-kodlab">{{ number_format($avgScore, 1) }}%</div>
                <small class="text-muted">Ortalama Skor</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kodlab-card card p-3 text-center">
                <div class="display-5 text-kodlab">{{ $badges->count() }}</div>
                <small class="text-muted">Rozet</small>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-md-7">
            <div class="kodlab-card card p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-trophy me-2 text-kodlab"></i>Rozetlerim</h5>
                @if($badges->count() > 0)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($badges as $badge)
                        <span class="badge rounded-pill fs-6 p-2" style="background: {{ $badge->color ?? '#6C5CE7' }};">
                            <i class="{{ $badge->icon ?? 'bi bi-star-fill' }} me-1"></i>{{ $badge->name }}
                        </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">Henüz rozet kazanmadınız. Quizleri çözerek rozet kazanın!</p>
                @endif
            </div>
        </div>
        <div class="col-md-5">
            <div class="kodlab-card card p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-bookmark me-2 text-kodlab"></i>Son Yer İmleri</h5>
                @if($bookmarks->count() > 0)
                    <ul class="list-unstyled mb-0">
                        @foreach($bookmarks as $bm)
                        <li class="mb-2">
                            <a href="{{ route('lessons.show', [$bm->lesson->course->slug ?? '', $bm->lesson->slug]) }}" class="text-decoration-none">
                                <i class="bi bi-link-45deg text-kodlab me-1"></i>{{ $bm->lesson->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">Henüz yer iminiz yok.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('courses.index') }}" class="btn btn-kodlab btn-lg">
            <i class="bi bi-play-circle me-2"></i>Öğrenmeye Devam Et
        </a>
    </div>
</div>
@endsection
