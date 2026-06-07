<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ auth()->check() ? auth()->user()->theme : 'light' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KodLab') - KodLab</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --kodlab-primary: #6C5CE7;
            --kodlab-secondary: #4A00E0;
            --kodlab-accent: #00CEC9;
            --kodlab-gradient: linear-gradient(135deg, #6C5CE7, #4A00E0, #0984E3);
            --bg-body: #ffffff;
            --bg-card: #ffffff;
            --bg-card-hover: rgba(108,92,231,0.15);
            --text-body: #212529;
            --text-muted: #6c757d;
            --border-color: #e9ecef;
            --pre-bg: #1e1e2e;
            --pre-color: #cdd6f4;
            --sidebar-hover: #f0edff;
        }
        [data-theme="dark"] {
            --bg-body: #0f0f1a;
            --bg-card: #1a1a2e;
            --bg-card-hover: rgba(108,92,231,0.2);
            --text-body: #e0e0e0;
            --text-muted: #9090a0;
            --border-color: #2a2a3e;
            --pre-bg: #0a0a14;
            --pre-color: #cdd6f4;
            --sidebar-hover: #2a1a3e;
        }
        body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; min-height: 100vh; display: flex; flex-direction: column; background: var(--bg-body); color: var(--text-body); transition: background 0.3s, color 0.3s; }
        .bg-kodlab { background: var(--kodlab-gradient); }
        .btn-kodlab { background: var(--kodlab-gradient); color: white; border: none; }
        .btn-kodlab:hover { opacity: 0.9; color: white; }
        .text-kodlab { color: var(--kodlab-primary); }
        .border-kodlab { border-color: var(--kodlab-primary) !important; }
        .kodlab-card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.2s, background 0.3s; background: var(--bg-card); }
        .kodlab-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(108,92,231,0.15); }
        .sidebar-link { color: var(--text-body); text-decoration: none; padding: 8px 16px; border-radius: 8px; display: block; font-size: 14px; transition: all 0.2s; border-left: 3px solid transparent; }
        .sidebar-link:hover { background: var(--sidebar-hover); color: var(--kodlab-primary); }
        .sidebar-link.active { background: var(--sidebar-hover); color: var(--kodlab-primary); border-left-color: var(--kodlab-primary); font-weight: 600; }
        .hero-section { background: var(--kodlab-gradient); color: white; padding: 60px 0; }
        .category-badge { font-size: 14px; padding: 6px 14px; border-radius: 20px; }
        footer { background: #1a1a2e; color: #a0a0b0; margin-top: auto; }
        .quiz-option { cursor: pointer; border: 2px solid var(--border-color); border-radius: 12px; padding: 12px 16px; margin-bottom: 10px; transition: all 0.2s; background: var(--bg-card); }
        .quiz-option:hover { border-color: var(--kodlab-primary); background: var(--sidebar-hover); }
        .quiz-option.selected { border-color: var(--kodlab-primary); background: var(--sidebar-hover); }
        .quiz-option.correct { border-color: #00b894; background: rgba(0,184,148,0.1); }
        .quiz-option.wrong { border-color: #e17055; background: rgba(225,112,85,0.1); }
        .progress-bar-kodlab { background: var(--kodlab-gradient); }
        pre { background: var(--pre-bg); color: var(--pre-color); padding: 16px; border-radius: 10px; overflow-x: auto; }
        code { font-family: 'Cascadia Code', 'Fira Code', monospace; }
        .list-group-item { background: var(--bg-card); color: var(--text-body); border-color: var(--border-color); }
        .accordion-button { background: var(--bg-card); color: var(--text-body); }
        .accordion-button:not(.collapsed) { background: var(--sidebar-hover); color: var(--kodlab-primary); }
        .accordion-item { background: var(--bg-card); border-color: var(--border-color); }
        .table { color: var(--text-body); }
        .table-light { --bs-table-bg: var(--sidebar-hover); --bs-table-color: var(--text-body); }
        .modal-content { background: var(--bg-card); color: var(--text-body); }
        .dropdown-menu { background: var(--bg-card); }
        .dropdown-item { color: var(--text-body); }
        .dropdown-item:hover { background: var(--sidebar-hover); color: var(--kodlab-primary); }
        .alert { border-radius: 12px; }
        .form-control, .form-select { background: var(--bg-card); color: var(--text-body); border-color: var(--border-color); }
        .form-control:focus, .form-select:focus { background: var(--bg-card); color: var(--text-body); }
        .card { background: var(--bg-card); color: var(--text-body); }
        .bg-light { background: var(--sidebar-hover) !important; }
        .text-muted { color: var(--text-muted) !important; }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-kodlab shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ url('/') }}">
                <i class="bi bi-code-slash me-2"></i>KodLab
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('courses.index') }}"><i class="bi bi-book me-1"></i>Kurslar</a></li>
                </ul>
                <form class="d-flex me-2" action="{{ route('search') }}" method="GET">
                    <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="Ders ara...">
                </form>
                <button id="themeToggle" class="btn btn-sm btn-outline-light me-2" onclick="toggleTheme()" title="Tema Değiştir">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Panel</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-gear me-2"></i>Ayarlar</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.bookmarks') }}"><i class="bi bi-bookmark me-2"></i>Yer İmleri</a></li>
                                <li><a class="dropdown-item" href="{{ route('payment.my-subscriptions') }}"><i class="bi bi-star me-2"></i>Aboneliklerim</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right me-2"></i>Çıkış</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Giriş</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-light text-kodlab fw-semibold ms-2 px-3" href="{{ route('register') }}">Kayıt Ol</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @include('components.ads', ['position' => 'header'])
        @yield('content')
    </main>

    <footer class="py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-white fw-bold"><i class="bi bi-code-slash me-2"></i>KodLab</h5>
                    <p class="small">Sıfırdan uzmanlığa ücretsiz yazılım eğitim platformu. HTML, CSS, JavaScript, PHP, Laravel ve daha fazlası.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="text-white">Eğitimler</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1"><a href="#" class="text-decoration-none text-secondary">HTML</a></li>
                        <li class="mb-1"><a href="#" class="text-decoration-none text-secondary">CSS</a></li>
                        <li class="mb-1"><a href="#" class="text-decoration-none text-secondary">JavaScript</a></li>
                        <li class="mb-1"><a href="#" class="text-decoration-none text-secondary">PHP</a></li>
                        <li class="mb-1"><a href="#" class="text-decoration-none text-secondary">MySQL</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="text-white">Kurumsal</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1"><a href="#" class="text-decoration-none text-secondary">Hakkımızda</a></li>
                        <li class="mb-1"><a href="#" class="text-decoration-none text-secondary">İletişim</a></li>
                        <li class="mb-1"><a href="#" class="text-decoration-none text-secondary">Gizlilik</a></li>
                        <li class="mb-1"><a href="#" class="text-decoration-none text-secondary">Kullanım Şartları</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="text-white">Bülten</h6>
                    <p class="small">Yeni derslerden haberdar olun.</p>
                    <div class="input-group">
                        <input type="email" class="form-control form-control-sm" placeholder="E-posta adresiniz">
                        <button class="btn btn-sm btn-kodlab" type="button">Abone Ol</button>
                    </div>
                </div>
            </div>
            <hr class="border-secondary my-3">
            <div class="text-center small">
                &copy; {{ date('Y') }} KodLab. Tüm hakları saklıdır.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function getTheme() {
        return document.documentElement.getAttribute('data-theme');
    }
    function setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        var icon = document.getElementById('themeIcon');
        if (icon) {
            icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        }
        localStorage.setItem('kodlab-theme', theme);
        @auth
            fetch('/tema', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ theme: theme })
            });
        @endauth
    }
    function toggleTheme() {
        setTheme(getTheme() === 'dark' ? 'light' : 'dark');
    }
    (function() {
        var saved = localStorage.getItem('kodlab-theme');
        var current = getTheme();
        if (saved && saved !== current) {
            setTheme(saved);
        } else {
            setTheme(current);
        }
    })();
    </script>
    @stack('scripts')
</body>
</html>
