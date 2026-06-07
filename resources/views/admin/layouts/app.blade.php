<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - KodLab Yönetim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --kodlab-primary: #6C5CE7;
            --kodlab-gradient: linear-gradient(135deg, #6C5CE7, #4A00E0, #0984E3);
            --sidebar-width: 250px;
        }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f4f6f9; }
        .wrapper { display: flex; }
        .sidebar { width: var(--sidebar-width); min-height: 100vh; background: #1a1a2e; position: fixed; left: 0; top: 0; z-index: 100; overflow-y: auto; }
        .sidebar .nav-link { color: #a0a0b0; padding: 10px 20px; font-size: 14px; border-left: 3px solid transparent; transition: all 0.2s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background: rgba(108,92,231,0.15); border-left-color: var(--kodlab-primary); }
        .sidebar .nav-link i { width: 22px; }
        .content { margin-left: var(--sidebar-width); flex: 1; padding: 20px; min-height: 100vh; }
        .navbar-top { background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin: -20px -20px 20px -20px; padding: 12px 24px; }
        .card-dashboard { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .stat-card { border-radius: 12px; padding: 20px; color: white; }
        .stat-card i { opacity: 0.3; font-size: 2.5rem; position: absolute; right: 15px; top: 15px; }
        .table > :not(caption) > * > * { vertical-align: middle; }
        .btn-kodlab { background: var(--kodlab-gradient); color: white; border: none; }
        .btn-kodlab:hover { opacity: 0.9; color: white; }
        .breadcrumb { background: none; padding: 0; margin: 0; }
        .page-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 20px; }
        @media (max-width: 768px) { .sidebar { width: 60px; } .sidebar .nav-link span { display: none; } .content { margin-left: 60px; } }
    </style>
    @stack('styles')
</head>
<body>
<div class="wrapper">
    <div class="sidebar p-3">
        <a href="{{ route('admin.dashboard') }}" class="text-white fw-bold fs-5 text-decoration-none d-block mb-4 px-2">
            <i class="bi bi-code-slash me-2"></i><span>KodLab</span>
        </a>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> <span>Panel</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="bi bi-grid"></i> <span>Kategoriler</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
                <i class="bi bi-book"></i> <span>Kurslar</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.lessons.*') ? 'active' : '' }}" href="{{ route('admin.lessons.index') }}">
                <i class="bi bi-file-text"></i> <span>Dersler</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people"></i> <span>Kullanıcılar</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.sources') }}">
                <i class="bi bi-bar-chart"></i> <span>Kaynak Raporları</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.ads.*') ? 'active' : '' }}" href="{{ route('admin.ads.index') }}">
                <i class="bi bi-megaphone"></i> <span>Reklamlar</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                <i class="bi bi-credit-card"></i> <span>Ödemeler</span>
            </a>
            <hr class="border-secondary">
            <a class="nav-link" href="{{ url('/') }}">
                <i class="bi bi-arrow-left"></i> <span>Sitene Dön</span>
            </a>
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-admin').submit();">
                <i class="bi bi-box-arrow-right"></i> <span>Çıkış</span>
            </a>
            <form id="logout-admin" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </nav>
    </div>

    <div class="content">
        <div class="navbar-top d-flex justify-content-between align-items-center">
            <div>
                @yield('breadcrumb')
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}</span>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
