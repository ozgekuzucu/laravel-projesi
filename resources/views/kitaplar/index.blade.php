{{-- Hafta 4: Blade @extends ile layout'u genişlet --}}
@extends('layouts.app')

@section('baslik', 'Kitap Listesi')

@section('icerik')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 fw-bold"><i class="bi bi-book me-2 text-primary"></i>Kitap Listesi</h2>
        <small class="text-muted">Toplam {{ $kitaplar->total() }} kitap</small>
    </div>
    <a href="{{ route('kitaplar.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Yeni Kitap Ekle
    </a>
</div>

{{-- Arama ve Filtreleme Formu --}}
<div class="card mb-4">
    <div class="card-body">
        {{-- Hafta 3: GET form, Route ismi ile action --}}
        <form action="{{ route('kitaplar.index') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" name="ara"
                           value="{{ request('ara') }}" placeholder="Başlık, yazar veya ISBN ara...">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" name="kategori">
                    <option value="">Tüm Kategoriler</option>
                    {{-- Hafta 4: Blade @foreach döngüsü --}}
                    @foreach($kategoriler as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                            {{ $kat }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">Filtrele</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kapak</th>
                        <th>Başlık</th>
                        <th>Yazar</th>
                        <th>ISBN</th>
                        <th>Kategori</th>
                        <th>Yıl</th>
                        <th>Stok</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Hafta 4: Blade @forelse - boş liste için @empty --}}
                    @forelse($kitaplar as $kitap)
                        <tr>
                            <td class="text-muted">{{ $kitap->id }}</td>
                            <td>
                                {{-- Hafta 4: Blade @isset direktifi --}}
                                @isset($kitap->kapak_resmi)
                                    <img src="{{ asset('uploads/kapaklar/' . $kitap->kapak_resmi) }}"
                                         width="40" height="55"
                                         style="object-fit:cover; border-radius:4px;">
                                @else
                                    <div style="width:40px;height:55px;background:#f0f4f8;border-radius:4px;display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-book text-muted"></i>
                                    </div>
                                @endisset
                            </td>
                            <td>
                                <a href="{{ route('kitaplar.show', $kitap->id) }}" class="text-decoration-none fw-semibold">
                                    {{ $kitap->baslik }}
                                </a>
                            </td>
                            <td>{{ $kitap->yazar }}</td>
                            <td><code>{{ $kitap->isbn }}</code></td>
                            <td><span class="badge bg-secondary">{{ $kitap->kategori }}</span></td>
                            <td>{{ $kitap->yayin_yili }}</td>
                            <td>
                                {{-- Hafta 4: Blade @if koşullu sınıf --}}
                                @if($kitap->stok > 0)
                                    <span class="badge badge-musait p-2">
                                        <i class="bi bi-check-circle me-1"></i>{{ $kitap->stok }} adet
                                    </span>
                                @else
                                    <span class="badge badge-tukendi p-2">
                                        <i class="bi bi-x-circle me-1"></i>Tükendi
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('kitaplar.show', $kitap->id) }}"
                                       class="btn btn-outline-info" title="Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('kitaplar.edit', $kitap->id) }}"
                                       class="btn btn-outline-warning" title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    {{-- Hafta 3: DELETE form + @csrf --}}
                                    <form action="{{ route('kitaplar.destroy', $kitap->id) }}" method="POST"
                                          onsubmit="return confirm('\"{{ $kitap->baslik }}\" silinsin mi?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Sil">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                Kayıt bulunamadı.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($kitaplar->hasPages())
        <div class="card-footer">
            {{ $kitaplar->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@endsection
