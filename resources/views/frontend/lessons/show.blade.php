@extends('layouts.app')

@section('title', $lesson->title)

@section('content')
<div class="bg-kodlab text-white py-3">
    <div class="container">
        <a href="{{ route('courses.show', $course->slug) }}" class="text-white text-decoration-none opacity-75 small">
            &larr; {{ $course->title }}
        </a>
        <h4 class="fw-bold mt-1 mb-0">{{ $lesson->title }}</h4>
        <span class="small opacity-75">Ders {{ $lesson->order }} · ~{{ $lesson->estimated_minutes }} dk</span>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <div class="col-md-3 mb-4">
            @include('components.ads', ['position' => 'sidebar'])
            <div class="kodlab-card card p-3 sticky-top" style="top: 20px;">
                <h6 class="fw-bold mb-3"><i class="bi bi-list-ul me-2"></i>{{ $course->title }}</h6>
                @foreach($allLessons as $l)
                <a href="{{ route('lessons.show', [$course->slug, $l->slug]) }}" 
                   class="sidebar-link {{ $l->id === $lesson->id ? 'active' : '' }}">
                    <small>{{ $l->order }}.</small> {{ Str::limit($l->title, 35) }}
                    @if($l->id === $lesson->id)
                    <i class="bi bi-play-fill float-end text-kodlab"></i>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        <div class="col-md-9">
            <div class="kodlab-card card p-4 mb-4">
                @include('frontend.lessons._content')
            </div>

            @if($lesson->video_url)
            <div class="kodlab-card card p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-play-circle me-2 text-kodlab"></i>Video Anlatım</h5>
                <div class="ratio ratio-16x9">
                    <iframe src="{{ $lesson->video_url }}" title="{{ $lesson->title }}" allowfullscreen></iframe>
                </div>
            </div>
            @endif

            @if($lesson->code_example)
            <div class="kodlab-card card p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-code me-2 text-kodlab"></i>Kod Örneği</h5>
                <pre><code>{{ $lesson->code_example }}</code></pre>
                <button class="btn btn-sm btn-outline-kodlab mt-2" onclick="copyCode(this)">
                    <i class="bi bi-clipboard me-1"></i>Kopyala
                </button>
            </div>
            @endif

            @if($lesson->codeExercises->count() > 0)
            <div class="kodlab-card card p-4 mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2 text-kodlab"></i>Kod Egzersizi</h5>
                @foreach($lesson->codeExercises as $exercise)
                <div class="mb-3">
                    <h6>{{ $exercise->title }}</h6>
                    <p class="text-muted small">{{ $exercise->description }}</p>
                    <pre><code>{{ $exercise->initial_code }}</code></pre>
                </div>
                @endforeach
            </div>
            @endif

            @if($lesson->quizzes->count() > 0)
                @foreach($lesson->quizzes as $quiz)
                <div class="kodlab-card card p-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-question-circle me-2 text-kodlab"></i>{{ $quiz->title }}</h5>
                    @include('frontend.quizzes._take', ['quiz' => $quiz])
                </div>
                @endforeach
            @endif

            <div class="d-flex justify-content-between mt-4">
                @if($prevLesson)
                <a href="{{ route('lessons.show', [$course->slug, $prevLesson->slug]) }}" class="btn btn-outline-kodlab">
                    <i class="bi bi-arrow-left me-2"></i>{{ $prevLesson->title }}
                </a>
                @else
                <div></div>
                @endif
                @if($nextLesson)
                <a href="{{ route('lessons.show', [$course->slug, $nextLesson->slug]) }}" class="btn btn-kodlab">
                    {{ $nextLesson->title }}<i class="bi bi-arrow-right ms-2"></i>
                </a>
                @else
                <div></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyCode(btn) {
    const code = btn.previousElementSibling.querySelector('code').innerText;
    navigator.clipboard.writeText(code).then(() => {
        btn.innerHTML = '<i class="bi bi-check me-1"></i>Kopyalandı!';
        setTimeout(() => btn.innerHTML = '<i class="bi bi-clipboard me-1"></i>Kopyala', 2000);
    });
}
</script>
@endpush
