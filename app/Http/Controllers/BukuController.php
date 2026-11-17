<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('buku.index', compact('kategoris'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);
        return view('buku.show', compact('buku'));
    }

    // ==========================================
    // PERBAIKAN A2: SQL Injection menjadi Eloquent (Binding)
    // ==========================================
    public function cari(Request $request)
    {
        $judul = $request->query('judul');
        // Menggunakan Eloquent agar otomatis terhindar dari SQLi
        $buku = Buku::where('judul', $judul)->get(); 
        return response()->json($buku);
    }

    // ==========================================
    // PERBAIKAN A3: Mengganti method hapus menjadi destroy
    // ==========================================
    public function destroy($id)
    {
        $buku = Buku::find($id);
        
        if ($buku) {
            $buku->delete();
            return response()->json(['message' => 'Buku berhasil dihapus'], 200);
        }
        
        return response()->json(['message' => 'Buku tidak ditemukan'], 404);
    }
}