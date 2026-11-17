<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // UNTUK ADMIN & PETUGAS: Melihat semua daftar pinjaman
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();
        $total_buku = Buku::count();
        $total_user = User::count();
        $total_pinjam = Peminjaman::whereNull('tanggal_kembali')->count();

        return view('peminjaman.index', compact('peminjamans', 'total_buku', 'total_user', 'total_pinjam'));
    }

    // UNTUK ADMIN & PETUGAS: Memproses pengembalian buku
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['tanggal_kembali' => date('Y-m-d')]);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
    }

    // Soal 4: Untuk melihat detail (dilindungi Policy)
    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        Gate::authorize('view', $peminjaman);
        return response()->json($peminjaman); 
    }

    // FITUR SISWA: Mengajukan pinjam
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id'
        ]);

        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => date('Y-m-d'),
            'tanggal_kembali' => null,
            'anggota_id' => 1,
        ]);

        return response()->json(['message' => 'Buku berhasil dipinjam!'], 201);
    }
}