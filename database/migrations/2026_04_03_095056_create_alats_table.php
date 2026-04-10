<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alats', function (Blueprint $table) {
            $table->id();

            $table->string('kode_alat')->unique();
            $table->string('nama_alat');

            // sementara kategori pakai string dulu (biar simple)
            $table->string('kategori');

            $table->integer('total_stok');
            $table->integer('stok_tersedia');

            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']);

            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};