@extends('layouts.app')

@section('baslik', 'İade Al')

@section('icerik')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="bi bi-check-circle me-2 text-success"></i>İade Al</h2>
    <a href="{{ route('odunc.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Geri Dön
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="fw-bold">{{ $kayit->kitap->baslik }}</h5>
                <p class="text-muted mb-1">{{ $kayit->kitap->yazar }}</p>
                <p class="mb-0">
                    <strong>Ödünç Alan:</strong> {{ $kayit->uye_adi }}
                    <small class="text-muted">({{ $kayit->uye_email }})</small>
                </p>
                <p class="mb-0">
                    <strong>Ödünç Tarihi:</strong> {{ $kayit->odunc_tarihi->format('d.m.Y') }}
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-success text-white">
                <i class="bi bi-check-circle me-2"></i>İade Bilgileri
            </div>
            <div class="card-body p-4">

                {{-- Hafta 9: PUT metodu, Hafta 8: Validation --}}
                <form action="{{ route('odunc.update', $kayit->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $hata)<li>{{ $hata }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold">İade Tarihi <span class="text-danger">*</span></label>
                        <input type="date" name="iade_tarihi"
                               class="form-control @error('iade_tarihi') is-invalid @enderror"
                               value="{{ old('iade_tarihi', date('Y-m-d')) }}"
                               min="{{ $kayit->odunc_tarihi->format('Y-m-d') }}">
                        @error('iade_tarihi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Durum</label>
                        <select name="durum" class="form-select">
                            <option value="iade_edildi" selected>İade Edildi</option>
                            <option value="oduncte">Hâlâ Ödünçte</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-lg me-2"></i>İade İşlemini Tamamla
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
