@extends('layouts.app')

@section('title', $query ? '"' . $query . '" arama sonuçları' : 'Arama')

@section('content')
<div class="bg-kodlab text-white py-4">
    <div class="container">
        <h4 class="fw-bold mb-0"><i class="bi bi-search me-2"></i>Arama Sonuçları</h4>
        @if($query)
        <p class="mb-0 opacity-75">"{{ $query }}" için {{ $lessons->count() }} sonuç bulundu</p>
        @endif
    </div>
</div>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form class="mb-4" action="{{ route('search') }}" method="GET">
                <div class="input-group">
                    <input type="search" name="q" class="form-control form-control-lg" placeholder="Ders ara..." value="{{ $query }}">
                    <button class="btn btn-kodlab px-4" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>

            @if($lessons->count() > 0)
                <div class="list-group">
                    @foreach($lessons as $lesson)
                    <a href="{{ route('lessons.show', [$lesson->course->slug, $lesson->slug]) }}" class="list-group-item list-group-item-action p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="fw-bold mb-1">{{ $lesson->title }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-book me-1"></i>{{ $lesson->course->title ?? '' }}
                                    · <i class="bi bi-clock me-1"></i>{{ $lesson->estimated_minutes ?? 0 }} dk
                                </small>
                            </div>
                            <i class="bi bi-chevron-right text-kodlab align-self-center"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            @elseif($query)
                <div class="text-center py-5">
                    <i class="bi bi-search display-1 text-muted"></i>
                    <h5 class="mt-3">Sonuç bulunamadı</h5>
                    <p class="text-muted">Farklı bir arama terimi deneyin.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
