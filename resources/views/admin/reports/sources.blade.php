@extends('admin.layouts.app')

@section('title', 'Kaynak Raporları')

@section('content')
<h5 class="page-title"><i class="bi bi-bar-chart me-2 text-kodlab"></i>Kaynak Raporları</h5>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-dashboard p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-file-text me-2 text-kodlab"></i>Ders Kaynakları</h6>
            <table class="table table-sm">
                <thead><tr><th>Kaynak</th><th>Ders Sayısı</th></tr></thead>
                <tbody>
                    @foreach($lessonsBySource as $item)
                    <tr><td>{{ $item->source_ref }}</td><td><span class="badge bg-kodlab">{{ $item->total }}</span></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-dashboard p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-question-circle me-2 text-kodlab"></i>Soru Kaynakları</h6>
            <table class="table table-sm">
                <thead><tr><th>Kaynak</th><th>Soru Sayısı</th></tr></thead>
                <tbody>
                    @foreach($questionsBySource as $item)
                    <tr><td>{{ $item->source_ref }}</td><td><span class="badge bg-kodlab">{{ $item->total }}</span></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
