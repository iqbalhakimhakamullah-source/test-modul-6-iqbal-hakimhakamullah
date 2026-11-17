@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    @if ($buku)
        <h2>Detail Buku</h2>
        <div class="detail-buku" style="background:#fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8;">
            <p style="margin-bottom: 10px;"><strong>ID Buku:</strong> {{ $buku->id }}</p>
            <p style="margin-bottom: 10px;"><strong>Judul:</strong> {{ $buku->judul }}</p>
            <p style="margin-bottom: 10px;"><strong>Penulis:</strong> {{ $buku->penulis }}</p>
            <p style="margin-bottom: 10px;"><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
            <p style="margin-bottom: 10px;"><strong>Kategori:</strong> {{ $buku->kategori ? $buku->kategori->nama : '-' }}</p>
        </div>
        <a href="{{ route('buku.index') }}" class="btn" style="margin-top: 15px; display: inline-block;">Kembali ke Daftar Buku</a>
    @else
        <h2>Data Tidak Ditemukan</h2>
        <p>Buku dengan ID tersebut tidak ditemukan.</p>
        <a href="{{ route('buku.index') }}" class="btn">Kembali ke Daftar Buku</a>
    @endif
@endsection