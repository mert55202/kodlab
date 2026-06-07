@extends('admin.layouts.app')

@section('title', 'Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="page-title mb-0"><i class="bi bi-speedometer2 me-2 text-kodlab"></i>Yönetim Paneli</h5>
</div>

<div class="row g-4">
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #6C5CE7, #4A00E0); position: relative; overflow: hidden;">
            <i class="bi bi-grid"></i>
            <h3 class="fw-bold mb-0">{{ $totalCategories }}</h3>
            <small>Kategori</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #0984E3, #00CEC9); position: relative; overflow: hidden;">
            <i class="bi bi-book"></i>
            <h3 class="fw-bold mb-0">{{ $totalCourses }}</h3>
            <small>Kurs</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #00b894, #00CEC9); position: relative; overflow: hidden;">
            <i class="bi bi-file-text"></i>
            <h3 class="fw-bold mb-0">{{ $totalLessons }}</h3>
            <small>Ders</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #e17055, #fdcb6e); position: relative; overflow: hidden;">
            <i class="bi bi-question-circle"></i>
            <h3 class="fw-bold mb-0">{{ $totalQuestions }}</h3>
            <small>Soru</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #6C5CE7, #a29bfe); position: relative; overflow: hidden;">
            <i class="bi bi-people"></i>
            <h3 class="fw-bold mb-0">{{ $totalUsers }}</h3>
            <small>Kullanıcı</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #e17055, #fd79a8); position: relative; overflow: hidden;">
            <i class="bi bi-patch-question"></i>
            <h3 class="fw-bold mb-0">{{ $totalQuizzes }}</h3>
            <small>Quiz</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #00b894, #55efc4); position: relative; overflow: hidden;">
            <i class="bi bi-trophy"></i>
            <h3 class="fw-bold mb-0">{{ $totalAttempts }}</h3>
            <small>Quiz Denemesi</small>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-md-6">
        <div class="card card-dashboard p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-people me-2 text-kodlab"></i>Son Kullanıcılar</h6>
            <table class="table table-sm">
                <thead><tr><th>Ad</th><th>E-posta</th><th>Kayıt</th></tr></thead>
                <tbody>
                    @foreach($recentUsers as $user)
                    <tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->created_at->diffForHumans() }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-dashboard p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-trophy me-2 text-kodlab"></i>Son Quiz Denemeleri</h6>
            <table class="table table-sm">
                <thead><tr><th>Kullanıcı</th><th>Quiz</th><th>Skor</th><th>Tarih</th></tr></thead>
                <tbody>
                    @foreach($recentAttempts as $attempt)
                    <tr>
                        <td>{{ $attempt->user->name ?? '?' }}</td>
                        <td>{{ $attempt->quiz->title ?? '?' }}</td>
                        <td><span class="badge bg-{{ $attempt->passed ? 'success' : 'danger' }}">%{{ $attempt->score }}</span></td>
                        <td>{{ $attempt->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
