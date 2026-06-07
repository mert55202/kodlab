@extends('admin.layouts.app')

@section('title', 'Dersler')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="page-title mb-0">Dersler</h5>
    <div>
        <form class="d-inline-block me-2" method="GET">
            <select name="course_id" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                <option value="">Tüm Kurslar</option>
                @foreach($courses as $c)
                <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('admin.lessons.create') }}" class="btn btn-kodlab btn-sm"><i class="bi bi-plus-lg me-1"></i>Yeni</a>
    </div>
</div>

<div class="card card-dashboard">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Sıra</th><th>Ders</th><th>Kurs</th><th>Süre</th><th>Kaynak</th><th>Durum</th><th></th></tr></thead>
            <tbody>
                @foreach($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->order }}</td>
                    <td>{{ $lesson->title }}</td>
                    <td>{{ $lesson->course->title ?? '-' }}</td>
                    <td>{{ $lesson->estimated_minutes ?? '-' }} dk</td>
                    <td><small class="text-muted">{{ Str::limit($lesson->source_ref, 20) }}</small></td>
                    <td>{!! $lesson->is_published ? '<span class="badge bg-success">Yayında</span>' : '<span class="badge bg-secondary">Taslak</span>' !!}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn btn-sm btn-outline-kodlab"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="d-inline" onsubmit="return confirm('Emin misiniz?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
