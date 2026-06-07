@extends('layouts.app')

@section('title', 'Profil Ayarları')

@section('content')
<div class="bg-kodlab text-white py-4">
    <div class="container">
        <h4 class="fw-bold mb-0"><i class="bi bi-gear me-2"></i>Profil Ayarları</h4>
    </div>
</div>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="kodlab-card card p-4">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ad Soyad</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Hakkımda</label>
                        <textarea name="bio" class="form-control" rows="3">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Web Sitesi</label>
                            <input type="url" name="website" class="form-control" value="{{ old('website', $user->website) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">GitHub</label>
                            <input type="text" name="github" class="form-control" value="{{ old('github', $user->github) }}" placeholder="kullaniciadi">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Twitter</label>
                            <input type="text" name="twitter" class="form-control" value="{{ old('twitter', $user->twitter) }}" placeholder="@kullaniciadi">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">LinkedIn</label>
                            <input type="text" name="linkedin" class="form-control" value="{{ old('linkedin', $user->linkedin) }}" placeholder="kullaniciadi">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tema</label>
                        <select name="theme" class="form-select">
                            <option value="light" {{ $user->theme === 'light' ? 'selected' : '' }}>{{ __('Aydınlık') }}</option>
                            <option value="dark" {{ $user->theme === 'dark' ? 'selected' : '' }}>{{ __('Karanlık') }}</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-kodlab w-100">Kaydet</button>
                </form>
            </div>

            <div class="kodlab-card card p-4 mt-4">
                <h5 class="fw-bold text-danger mb-3"><i class="bi bi-exclamation-triangle me-2"></i>Hesabı Sil</h5>
                <p class="text-muted small">Hesabınızı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Hesabınızı silmek istediğinize emin misiniz?')">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Şifrenizi girin" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Hesabımı Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
