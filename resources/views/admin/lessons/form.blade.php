@extends('admin.layouts.app')

@section('title', isset($lesson) ? 'Ders Düzenle' : 'Yeni Ders')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/codemirror@5.65.18/lib/codemirror.min.css">
<style>.CodeMirror { border: 1px solid #ddd; border-radius: 8px; height: 300px; }</style>
@endpush

@section('content')
<h5 class="page-title">{{ isset($lesson) ? 'Ders Düzenle' : 'Yeni Ders' }}</h5>

<div class="card card-dashboard p-4">
    <form action="{{ isset($lesson) ? route('admin.lessons.update', $lesson) : route('admin.lessons.store') }}" method="POST">
        @csrf
        @if(isset($lesson)) @method('PUT') @endif

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Başlık</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $lesson->title ?? '') }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $lesson->slug ?? '') }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Kurs</label>
                <select name="course_id" class="form-select" required>
                    @foreach($courses as $c)
                    <option value="{{ $c->id }}" {{ old('course_id', $lesson->course_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Sıra</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $lesson->order ?? 0) }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Tahmini Süre (dk)</label>
                <input type="number" name="estimated_minutes" class="form-control" value="{{ old('estimated_minutes', $lesson->estimated_minutes ?? 10) }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Video URL</label>
                <input type="text" name="video_url" class="form-control" value="{{ old('video_url', $lesson->video_url ?? '') }}" placeholder="https://...">
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-check mt-4">
                    <input type="checkbox" name="is_published" class="form-check-input" value="1" {{ old('is_published', $lesson->is_published ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold">Yayınla</label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Açıklama</label>
            <textarea name="description" class="form-control" rows="2">{{ old('description', $lesson->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">İçerik (HTML)</label>
            <textarea name="content" id="content-editor" class="form-control" rows="15">{{ old('content', $lesson->content ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Kod Örneği</label>
            <textarea name="code_example" id="code-editor" class="form-control" rows="8">{{ old('code_example', $lesson->code_example ?? '') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Kaynak Referansı</label>
                <input type="text" name="source_ref" class="form-control" value="{{ old('source_ref', $lesson->source_ref ?? '') }}" placeholder="MDN, W3Schools, vs.">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Kaynak Notu</label>
                <input type="text" name="source_note" class="form-control" value="{{ old('source_note', $lesson->source_note ?? '') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-kodlab">Kaydet</button>
        <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary">İptal</a>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.65.18/lib/codemirror.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.65.18/mode/xml/xml.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.65.18/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.65.18/mode/javascript/javascript.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var contentEditor = CodeMirror.fromTextArea(document.getElementById('content-editor'), {
        mode: 'htmlmixed', lineNumbers: true, theme: 'default', lineWrapping: true
    });
    var codeEditor = CodeMirror.fromTextArea(document.getElementById('code-editor'), {
        mode: 'htmlmixed', lineNumbers: true, theme: 'default', lineWrapping: true
    });
    document.querySelector('form').addEventListener('submit', function() {
        contentEditor.save();
        codeEditor.save();
    });
});
</script>
@endpush
