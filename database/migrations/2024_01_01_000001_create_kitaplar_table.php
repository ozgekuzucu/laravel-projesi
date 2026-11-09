<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Hafta 5: Migration - Tabloyu oluşturur (up metodu)
     */
    public function up(): void
    {
        Schema::create('kitaplar', function (Blueprint $table) {
            $table->id();
            $table->string('baslik');
            $table->string('yazar');
            $table->string('isbn')->unique();
            $table->string('kategori');
            $table->integer('yayin_yili');
            $table->integer('stok')->default(1);
            $table->text('aciklama')->nullable();
            $table->string('kapak_resmi')->nullable(); // Hafta 8: Resim yükleme
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Hafta 5: Migration - Tabloyu geri alır (down metodu)
     */
    public function down(): void
    {
        Schema::dropIfExists('kitaplar');
    }
};
