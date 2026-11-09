<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Hafta 7: Model ile Veritabanı işlemleri
 * php artisan make:model Kitap
 */
class Kitap extends Model
{
    use HasFactory;

    // Hafta 7: Hangi tabloya bağlı olduğunu belirtiyoruz
    protected $table = 'kitaplar';

    // Hafta 7: Toplu atama (mass assignment) için izin verilen alanlar
    protected $fillable = [
        'baslik',
        'yazar',
        'isbn',
        'kategori',
        'yayin_yili',
        'stok',
        'aciklama',
        'kapak_resmi',
    ];

    // Hafta 7: İlişki - Bir kitabın birden fazla ödünç kaydı olabilir
    public function oduncKayitlari()
    {
        return $this->hasMany(OduncKaydi::class, 'kitap_id');
    }

    // Yardımcı metot: Kitap müsait mi?
    public function musaitMi()
    {
        return $this->stok > 0;
    }
}
