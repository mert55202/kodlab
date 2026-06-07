<div class="quiz-result text-center mb-4">
    <div class="display-1 mb-3">
        @if($passed)
            <i class="bi bi-trophy-fill text-warning"></i>
        @else
            <i class="bi bi-emoji-frown text-danger"></i>
        @endif
    </div>
    <h4 class="fw-bold {{ $passed ? 'text-success' : 'text-danger' }}">
        {{ $passed ? 'Tebrikler, geçtiniz!' : 'Üzgünüz, kalamadınız.' }}
    </h4>
    <div class="my-4">
        <div class="display-3 fw-bold text-kodlab">{{ $score }}%</div>
        <p class="text-muted">{{ $correctCount }} / {{ $totalQuestions }} doğru</p>
    </div>
    <div class="progress mb-4" style="height: 10px;">
        <div class="progress-bar progress-bar-kodlab" role="progressbar" style="width: {{ $score }}%"></div>
    </div>
</div>

<div class="accordion" id="quizResults">
    @foreach($results as $index => $result)
    <div class="accordion-item mb-2 border-0 shadow-sm rounded">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#r{{ $index }}">
                <span class="me-2">{{ $index + 1 }}.</span>
                @if($result['is_correct'])
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                @else
                    <i class="bi bi-x-circle-fill text-danger me-2"></i>
                @endif
                <span class="text-truncate">{{ $result['question'] }}</span>
            </button>
        </h2>
        <div id="r{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#quizResults">
            <div class="accordion-body">
                <p class="mb-1"><strong>Verdiğiniz Cevap:</strong>
                    <span class="{{ $result['is_correct'] ? 'text-success' : 'text-danger' }}">{{ $result['user_answer'] ?: 'Cevap verilmedi' }}</span>
                </p>
                @if(!$result['is_correct'])
                <p class="mb-1"><strong>Doğru Cevap:</strong> <span class="text-success">{{ $result['correct_answer'] }}</span></p>
                @endif
                @if($result['explanation'])
                <p class="mb-0 text-muted mt-2"><i class="bi bi-info-circle me-1"></i>{{ $result['explanation'] }}</p>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="text-center mt-4">
    <button onclick="location.reload()" class="btn btn-kodlab">
        <i class="bi bi-arrow-counterclockwise me-2"></i>Tekrar Dene
    </button>
</div>
