@extends('admin.layouts.app')

@section('title', isset($course) ? 'Kurs Düzenle' : 'Yeni Kurs')

@section('content')
<h5 class="page-title">{{ isset($course) ? 'Kurs Düzenle' : 'Yeni Kurs' }}</h5>

<div class="card card-dashboard p-4">
    <form action="{{ isset($course) ? route('admin.courses.update', $course) : route('admin.courses.store') }}" method="POST">
        @csrf
        @if(isset($course)) @method('PUT') @endif

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Başlık</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $course->title ?? '') }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $course->slug ?? '') }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $course->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">İkon</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon', $course->icon ?? 'bi bi-code') }}" placeholder="bi bi-code">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Zorluk</label>
                <select name="difficulty" class="form-select">
                    <option value="beginner" {{ old('difficulty', $course->difficulty ?? '') == 'beginner' ? 'selected' : '' }}>Başlangıç</option>
                    <option value="intermediate" {{ old('difficulty', $course->difficulty ?? '') == 'intermediate' ? 'selected' : '' }}>Orta</option>
                    <option value="advanced" {{ old('difficulty', $course->difficulty ?? '') == 'advanced' ? 'selected' : '' }}>İleri</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Sıra</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $course->order ?? 0) }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Açıklama</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $course->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_published" class="form-check-input" value="1" {{ old('is_published', $course->is_published ?? true) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold">Yayınla</label>
            </div>
        </div>

        <button type="submit" class="btn btn-kodlab">Kaydet</button>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">İptal</a>
    </form>
</div>
@endsection
