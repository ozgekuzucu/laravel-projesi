<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hafta 5: Migration - Ödünç kayıtları tablosu
     * Foreign key kullanımı da gösterilmiştir
     */
    public function up(): void
    {
        Schema::create('odunc_kayitlari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kitap_id')->constrained('kitaplar')->onDelete('cascade');
            $table->string('uye_adi');
            $table->string('uye_email');
            $table->date('odunc_tarihi');
            $table->date('iade_tarihi')->nullable();
            $table->enum('durum', ['oduncte', 'iade_edildi'])->default('oduncte');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('odunc_kayitlari');
    }
};
