@extends('admin.layouts.app')

@section('title', 'Kurslar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="page-title mb-0">Kurslar</h5>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-kodlab btn-sm"><i class="bi bi-plus-lg me-1"></i>Yeni</a>
</div>

<div class="card card-dashboard">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Sıra</th><th>Kurs</th><th>Kategori</th><th>Zorluk</th><th>Ders</th><th>Durum</th><th></th></tr></thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td>{{ $course->order }}</td>
                    <td><i class="{{ $course->icon }} me-2"></i>{{ $course->title }}</td>
                    <td>{{ $course->category->name ?? '-' }}</td>
                    <td><span class="badge bg-{{ $course->difficulty === 'beginner' ? 'success' : ($course->difficulty === 'intermediate' ? 'warning' : 'danger') }}">{{ $course->difficulty }}</span></td>
                    <td>{{ $course->lessons_count ?? $course->lessons()->count() }}</td>
                    <td>{!! $course->is_published ? '<span class="badge bg-success">Yayında</span>' : '<span class="badge bg-secondary">Taslak</span>' !!}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-kodlab"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Emin misiniz?')">
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
