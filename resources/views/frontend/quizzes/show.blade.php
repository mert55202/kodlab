@extends('layouts.app')

@section('title', $quiz->title)

@section('content')
<div class="bg-kodlab text-white py-4">
    <div class="container">
        <h4 class="fw-bold mb-0"><i class="bi bi-question-circle me-2"></i>{{ $quiz->title }}</h4>
        <p class="mb-0 opacity-75">{{ $quiz->description }}</p>
        <small>{{ $quiz->questions->count() }} soru · Geçme notu: %{{ $quiz->passing_score }}</small>
    </div>
</div>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="kodlab-card card p-4">
                @include('frontend.quizzes._take', ['quiz' => $quiz])
            </div>
        </div>
    </div>
</div>
@endsection
