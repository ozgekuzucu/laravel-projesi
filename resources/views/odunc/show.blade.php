@extends('layouts.app')
@section('baslik', 'Ödünç Kaydı Detayı')
@section('icerik')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Ödünç Kaydı #{{ $kayit->id }}</h2>
    <a href="{{ route('odunc.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Liste
    </a>
</div>

<div class="card" style="max-width:600px;">
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th>Kitap</th><td>{{ $kayit->kitap->baslik }}</td></tr>
            <tr><th>Yazar</th><td>{{ $kayit->kitap->yazar }}</td></tr>
            <tr><th>Üye</th><td>{{ $kayit->uye_adi }}</td></tr>
            <tr><th>E-posta</th><td>{{ $kayit->uye_email }}</td></tr>
            <tr><th>Ödünç Tarihi</th><td>{{ $kayit->odunc_tarihi->format('d.m.Y') }}</td></tr>
            <tr>
                <th>İade Tarihi</th>
                <td>{{ $kayit->iade_tarihi ? $kayit->iade_tarihi->format('d.m.Y') : '—' }}</td>
            </tr>
            <tr>
                <th>Durum</th>
                <td>
                    @if($kayit->durum === 'oduncte')
                        <span class="badge bg-warning text-dark">Ödünçte</span>
                    @else
                        <span class="badge bg-success">İade Edildi</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

@endsection
