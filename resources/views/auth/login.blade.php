<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - KütüphaneApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,.3); }
        .login-logo { background: #2c3e50; color: white; border-radius: 16px 16px 0 0; padding: 2rem; text-align: center; }
        .login-logo i { font-size: 3rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="login-logo">
                <i class="bi bi-book-half d-block mb-2"></i>
                <h4 class="mb-0 fw-bold">KütüphaneApp</h4>
                <small class="opacity-75">Kütüphane Yönetim Sistemi</small>
            </div>

            <div class="card login-card" style="border-radius: 0 0 16px 16px;">
                <div class="card-body p-4">

                    {{-- Hafta 10: Session flash mesajları --}}
                    @if(session('uyari'))
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('uyari') }}
                        </div>
                    @endif
                    @if(session('bilgi'))
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>{{ session('bilgi') }}
                        </div>
                    @endif

                    <h5 class="card-title mb-4">Sisteme Giriş</h5>

                    {{-- Hafta 3: Form + @csrf + POST metodu --}}
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        {{-- Hafta 8: Validation hata gösterimi --}}
                        <div class="mb-3">
                            <label for="kullanici_adi" class="form-label">Kullanıcı Adı</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text"
                                       class="form-control @error('kullanici_adi') is-invalid @enderror"
                                       id="kullanici_adi"
                                       name="kullanici_adi"
                                       {{-- Hafta 8: old() - hata sonrası değeri koru --}}
                                       value="{{ old('kullanici_adi') }}"
                                       placeholder="admin veya user">
                                @error('kullanici_adi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="sifre" class="form-label">Şifre</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password"
                                       class="form-control @error('sifre') is-invalid @enderror"
                                       id="sifre"
                                       name="sifre"
                                       placeholder="••••••••">
                                @error('sifre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Giriş Yap
                        </button>
                    </form>

                    <hr>
                    <small class="text-muted">
                        <strong>Test Hesapları:</strong><br>
                        Admin: <code>admin</code> / <code>admin123</code><br>
                        Üye: <code>user</code> / <code>1234</code>
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
