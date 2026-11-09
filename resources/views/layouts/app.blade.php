<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Hafta 4: Blade - @yield direktifi ile dinamik başlık --}}
    <title>@yield('baslik', 'Kütüphane Sistemi') - KütüphaneApp</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #2c3e50; --accent: #e74c3c; }
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: var(--primary) !important; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .sidebar { background: #fff; border-right: 1px solid #dee2e6; min-height: calc(100vh - 56px); padding: 1.5rem 0; }
        .sidebar .nav-link { color: #495057; padding: .6rem 1.5rem; border-radius: 0; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #f0f4f8; color: var(--primary); font-weight: 600; border-left: 3px solid var(--primary); }
        .sidebar .nav-link i { width: 20px; }
        .main-content { padding: 2rem; }
        .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,.07); border-radius: 12px; }
        .card-header { border-radius: 12px 12px 0 0 !important; font-weight: 600; }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .table th { background: #f8f9fa; font-weight: 600; font-size: .85rem; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; }
        .badge-musait { background: #d4edda; color: #155724; }
        .badge-tukendi { background: #f8d7da; color: #721c24; }
        footer { background: var(--primary); color: rgba(255,255,255,.7); padding: 1rem; text-align: center; font-size: .85rem; margin-top: auto; }
    </style>
</head>
<body>

{{-- Hafta 4: Blade - @include ile navbar parçasını dahil et --}}
@include('layouts.navbar')

<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        <div class="col-md-2 sidebar d-none d-md-block">
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('kitaplar.*') ? 'active' : '' }}"
                   href="{{ route('kitaplar.index') }}">
                    <i class="bi bi-book"></i> Kitaplar
                </a>
                <a class="nav-link {{ request()->routeIs('odunc.*') ? 'active' : '' }}"
                   href="{{ route('odunc.index') }}">
                    <i class="bi bi-arrow-left-right"></i> Ödünç İşlemleri
                </a>
                <hr class="mx-3">
                <span class="nav-link text-muted" style="font-size:.75rem; text-transform:uppercase; letter-spacing:.5px;">Hızlı İşlem</span>
                <a class="nav-link" href="{{ route('kitaplar.create') }}">
                    <i class="bi bi-plus-circle"></i> Kitap Ekle
                </a>
                <a class="nav-link" href="{{ route('odunc.create') }}">
                    <i class="bi bi-person-plus"></i> Ödünç Ver
                </a>
            </nav>
        </div>

        {{-- Ana İçerik --}}
        <div class="col-md-10 main-content">

            {{-- Hafta 10: Session Flash Mesajları --}}
            @if(session('basari'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('basari') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('uyari'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('uyari') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('bilgi'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>{{ session('bilgi') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Hafta 4: Blade - @yield ile sayfa içeriği buraya gelir --}}
            @yield('icerik')
        </div>
    </div>
</div>

<footer>
    <p class="mb-0">KütüphaneApp &copy; {{ date('Y') }} | İleri Web Teknolojileri Final Projesi</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- Hafta 4: Blade - @stack ile sayfa özel scriptler --}}
@stack('scripts')
</body>
</html>
