<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';
    
    // Pastikan user_id dan anggota_id masuk fillable
    protected $fillable = [
        'user_id', 
        'anggota_id', 
        'buku_id', 
        'tanggal_pinjam', 
        'tanggal_kembali'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}