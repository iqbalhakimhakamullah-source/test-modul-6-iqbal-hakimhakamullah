@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h2>Dashboard Admin</h2>
    <p style="margin-bottom: 20px;">Selamat datang, <strong>{{ Auth::user()->name }}</strong>. Anda login sebagai Administrator.</p>

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <!-- Card Manajemen User (Khusus Admin) -->
        <div style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8; flex: 1; min-width: 250px;">
            <h3 style="color: #5d4037; margin-bottom: 10px;">Manajemen Pengguna</h3>
            <p style="font-size: 14px; margin-bottom: 15px;">Kelola akun anggota, petugas, dan atur hak akses (role) sistem.</p>
            <a href="{{ route('users.index') }}" class="btn">Kelola Pengguna</a>
        </div>

        <!-- Card Laporan -->
        <div style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8; flex: 1; min-width: 250px;">
            <h3 style="color: #5d4037; margin-bottom: 10px;">Laporan Perpustakaan</h3>
            <p style="font-size: 14px; margin-bottom: 15px;">Lihat rekapitulasi data buku dan total peminjaman secara keseluruhan.</p>
            <a href="{{ route('laporan.index') }}" class="btn">Lihat Laporan</a>
        </div>

    </div>
@endsection