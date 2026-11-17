@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
    <h2>Dashboard Petugas</h2>
    <p style="margin-bottom: 20px;">Selamat datang, <strong>{{ Auth::user()->name }}</strong>. Anda login sebagai Petugas Perpustakaan.</p>

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <!-- Card Operasional Peminjaman -->
        <div style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8; flex: 1; min-width: 250px;">
            <h3 style="color: #5d4037; margin-bottom: 10px;">Operasional Peminjaman</h3>
            <p style="font-size: 14px; margin-bottom: 15px;">Proses pengajuan peminjaman dan catat pengembalian buku dari anggota.</p>
            <a href="#" class="btn" onclick="alert('Fitur ini akan dibuat pada modul selanjutnya.')">Proses Peminjaman</a>
        </div>

        <!-- Card Kelola Buku -->
        <div style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8; flex: 1; min-width: 250px;">
            <h3 style="color: #5d4037; margin-bottom: 10px;">Data Koleksi Buku</h3>
            <p style="font-size: 14px; margin-bottom: 15px;">Tambah, ubah, atau hapus data buku yang ada di perpustakaan.</p>
            <a href="{{ route('buku.index') }}" class="btn">Kelola Data Buku</a>
        </div>

    </div>
@endsection