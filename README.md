# KütüphaneApp — Laravel Final Projesi

**Ders:** İleri Web Teknolojileri  
**Hoca:** Doç. Dr. Şaban GÜLCÜ  
**Sunum Tarihi:** 03.06.2026 09:30

---

## Proje Açıklaması

MySQL veritabanı kullanan bir **Kütüphane Yönetim Sistemi**. Kitap ve ödünç işlemlerini yönetmeyi sağlar.

## Kullanılan Laravel Özellikleri (Ders Notlarına Göre)

| Hafta | Konu | Projede Kullanım Yeri |
|-------|------|-----------------------|
| Hafta 1 | MVC, Laravel kurulumu | Tüm proje yapısı |
| Hafta 2 | Routing, Controller | `routes/web.php`, tüm controller'lar |
| Hafta 3 | Middleware, @csrf, POST | `GirisKontrol.php`, form'lar |
| Hafta 4 | Blade, @extends, @section | Tüm view dosyaları |
| Hafta 5 | Migration, Veritabanı | `database/migrations/` |
| Hafta 6 | CRUD (DB Facade) | Controller'lardaki DB işlemleri |
| Hafta 7 | Model ile CRUD | `Kitap.php`, `OduncKaydi.php` |
| Hafta 8 | Validation, Resim yükleme | `store()`, `update()` metodları |
| **Hafta 9** | **Resource Controller** | **`KitapController`, `OduncController`** |
| **Hafta 10** | **Session (oturum)** | **`AuthController`, flash mesajlar** |

---

## Kurulum Adımları

### 1. Laravel Projesi Oluştur
```bash
laravel new kutuphane --database=mysql
```

### 2. Bu Projedeki Dosyaları Kopyala
Tüm dosyaları yeni oluşturulan proje klasörüne kopyala.

### 3. Veritabanı Oluştur (PHPMyAdmin)
```sql
CREATE DATABASE kutuphane_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. .env Dosyasını Ayarla
```
DB_DATABASE=kutuphane_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Komutları Çalıştır
```bash
php artisan key:generate
php artisan migrate
php artisan serve
```

### 6. Upload Klasörü Oluştur
```bash
mkdir -p public/uploads/kapaklar
```

### 7. Tarayıcıda Aç
```
http://localhost:8000
```

---

## Giriş Bilgileri

| Kullanıcı | Şifre | Rol |
|-----------|-------|-----|
| admin | admin123 | Kütüphaneci |
| user | 1234 | Misafir |

---

## Özellikler

### Kitap Yönetimi
- Kitap listeleme, arama, filtreleme
- Yeni kitap ekleme (kapak resmi yükleme dahil)
- Kitap düzenleme ve silme
- Stok takibi

### Ödünç İşlemleri
- Kitap ödünç verme
- İade alma (stok otomatik güncellenir)
- Ödünç geçmişi

### Güvenlik
- Session tabanlı giriş/çıkış
- Middleware ile sayfa koruması
- CSRF koruması (@csrf)
- Form Validation (Türkçe hata mesajları)

---

## Dosya Yapısı

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php      # Giriş/Çıkış (Session)
│   │   ├── KitapController.php     # Resource Controller
│   │   └── OduncController.php     # Resource Controller
│   └── Middleware/
│       └── GirisKontrol.php        # Middleware
├── Models/
│   ├── Kitap.php                   # Model
│   └── OduncKaydi.php              # Model
database/
└── migrations/
    ├── ..._create_kitaplar_table.php
    └── ..._create_odunc_kayitlari_table.php
resources/views/
├── layouts/
│   ├── app.blade.php               # Ana layout
│   └── navbar.blade.php            # @include parçası
├── auth/
│   └── login.blade.php
├── kitaplar/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── odunc/
    ├── index.blade.php
    ├── create.blade.php
    ├── edit.blade.php
    └── show.blade.php
routes/
└── web.php                         # Route::resource(...)
bootstrap/
└── app.php                         # Middleware kaydı
```

---

## Rapor İçin Önemli Kod Parçacıkları

### Resource Controller Oluşturma
```bash
php artisan make:controller KitapController --resource
```

### Resource Route (7 route tek satırda)
```php
Route::resource('kitaplar', KitapController::class);
```

### Validation Örneği
```php
$request->validate([
    'baslik' => 'required|string|min:2|max:255',
    'isbn'   => 'required|string|unique:kitaplar,isbn',
    'stok'   => 'required|integer|min:0',
]);
```

### Session Kullanımı
```php
session()->put('kullanici', ['adi' => 'Admin', 'rol' => 'admin']);
session('kullanici.adi');        // okuma
session()->flash('basari', 'Kaydedildi!');  // flash mesaj
session()->flush();              // tümünü sil (çıkış)
```

### Middleware Kaydı (bootstrap/app.php)
```php
$middleware->alias([
    'giris.kontrol' => \App\Http\Middleware\GirisKontrol::class,
]);
```

### Migration Örneği
```bash
php artisan make:migration create_kitaplar_table
php artisan migrate
```
