<form class="quiz-form" data-quiz-id="{{ $quiz->id }}">
    @csrf
    @foreach($quiz->questions as $qIndex => $question)
    <div class="mb-4">
        <p class="fw-semibold">{{ $qIndex + 1 }}. {{ $question->question_text }}</p>
        @if($question->options && is_array($question->options))
            @foreach($question->options as $key => $value)
            <div class="quiz-option" data-question="{{ $question->id }}" data-answer="{{ $key }}" onclick="selectOption(this)">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" id="q{{ $question->id }}_{{ $key }}" style="display:none;">
                    <label class="form-check-label w-100" for="q{{ $question->id }}_{{ $key }}">
                        <strong>{{ $key }})</strong> {{ $value }}
                    </label>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    @endforeach
    @include('components.ads', ['position' => 'quiz'])
    <button type="submit" class="btn btn-kodlab w-100">Cevapları Gönder</button>
</form>

<div id="quiz-result-{{ $quiz->id }}" style="display:none;"></div>

<script>
function selectOption(el) {
    const parent = el.closest('.mb-4');
    parent.querySelectorAll('.quiz-option').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input').checked = true;
}

document.querySelectorAll('.quiz-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const quizId = this.dataset.quizId;
        const formData = new FormData(this);
        
        fetch('/quiz/' + quizId + '/submit', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            this.style.display = 'none';
            document.getElementById('quiz-result-' + quizId).innerHTML = html;
            document.getElementById('quiz-result-' + quizId).style.display = 'block';
        });
    });
});
</script>
