@extends('layouts.app')

@section('baslik', 'Ödünç İşlemleri')

@section('icerik')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Ödünç İşlemleri</h2>
        <small class="text-muted">Tüm ödünç kayıtları</small>
    </div>
    <a href="{{ route('odunc.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i>Ödünç Ver
    </a>
</div>

{{-- İstatistik Kartları --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card text-center" style="border-left: 4px solid #ffc107;">
            <div class="card-body">
                <h3 class="fw-bold text-warning mb-0">{{ $oduncSayisi }}</h3>
                <small class="text-muted">Şu an Ödünçte</small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center" style="border-left: 4px solid #28a745;">
            <div class="card-body">
                <h3 class="fw-bold text-success mb-0">{{ $iadeSayisi }}</h3>
                <small class="text-muted">İade Edildi</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kitap</th>
                    <th>Üye</th>
                    <th>E-posta</th>
                    <th>Ödünç Tarihi</th>
                    <th>İade Tarihi</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kayitlar as $kayit)
                    <tr>
                        <td class="text-muted">{{ $kayit->id }}</td>
                        <td>
                            <a href="{{ route('kitaplar.show', $kayit->kitap_id) }}" class="text-decoration-none">
                                {{ $kayit->kitap->baslik ?? '—' }}
                            </a>
                        </td>
                        <td><strong>{{ $kayit->uye_adi }}</strong></td>
                        <td><small>{{ $kayit->uye_email }}</small></td>
                        <td>{{ $kayit->odunc_tarihi->format('d.m.Y') }}</td>
                        <td>
                            {{-- Hafta 4: Blade @isset --}}
                            @isset($kayit->iade_tarihi)
                                {{ $kayit->iade_tarihi->format('d.m.Y') }}
                            @else
                                <span class="text-muted">—</span>
                            @endisset
                        </td>
                        <td>
                            @if($kayit->durum === 'oduncte')
                                <span class="badge bg-warning text-dark">Ödünçte</span>
                            @else
                                <span class="badge bg-success">İade Edildi</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($kayit->durum === 'oduncte')
                                    <a href="{{ route('odunc.edit', $kayit->id) }}"
                                       class="btn btn-outline-success" title="İade Al">
                                        <i class="bi bi-check-lg"></i>
                                    </a>
                                @endif
                                <form action="{{ route('odunc.destroy', $kayit->id) }}" method="POST"
                                      onsubmit="return confirm('Kayıt silinsin mi?')">
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
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox display-4 d-block mb-2"></i>
                            Henüz ödünç kaydı bulunmamaktadır.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kayitlar->hasPages())
        <div class="card-footer">{{ $kayitlar->links() }}</div>
    @endif
</div>

@endsection
