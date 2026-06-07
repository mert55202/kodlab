@extends('layouts.app')

@section('title', 'Kurslar')

@section('content')
<div class="bg-kodlab text-white py-4">
    <div class="container">
        <h2 class="fw-bold mb-0"><i class="bi bi-book me-2"></i>Tüm Kurslar</h2>
        <p class="mb-0 opacity-75">Sıfırdan uzmanlığa, adım adım öğrenin.</p>
    </div>
</div>

<div class="container my-4">
    <div class="row g-4">
        @foreach($categories as $category)
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                <i class="{{ $category->icon }} fs-3 me-2" style="color: {{ $category->color }}"></i>
                <h5 class="fw-bold mb-0">{{ $category->name }}</h5>
                <span class="badge bg-light text-dark ms-2">{{ $category->courses_count }} kurs</span>
            </div>
            <div class="row g-3">
                @foreach($courses->where('category_id', $category->id) as $course)
                <div class="col-md-4 col-lg-3">
                    <a href="{{ route('courses.show', $course->slug) }}" class="text-decoration-none">
                        <div class="kodlab-card card h-100">
                            <div class="card-body text-center p-4">
                                <i class="{{ $course->icon }} display-5 mb-3" style="color: {{ $category->color }}"></i>
                                <h6 class="fw-bold text-dark mb-2">{{ $course->title }}</h6>
                                <span class="badge bg-{{ $course->difficulty === 'beginner' ? 'success' : ($course->difficulty === 'intermediate' ? 'warning' : 'danger') }}">
                                    {{ $course->difficulty === 'beginner' ? 'Başlangıç' : ($course->difficulty === 'intermediate' ? 'Orta' : 'İleri') }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
