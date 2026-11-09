<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Hafta 7: Model - Ödünç Kaydı
 */
class OduncKaydi extends Model
{
    use HasFactory;

    protected $table = 'odunc_kayitlari';

    protected $fillable = [
        'kitap_id',
        'uye_adi',
        'uye_email',
        'odunc_tarihi',
        'iade_tarihi',
        'durum',
    ];

    protected $casts = [
        'odunc_tarihi' => 'date',
        'iade_tarihi'  => 'date',
    ];

    // Hafta 7: İlişki - Ödünç kaydı bir kitaba aittir
    public function kitap()
    {
        return $this->belongsTo(Kitap::class, 'kitap_id');
    }
}
