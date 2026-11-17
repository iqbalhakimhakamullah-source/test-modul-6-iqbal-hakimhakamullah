<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function show($id)
    {
        // CELAH A4: Tidak ada pengecekan pemilik (IDOR)
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Mengembalikan data dalam bentuk JSON agar mudah dibuktikan
        return response()->json($peminjaman); 
    }
}