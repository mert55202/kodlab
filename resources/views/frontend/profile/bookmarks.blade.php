@extends('layouts.app')

@section('title', 'Yer İmleri')

@section('content')
<div class="bg-kodlab text-white py-4">
    <div class="container">
        <h4 class="fw-bold mb-0"><i class="bi bi-bookmark me-2"></i>Yer İmleri</h4>
        <p class="mb-0 opacity-75">Kaydettiğiniz dersler</p>
    </div>
</div>

<div class="container my-4">
    @if($bookmarks->count() > 0)
        <div class="row g-3">
            @foreach($bookmarks as $bm)
            <div class="col-md-6">
                <div class="kodlab-card card p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-bold mb-1">
                                <a href="{{ route('lessons.show', [$bm->lesson->course->slug ?? '', $bm->lesson->slug]) }}" class="text-decoration-none text-dark">
                                    {{ $bm->lesson->title }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="bi bi-book me-1"></i>{{ $bm->lesson->course->title ?? 'Kurs' }}
                                @if($bm->lesson->estimated_minutes)
                                · ~{{ $bm->lesson->estimated_minutes }} dk
                                @endif
                            </small>
                        </div>
                        <form action="{{ route('profile.bookmark.toggle', $bm->lesson_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                    <small class="text-muted mt-2">
                        <i class="bi bi-clock me-1"></i>{{ $bm->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $bookmarks->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-bookmark display-1 text-muted"></i>
            <h5 class="mt-3">Henüz yer iminiz yok</h5>
            <p class="text-muted">Dersleri gezerken beğendiğiniz dersleri yer imlerine ekleyin.</p>
            <a href="{{ route('courses.index') }}" class="btn btn-kodlab">Kursları Keşfet</a>
        </div>
    @endif
</div>
@endsection
