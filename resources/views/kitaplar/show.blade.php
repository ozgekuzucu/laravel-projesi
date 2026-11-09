@extends('layouts.app')

@section('baslik', $kitap->baslik)

@section('icerik')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="bi bi-book-open me-2 text-primary"></i>Kitap Detayı</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('kitaplar.edit', $kitap->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i>Düzenle
        </a>
        <a href="{{ route('kitaplar.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Liste
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-3 text-center mb-4">
        {{-- Hafta 4: Blade @isset --}}
        @isset($kitap->kapak_resmi)
            <img src="{{ asset('uploads/kapaklar/' . $kitap->kapak_resmi) }}"
                 class="img-fluid rounded shadow" style="max-height:280px;">
        @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:280px;">
                <i class="bi bi-book display-1 text-muted"></i>
            </div>
        @endisset

        <div class="mt-3">
            {{-- Hafta 4: Blade @if koşullu gösterim --}}
            @if($kitap->stok > 0)
                <span class="badge bg-success fs-6">
                    <i class="bi bi-check-circle me-1"></i>Müsait ({{ $kitap->stok }} adet)
                </span>
            @else
                <span class="badge bg-danger fs-6">
                    <i class="bi bi-x-circle me-1"></i>Tükendi
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold">{{ $kitap->baslik }}</h3>
                <p class="text-muted fs-5">{{ $kitap->yazar }}</p>

                <hr>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <small class="text-muted d-block">ISBN</small>
                        <code>{{ $kitap->isbn }}</code>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Kategori</small>
                        <span class="badge bg-secondary fs-6">{{ $kitap->kategori }}</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Yayın Yılı</small>
                        <strong>{{ $kitap->yayin_yili }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Stok</small>
                        <strong>{{ $kitap->stok }} adet</strong>
                    </div>

                    {{-- Hafta 4: Blade @isset ve @empty --}}
                    @isset($kitap->aciklama)
                        @unless(empty($kitap->aciklama))
                            <div class="col-12">
                                <small class="text-muted d-block">Açıklama</small>
                                <p class="mb-0">{{ $kitap->aciklama }}</p>
                            </div>
                        @endunless
                    @endisset
                </div>
            </div>
        </div>

        {{-- Ödünç Kayıtları --}}
        <div class="card mt-3">
            <div class="card-header">
                <i class="bi bi-arrow-left-right me-2"></i>Ödünç Geçmişi
                ({{ $kitap->oduncKayitlari->count() }} kayıt)
            </div>
            <div class="card-body p-0">
                @forelse($kitap->oduncKayitlari->take(5) as $kayit)
                    <div class="d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
                        <div>
                            <strong>{{ $kayit->uye_adi }}</strong>
                            <small class="text-muted ms-2">{{ $kayit->uye_email }}</small>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">{{ $kayit->odunc_tarihi->format('d.m.Y') }}</small>
                            @if($kayit->durum === 'iade_edildi')
                                <span class="badge bg-success ms-2">İade edildi</span>
                            @else
                                <span class="badge bg-warning text-dark ms-2">Ödünçte</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-3 mb-0">Bu kitap henüz ödünç verilmemiş.</p>
                @endforelse
            </div>
            @if($kitap->stok > 0)
                <div class="card-footer">
                    <a href="{{ route('odunc.create') }}?kitap_id={{ $kitap->id }}"
                       class="btn btn-sm btn-primary">
                        <i class="bi bi-person-plus me-1"></i>Ödünç Ver
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
