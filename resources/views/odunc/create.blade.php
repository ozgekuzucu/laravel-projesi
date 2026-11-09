@extends('layouts.app')

@section('baslik', 'Ödünç Ver')

@section('icerik')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="bi bi-person-plus me-2 text-primary"></i>Ödünç Ver</h2>
    <a href="{{ route('odunc.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Geri Dön
    </a>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-arrow-left-right me-2"></i>Ödünç Bilgileri
            </div>
            <div class="card-body p-4">

                {{--
                    Hafta 3: POST form, @csrf
                    Hafta 8: Validation, @error, old()
                --}}
                <form action="{{ route('odunc.store') }}" method="POST">
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $hata)
                                    <li>{{ $hata }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kitap <span class="text-danger">*</span></label>
                        <select name="kitap_id" class="form-select @error('kitap_id') is-invalid @enderror">
                            <option value="">-- Kitap Seçin --</option>
                            @foreach($kitaplar as $kitap)
                                <option value="{{ $kitap->id }}"
                                    @selected(old('kitap_id', request('kitap_id')) == $kitap->id)>
                                    {{ $kitap->baslik }} — {{ $kitap->yazar }}
                                    (Stok: {{ $kitap->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('kitap_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Üye Adı Soyadı <span class="text-danger">*</span></label>
                        <input type="text" name="uye_adi"
                               class="form-control @error('uye_adi') is-invalid @enderror"
                               value="{{ old('uye_adi') }}" placeholder="Ad Soyad">
                        @error('uye_adi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Üye E-postası <span class="text-danger">*</span></label>
                        <input type="email" name="uye_email"
                               class="form-control @error('uye_email') is-invalid @enderror"
                               value="{{ old('uye_email') }}" placeholder="ornek@mail.com">
                        @error('uye_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Ödünç Tarihi <span class="text-danger">*</span></label>
                        <input type="date" name="odunc_tarihi"
                               class="form-control @error('odunc_tarihi') is-invalid @enderror"
                               value="{{ old('odunc_tarihi', date('Y-m-d')) }}">
                        @error('odunc_tarihi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i>Ödünç Ver
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
