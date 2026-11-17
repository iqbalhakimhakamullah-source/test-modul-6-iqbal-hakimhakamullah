<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index()
    {
        // Ambil data kategori untuk dropdown form
        $kategoris = Kategori::all();
        return view('buku.index', compact('kategoris'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);
        return view('buku.show', compact('buku'));
    }

    public function cari(Request $request)
{
    $judul = $request->query('judul');
    // CELAH A2: Raw Query tanpa binding
    $buku = DB::select("SELECT * FROM bukus WHERE judul = '$judul'");
    return response()->json($buku);
}

    public function hapus($id)
{
    \App\Models\Buku::find($id)->delete();
    return redirect('/buku')->with('success', 'Buku terhapus!');
}
}