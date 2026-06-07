@extends('admin.layouts.app')

@section('title', 'Kullanıcılar')

@section('content')
<h5 class="page-title">Kullanıcılar</h5>

<div class="card card-dashboard">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>#</th><th>Ad</th><th>E-posta</th><th>Puan</th><th>Premium</th><th>Quiz</th><th>Kayıt</th><th></th></tr></thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->total_points ?? 0 }}</td>
                    <td>{!! $user->is_premium ? '<span class="badge bg-warning">Premium</span>' : '<span class="badge bg-secondary">Ücretsiz</span>' !!}</td>
                    <td>{{ $user->quiz_attempts_count }}</td>
                    <td><small class="text-muted">{{ $user->created_at->format('d.m.Y') }}</small></td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-kodlab"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Emin misiniz?')">
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
<div class="mt-3">{{ $users->links() }}</div>
@endsection
