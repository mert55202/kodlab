@extends('admin.layouts.app')

@section('title', isset($category) ? 'Kategori Düzenle' : 'Yeni Kategori')

@section('content')
<h5 class="page-title">{{ isset($category) ? 'Kategori Düzenle' : 'Yeni Kategori' }}</h5>

<div class="card card-dashboard p-4">
    <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
        @csrf
        @if(isset($category)) @method('PUT') @endif

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Ad</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">İngilizce Ad</label>
                <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $category->name_en ?? '') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug ?? '') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">İkon (Bootstrap İkon)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon', $category->icon ?? 'bi bi-folder') }}" placeholder="bi bi-folder">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Renk</label>
                <input type="color" name="color" class="form-control form-control-color" value="{{ old('color', $category->color ?? '#6C5CE7') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Sıra</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $category->order ?? 0) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Durum</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ (old('is_active', $category->is_active ?? true) ? 'selected' : '') }}>Aktif</option>
                    <option value="0" {{ (old('is_active', $category->is_active ?? true) ? '' : 'selected') }}>Pasif</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Açıklama</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-kodlab">Kaydet</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">İptal</a>
    </form>
</div>
@endsection
