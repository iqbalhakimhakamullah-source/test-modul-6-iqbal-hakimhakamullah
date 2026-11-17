@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <section class="hero">
        <h2>Selamat Datang di Perpustakaan</h2>
        <p>Aplikasi sederhana untuk melihat daftar buku dan detail buku.</p>
        <a href="{{ route('buku.index') }}" class="btn">Lihat Daftar Buku</a>
    </section>
@endsection