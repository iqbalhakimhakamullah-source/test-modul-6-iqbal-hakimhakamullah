@extends('layouts.app')

@section('title', 'Laporan Perpustakaan')

@section('content')
    <h2>Laporan Perpustakaan</h2>

    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px;">
        
        <!-- Laporan Buku per Kategori -->
        <div style="flex: 1; min-width: 300px; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8;">
            <h3 style="color: #5d4037; border-bottom: 2px solid #d7ccc8; padding-bottom: 10px;">Jumlah Buku per Kategori</h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background: #f3f4f6;">
                        <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Kategori</th>
                        <th style="padding: 8px; border: 1px solid #ddd; text-align: center;">Jumlah Buku</th>
                    </tr>
                </thead>
                <tbody id="tabel-kategori">
                    <!-- Diisi JS -->
                </tbody>
            </table>
        </div>

        <!-- Laporan Peminjaman per Buku -->
        <div style="flex: 1; min-width: 300px; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8;">
            <h3 style="color: #5d4037; border-bottom: 2px solid #d7ccc8; padding-bottom: 10px;">Total Peminjaman per Buku</h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background: #f3f4f6;">
                        <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Judul Buku</th>
                        <th style="padding: 8px; border: 1px solid #ddd; text-align: center;">Total Dipinjam</th>
                    </tr>
                </thead>
                <tbody id="tabel-peminjaman">
                    <!-- Diisi JS -->
                </tbody>
            </table>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                // 1. Fetch Laporan Kategori
                const resKategori = await fetch('/api/rekap/buku-per-kategori', { headers: { 'Accept': 'application/json' } });
                const dataKategori = await resKategori.json();
                
                const tbodyKategori = document.getElementById('tabel-kategori');
                dataKategori.forEach(item => {
                    tbodyKategori.innerHTML += `
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;">${item.nama}</td>
                            <td style="padding: 8px; border: 1px solid #ddd; text-align: center; font-weight: bold;">${item.buku_count}</td>
                        </tr>
                    `;
                });

                // 2. Fetch Laporan Peminjaman
                const resPeminjaman = await fetch('/api/rekap/peminjaman-per-buku', { headers: { 'Accept': 'application/json' } });
                const dataPeminjaman = await resPeminjaman.json();

                const tbodyPeminjaman = document.getElementById('tabel-peminjaman');
                dataPeminjaman.forEach(item => {
                    tbodyPeminjaman.innerHTML += `
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;">${item.judul}</td>
                            <td style="padding: 8px; border: 1px solid #ddd; text-align: center; font-weight: bold;">${item.peminjaman_count}</td>
                        </tr>
                    `;
                });

            } catch (error) {
                console.error("Gagal memuat laporan", error);
                alert("Gagal memuat data laporan dari API.");
            }
        });
    </script>
@endsection