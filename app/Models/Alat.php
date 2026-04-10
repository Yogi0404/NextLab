<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'kategori',
        'total_stok',
        'stok_tersedia',
        'kondisi',
        'deskripsi',
        'foto'
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
