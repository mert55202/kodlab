@php
    $adSettings = \App\Models\AdSetting::first();
    $showAd = $adSettings && $adSettings->ads_enabled;
    if ($showAd && auth()->check() && auth()->user()->is_premium && $adSettings->hide_for_premium) {
        $showAd = false;
    }
@endphp

@if($showAd && isset($position) && $adSettings->{'show_in_' . $position})
<div class="ad-container text-center my-3 py-2" style="min-height: 90px;">
    <small class="text-muted d-block mb-1">- Reklam -</small>
    @if($adSettings->adsense_publisher_id)
        @php $slot = $adSettings->{'ad_slot_' . $position} ?? 'xxxxx'; @endphp
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="{{ $adSettings->adsense_publisher_id }}"
             data-ad-slot="{{ $slot }}"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    @else
        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 90px;">
            <span class="text-muted small">Reklam Alanı ({{ $position }})</span>
        </div>
    @endif
</div>
@endif
