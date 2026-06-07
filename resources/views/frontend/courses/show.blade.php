@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="bg-kodlab text-white py-4">
    <div class="container">
        <a href="{{ route('courses.index') }}" class="text-white text-decoration-none opacity-75 small">&larr; Tüm Kurslar</a>
        <div class="d-flex align-items-center mt-2">
            <i class="{{ $course->icon }} fs-1 me-3"></i>
            <div>
                <h3 class="fw-bold mb-1">{{ $course->title }}</h3>
                <p class="mb-0 opacity-75">{{ $course->description }}</p>
                <span class="small opacity-75">{{ $lessons->count() }} ders · ~{{ $totalDuration }} dk</span>
            </div>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <div class="col-md-3 mb-4">
            @include('components.ads', ['position' => 'sidebar'])
            <div class="kodlab-card card p-3">
                <h6 class="fw-bold mb-3"><i class="bi bi-list-ul me-2"></i>İçindekiler</h6>
                <div class="list-group list-group-flush">
                    @foreach($allLessons ?? $lessons as $l)
                    <a href="{{ route('lessons.show', [$course->slug, $l->slug]) }}" 
                       class="list-group-item list-group-item-action border-0 px-2 py-2 small
                              {{ isset($lesson) && $lesson->id === $l->id ? 'active bg-kodlab' : '' }}">
                        <i class="bi bi-play-circle me-2"></i>{{ $l->title }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-9">
            @if(isset($lesson))
                @include('frontend.lessons._content')
            @else
                <div class="kodlab-card card p-5 text-center">
                    <i class="bi bi-arrow-left-circle display-3 text-kodlab mb-3"></i>
                    <h5>Bir ders seçin</h5>
                    <p class="text-muted">Soldaki listeden bir ders seçerek öğrenmeye başlayın.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
