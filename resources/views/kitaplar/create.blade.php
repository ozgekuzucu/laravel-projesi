@extends('layouts.app')

@section('baslik', 'Yeni Kitap Ekle')

@section('icerik')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Yeni Kitap Ekle</h2>
    <a href="{{ route('kitaplar.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Geri Dön
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-book me-2"></i>Kitap Bilgileri
            </div>
            <div class="card-body p-4">

                {{--
                    Hafta 3: Form POST, @csrf token
                    Hafta 8: Validation, @error direktifi, old() fonksiyonu
                    Hafta 8: enctype="multipart/form-data" resim yükleme için
                --}}
                <form action="{{ route('kitaplar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Tüm validation hataları --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong><i class="bi bi-exclamation-triangle me-2"></i>Lütfen aşağıdaki hataları düzeltin:</strong>
                            <ul class="mb-0 mt-2">
                                {{-- Hafta 4: Blade @foreach --}}
                                @foreach($errors->all() as $hata)
                                    <li>{{ $hata }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3">

                        <div class="col-md-8">
                            <label for="baslik" class="form-label fw-semibold">
                                Kitap Başlığı <span class="text-danger">*</span>
                            </label>
                            {{-- Hafta 8: @error sınıf ekle, old() ile değeri koru --}}
                            <input type="text"
                                   class="form-control @error('baslik') is-invalid @enderror"
                                   id="baslik" name="baslik"
                                   value="{{ old('baslik') }}"
                                   placeholder="Kitap adını giriniz">
                            @error('baslik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="yayin_yili" class="form-label fw-semibold">
                                Yayın Yılı <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('yayin_yili') is-invalid @enderror"
                                   id="yayin_yili" name="yayin_yili"
                                   value="{{ old('yayin_yili') }}"
                                   min="1000" max="{{ date('Y') }}"
                                   placeholder="{{ date('Y') }}">
                            @error('yayin_yili')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="yazar" class="form-label fw-semibold">
                                Yazar <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('yazar') is-invalid @enderror"
                                   id="yazar" name="yazar"
                                   value="{{ old('yazar') }}"
                                   placeholder="Yazar adını giriniz">
                            @error('yazar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="isbn" class="form-label fw-semibold">
                                ISBN <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('isbn') is-invalid @enderror"
                                   id="isbn" name="isbn"
                                   value="{{ old('isbn') }}"
                                   placeholder="978-x-xxx-xxxxx-x">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="kategori" class="form-label fw-semibold">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('kategori') is-invalid @enderror"
                                    id="kategori" name="kategori">
                                <option value="">-- Kategori Seçin --</option>
                                {{-- Hafta 4: Blade @foreach + @selected direktifi --}}
                                @foreach($kategoriler as $kat)
                                    <option value="{{ $kat }}" @selected(old('kategori') == $kat)>
                                        {{ $kat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="stok" class="form-label fw-semibold">
                                Stok Adedi <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   id="stok" name="stok"
                                   value="{{ old('stok', 1) }}"
                                   min="0">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="aciklama" class="form-label fw-semibold">Açıklama</label>
                            <textarea class="form-control @error('aciklama') is-invalid @enderror"
                                      id="aciklama" name="aciklama" rows="3"
                                      placeholder="Kitap hakkında kısa açıklama...">{{ old('aciklama') }}</textarea>
                            @error('aciklama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Hafta 8: Resim dosyası yükleme --}}
                        <div class="col-12">
                            <label for="kapak_resmi" class="form-label fw-semibold">
                                Kapak Resmi <small class="text-muted">(jpg, png, max 2MB)</small>
                            </label>
                            <input type="file"
                                   class="form-control @error('kapak_resmi') is-invalid @enderror"
                                   id="kapak_resmi" name="kapak_resmi"
                                   accept="image/jpeg,image/png,image/jpg">
                            @error('kapak_resmi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="onizleme" class="mt-2"></div>
                        </div>

                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Kaydet
                        </button>
                        <a href="{{ route('kitaplar.index') }}" class="btn btn-outline-secondary">İptal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Yardım Kartı --}}
    <div class="col-md-4">
        <div class="card border-info">
            <div class="card-header bg-info text-white"><i class="bi bi-info-circle me-2"></i>Bilgi</div>
            <div class="card-body">
                <p class="small"><span class="text-danger">*</span> ile işaretli alanlar zorunludur.</p>
                <p class="small mb-0"><strong>ISBN Formatı:</strong> 978-x-xxx-xxxxx-x şeklinde giriniz. Her kitabın ISBN numarası benzersiz olmalıdır.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Kapak resmi önizleme
document.getElementById('kapak_resmi').addEventListener('change', function(e) {
    const div = document.getElementById('onizleme');
    if (e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = (ev) => {
            div.innerHTML = `<img src="${ev.target.result}" style="max-height:120px;border-radius:8px;">`;
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endpush
