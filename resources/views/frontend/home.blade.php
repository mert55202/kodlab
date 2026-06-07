@extends('layouts.app')

@section('title', 'Ana Sayfa')

@section('content')
<div class="hero-section">
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold mb-3">Kodlamayı Öğren, Geleceğini Şekillendir</h1>
        <p class="lead mb-4">HTML'den Laravel'e, sıfırdan uzmanlığa ücretsiz eğitimler. Hemen başla!</p>
        <div class="d-flex justify-content-center gap-3 mb-5">
            <a href="{{ route('courses.index') }}" class="btn btn-light btn-lg px-4 fw-semibold">
                <i class="bi bi-play-circle me-2"></i>Hemen Başla
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                <i class="bi bi-person-plus me-2"></i>Ücretsiz Üye Ol
            </a>
        </div>
        <div class="row justify-content-center text-center">
            <div class="col-md-3 col-6 mb-3">
                <div class="fs-1 fw-bold">{{ $totalCourses }}</div>
                <div class="opacity-75">Kurs</div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="fs-1 fw-bold">{{ $totalLessons }}</div>
                <div class="opacity-75">Ders</div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="fs-1 fw-bold">{{ $totalQuizzes }}</div>
                <div class="opacity-75">Quiz</div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="fs-1 fw-bold">100%</div>
                <div class="opacity-75">Ücretsiz</div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center"><i class="bi bi-grid me-2 text-kodlab"></i>Kategoriler</h2>
    <div class="row g-3 justify-content-center">
        @foreach($categories as $category)
        <div class="col-md-3 col-6">
            <a href="{{ route('courses.index') }}?category={{ $category->slug }}" class="text-decoration-none">
                <div class="kodlab-card card text-center p-4 h-100">
                    <div class="card-body">
                        <i class="{{ $category->icon }} display-5 mb-3" style="color: {{ $category->color }}"></i>
                        <h6 class="fw-bold mb-1">{{ $category->name }}</h6>
                        <small class="text-muted">{{ $category->courses_count ?? $category->courses->count() }} kurs</small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<div class="container my-5">
    <h2 class="fw-bold mb-4"><i class="bi bi-book me-2 text-kodlab"></i>Tüm Kurslar</h2>
    <div class="row g-4">
        @foreach($courses as $course)
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('courses.show', $course->slug) }}" class="text-decoration-none">
                <div class="kodlab-card card h-100">
                    <div class="card-body text-center p-4">
                        <i class="{{ $course->icon }} display-4 mb-3" style="color: {{ $course->category->color ?? '#6C5CE7' }}"></i>
                        <h6 class="fw-bold text-dark mb-2">{{ $course->title }}</h6>
                        <span class="badge bg-light text-dark category-badge">
                            {{ $course->category->name ?? '' }}
                        </span>
                        <div class="mt-3">
                            <span class="badge bg-{{ $course->difficulty === 'beginner' ? 'success' : ($course->difficulty === 'intermediate' ? 'warning' : 'danger') }}">
                                {{ $course->difficulty === 'beginner' ? 'Başlangıç' : ($course->difficulty === 'intermediate' ? 'Orta' : 'İleri') }}
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<div class="container my-5">
    <div class="row align-items-center kodlab-card p-5">
        <div class="col-md-8">
            <h3 class="fw-bold">Premium'a Geç, Reklamsız Öğren</h3>
            <p class="text-muted mb-0">Sınırsız quiz, sertifika, rozetler ve reklamsız deneyim için KodLab Plus'a katıl!</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('plans') }}" class="btn btn-kodlab btn-lg px-4">Paketleri Gör</a>
        </div>
    </div>
</div>
@endsection
