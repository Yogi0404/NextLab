<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('alat_id')->constrained()->cascadeOnDelete();

            $table->integer('jumlah')->default(1);

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');

            $table->enum('status', [
                'pending',
                'dipinjam',
                'request_kembali',
                'dikembalikan',
                'terlambat',
                'ditolak'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
