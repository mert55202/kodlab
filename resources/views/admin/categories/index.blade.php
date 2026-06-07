@extends('admin.layouts.app')

@section('title', 'Kategoriler')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="page-title mb-0">Kategoriler</h5>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-kodlab btn-sm"><i class="bi bi-plus-lg me-1"></i>Yeni</a>
</div>

<div class="card card-dashboard">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Sıra</th><th>İkon</th><th>Ad</th><th>İngilizce</th><th>Kurs</th><th>Durum</th><th></th></tr></thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td>{{ $cat->order }}</td>
                    <td><i class="{{ $cat->icon }}" style="color: {{ $cat->color }}"></i></td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->name_en ?? '-' }}</td>
                    <td>{{ $cat->courses_count }}</td>
                    <td>{!! $cat->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Pasif</span>' !!}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-kodlab"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Emin misiniz?')">
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
