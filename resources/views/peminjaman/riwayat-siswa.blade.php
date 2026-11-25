@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <h2>Riwayat Peminjaman Saya</h2>

    <div style="margin-bottom: 15px;">
        <a href="{{ route('buku.index') }}" style="background:#6b7280; color:white; padding:10px 20px; border-radius:4px; text-decoration:none; display:inline-block;">
            ← Kembali ke Daftar Buku
        </a>
    </div>

    <div class="overflow-x-auto">
        <table style="width:100%; border-collapse: collapse; background: #fff;">
            <thead>
                <tr style="background:#f3f4f6;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Judul Buku</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Tanggal Pinjam</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Tanggal Kembali</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $peminjaman)
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $peminjaman->id }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $peminjaman->buku->judul }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $peminjaman->tanggal_pinjam }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">
                            {{ $peminjaman->tanggal_kembali ?? 'Belum dikembalikan' }}
                        </td>
                        <td style="padding: 8px; border: 1px solid #ddd;">
                            @if($peminjaman->tanggal_kembali)
                                <span style="background: #d4edda; color: #155724; padding: 2px 8px; border-radius: 3px;">Dikembalikan</span>
                            @else
                                <span style="background: #fff3cd; color: #856404; padding: 2px 8px; border-radius: 3px;">Dipinjam</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                            Belum ada riwayat peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
