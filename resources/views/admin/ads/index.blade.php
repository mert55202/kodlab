@extends('admin.layouts.app')

@section('title', 'Reklam Ayarları')

@section('content')
<h5 class="page-title"><i class="bi bi-megaphone me-2 text-kodlab"></i>Reklam Ayarları</h5>

<div class="card card-dashboard p-4">
    <form action="{{ route('admin.ads.update') }}" method="POST">
        @csrf

        <div class="mb-4">
            <div class="form-check form-switch">
                <input type="checkbox" name="ads_enabled" class="form-check-input" value="1" id="adsEnabled" {{ old('ads_enabled', $settings->ads_enabled) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="adsEnabled">Reklamları Etkinleştir</label>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">AdSense Yayıncı Kimliği</label>
            <input type="text" name="adsense_publisher_id" class="form-control" value="{{ old('adsense_publisher_id', $settings->adsense_publisher_id) }}" placeholder="pub-xxxxxxxxxxxxxx">
        </div>

        <h6 class="fw-bold mt-4 mb-3">Gösterim Konumları</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="form-check form-switch mb-2">
                    <input type="checkbox" name="show_in_header" class="form-check-input" value="1" id="showHeader" {{ old('show_in_header', $settings->show_in_header) ? 'checked' : '' }}>
                    <label class="form-check-label" for="showHeader">Header</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input type="checkbox" name="show_in_sidebar" class="form-check-input" value="1" id="showSidebar" {{ old('show_in_sidebar', $settings->show_in_sidebar) ? 'checked' : '' }}>
                    <label class="form-check-label" for="showSidebar">Sidebar</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch mb-2">
                    <input type="checkbox" name="show_in_lesson" class="form-check-input" value="1" id="showLesson" {{ old('show_in_lesson', $settings->show_in_lesson) ? 'checked' : '' }}>
                    <label class="form-check-label" for="showLesson">Ders İçi</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input type="checkbox" name="show_in_quiz" class="form-check-input" value="1" id="showQuiz" {{ old('show_in_quiz', $settings->show_in_quiz) ? 'checked' : '' }}>
                    <label class="form-check-label" for="showQuiz">Quiz</label>
                </div>
            </div>
        </div>

        <div class="form-check form-switch mt-3 mb-4">
            <input type="checkbox" name="hide_for_premium" class="form-check-input" value="1" id="hidePremium" {{ old('hide_for_premium', $settings->hide_for_premium) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="hidePremium">Premium kullanıcılardan gizle</label>
        </div>

        <h6 class="fw-bold mt-4 mb-3">Reklam Slotları</h6>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Header Slot</label>
                <input type="text" name="ad_slot_header" class="form-control" value="{{ old('ad_slot_header', $settings->ad_slot_header) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Sidebar Slot</label>
                <input type="text" name="ad_slot_sidebar" class="form-control" value="{{ old('ad_slot_sidebar', $settings->ad_slot_sidebar) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Ders İçi Slot</label>
                <input type="text" name="ad_slot_lesson" class="form-control" value="{{ old('ad_slot_lesson', $settings->ad_slot_lesson) }}">
            </div>
        </div>

        <button type="submit" class="btn btn-kodlab">Kaydet</button>
    </form>
</div>
@endsection
