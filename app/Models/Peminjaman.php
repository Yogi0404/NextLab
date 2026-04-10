<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'alat_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'jumlah',
    ];

    // 🔗 relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 relasi ke alat
    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
}