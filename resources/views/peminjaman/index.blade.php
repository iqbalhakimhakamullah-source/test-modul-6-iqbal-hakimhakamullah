@extends('layouts.app')

@section('title', 'Operasional Peminjaman')

@section('content')
    <h2>Operasional Peminjaman Buku</h2>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Kartu Statistik -->
    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px;">
        <div style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8; text-align: center;">
            <h3 style="color: #5d4037; margin: 0;">Total Buku</h3>
            <p style="font-size: 24px; font-weight: bold; margin: 10px 0 0 0;">{{ $total_buku }}</p>
        </div>
        <div style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8; text-align: center;">
            <h3 style="color: #5d4037; margin: 0;">Total Pengguna</h3>
            <p style="font-size: 24px; font-weight: bold; margin: 10px 0 0 0;">{{ $total_user }}</p>
        </div>
        <div style="flex: 1; min-width: 200px; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8; text-align: center;">
            <h3 style="color: #5d4037; margin: 0;">Sedang Dipinjam</h3>
            <p style="font-size: 24px; font-weight: bold; margin: 10px 0 0 0; color: #eab308;">{{ $total_pinjam }}</p>
        </div>
    </div>

    <!-- Tabel Peminjaman -->
    <div style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f3f4f6;">
                    <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Peminjam</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Judul Buku</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Tgl Pinjam</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Tgl Kembali</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Status</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $p)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $p->id }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $p->user->name ?? 'User Dihapus' }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $p->buku->judul ?? 'Buku Dihapus' }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $p->tanggal_pinjam }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $p->tanggal_kembali ?? '-' }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        @if($p->tanggal_kembali)
                            <span style="background: #10b981; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px;">Selesai</span>
                        @else
                            <span style="background: #eab308; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px;">Dipinjam</span>
                        @endif
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        @if(!$p->tanggal_kembali)
                            <form action="{{ route('peminjaman.kembalikan', $p->id) }}" method="POST" style="margin:0;">
                                @csrf
                                @method('PUT')
                                <button type="submit" style="background:#3b82f6; color:white; padding:5px 10px; border:none; border-radius:3px; cursor:pointer;">Proses Kembali</button>
                            </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 10px; border: 1px solid #ddd; text-align: center;">Belum ada data peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection