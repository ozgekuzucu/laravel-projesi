@extends('layouts.app')

@section('baslik', 'Kitap Düzenle: ' . $kitap->baslik)

@section('icerik')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2 text-warning"></i>Kitap Düzenle</h2>
    <a href="{{ route('kitaplar.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Geri Dön
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <i class="bi bi-book me-2"></i>{{ $kitap->baslik }}
            </div>
            <div class="card-body p-4">

                {{--
                    Hafta 9: Resource Controller update - PUT metodu
                    Hafta 3: @method('PUT') sahte HTTP metodu
                    Hafta 8: Validation + old() + @error
                --}}
                <form action="{{ route('kitaplar.update', $kitap->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>Hataları düzeltin:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach($errors->all() as $hata)
                                    <li>{{ $hata }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Başlık <span class="text-danger">*</span></label>
                            <input type="text" name="baslik"
                                   class="form-control @error('baslik') is-invalid @enderror"
                                   {{-- Hafta 8: old() - validation hatası sonrası değeri koru, yoksa mevcut değeri kullan --}}
                                   value="{{ old('baslik', $kitap->baslik) }}">
                            @error('baslik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Yayın Yılı <span class="text-danger">*</span></label>
                            <input type="number" name="yayin_yili"
                                   class="form-control @error('yayin_yili') is-invalid @enderror"
                                   value="{{ old('yayin_yili', $kitap->yayin_yili) }}"
                                   min="1000" max="{{ date('Y') }}">
                            @error('yayin_yili')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Yazar <span class="text-danger">*</span></label>
                            <input type="text" name="yazar"
                                   class="form-control @error('yazar') is-invalid @enderror"
                                   value="{{ old('yazar', $kitap->yazar) }}">
                            @error('yazar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">ISBN <span class="text-danger">*</span></label>
                            <input type="text" name="isbn"
                                   class="form-control @error('isbn') is-invalid @enderror"
                                   value="{{ old('isbn', $kitap->isbn) }}">
                            @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                                @foreach($kategoriler as $kat)
                                    <option value="{{ $kat }}"
                                        @selected(old('kategori', $kitap->kategori) == $kat)>
                                        {{ $kat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" min="0"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', $kitap->stok) }}">
                            @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Açıklama</label>
                            <textarea name="aciklama" rows="3"
                                      class="form-control @error('aciklama') is-invalid @enderror">{{ old('aciklama', $kitap->aciklama) }}</textarea>
                            @error('aciklama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Kapak Resmi</label>
                            @isset($kitap->kapak_resmi)
                                <div class="mb-2">
                                    <img src="{{ asset('uploads/kapaklar/' . $kitap->kapak_resmi) }}"
                                         style="height:80px;border-radius:6px;" alt="Mevcut kapak">
                                    <small class="text-muted ms-2">Mevcut kapak resmi</small>
                                </div>
                            @endisset
                            <input type="file" name="kapak_resmi"
                                   class="form-control @error('kapak_resmi') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg">
                            <div class="form-text">Yeni dosya seçmezseniz mevcut resim korunur.</div>
                            @error('kapak_resmi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-save me-2"></i>Güncelle
                        </button>
                        <a href="{{ route('kitaplar.show', $kitap->id) }}" class="btn btn-outline-secondary">İptal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
