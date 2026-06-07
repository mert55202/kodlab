<div class="lesson-content">
    {!! $lesson->content !!}
</div>
@include('components.ads', ['position' => 'lesson'])
@if($lesson->source_ref)
<div class="mt-4 p-3 bg-light rounded">
    <small class="text-muted">
        <i class="bi bi-info-circle me-1"></i>
        <strong>Kaynak:</strong> {{ $lesson->source_ref }}
        @if($lesson->source_note)
        <br><span class="fst-italic">{{ $lesson->source_note }}</span>
        @endif
    </small>
</div>
@endif

@auth
<button class="btn btn-sm {{ auth()->user()->bookmarks->contains('lesson_id', $lesson->id) ? 'btn-kodlab' : 'btn-outline-kodlab' }} mt-2"
        onclick="toggleBookmark({{ $lesson->id }})">
    <i class="bi bi-bookmark{{ auth()->user()->bookmarks->contains('lesson_id', $lesson->id) ? '-fill' : '' }} me-1"></i>
    Yer İmi
</button>
<form id="bookmark-form-{{ $lesson->id }}" action="{{ route('profile.bookmark.toggle', $lesson->id) }}" method="POST" class="d-none">
    @csrf
</form>
<script>
function toggleBookmark(id) {
    document.getElementById('bookmark-form-' + id).submit();
}
</script>
@endauth

<style>
.lesson-content h1 { font-size: 1.8rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 1rem; }
.lesson-content h2 { font-size: 1.5rem; font-weight: 600; margin-top: 1.2rem; margin-bottom: 0.8rem; color: var(--kodlab-primary); }
.lesson-content h3 { font-size: 1.2rem; font-weight: 600; margin-top: 1rem; margin-bottom: 0.5rem; }
.lesson-content p { line-height: 1.7; margin-bottom: 1rem; }
.lesson-content pre { background: #1e1e2e; color: #cdd6f4; padding: 16px; border-radius: 10px; overflow-x: auto; margin: 1rem 0; }
.lesson-content code { background: #f0edff; color: #6C5CE7; padding: 2px 6px; border-radius: 4px; font-size: 0.9em; }
.lesson-content pre code { background: none; color: inherit; padding: 0; }
.lesson-content ul, .lesson-content ol { margin-bottom: 1rem; padding-left: 1.5rem; }
.lesson-content li { margin-bottom: 0.3rem; }
.lesson-content img { max-width: 100%; border-radius: 8px; margin: 1rem 0; }
.lesson-content blockquote { border-left: 4px solid var(--kodlab-primary); padding-left: 1rem; margin: 1rem 0; color: #666; font-style: italic; }
.lesson-content table { width: 100%; margin: 1rem 0; border-collapse: collapse; }
.lesson-content th, .lesson-content td { border: 1px solid #ddd; padding: 8px; text-align: left; }
.lesson-content th { background: #f8f7ff; }
</style>
