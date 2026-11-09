{{-- Hafta 4: Blade - @include ile dahil edilen navbar parçası --}}
<nav class="navbar navbar-dark navbar-expand-md">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('kitaplar.index') }}">
            <i class="bi bi-book-half me-2"></i>KütüphaneApp
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center">

                {{-- Hafta 4: Blade @auth / @guest direktifleri --}}
                {{-- Hafta 10: Session'dan kullanıcı bilgisi okuma --}}
                @if(session()->has('kullanici'))
                    <li class="nav-item">
                        <span class="navbar-text me-3">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ session('kullanici.adi') }}
                            {{-- Hafta 4: Blade - koşullu badge --}}
                            @if(session('kullanici.rol') === 'admin')
                                <span class="badge bg-warning text-dark ms-1">Admin</span>
                            @endif
                        </span>
                    </li>
                    <li class="nav-item">
                        {{-- Hafta 3: POST route + CSRF --}}
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-box-arrow-right me-1"></i>Çıkış
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Giriş Yap
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
