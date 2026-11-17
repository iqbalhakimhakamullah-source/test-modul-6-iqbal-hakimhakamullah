<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PeminjamanPolicy
{
    /**
     * Menentukan apakah user boleh melihat data peminjaman.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // 1. Admin dan Petugas boleh melihat SEMUA peminjaman
        if ($user->hasRole('admin') || $user->hasRole('petugas')) {
            return true;
        }

        // 2. Siswa HANYA boleh melihat peminjaman miliknya sendiri.
        // Asumsi: di tabel peminjamans ada kolom 'user_id' (dari Modul 5)
        return $user->id === $peminjaman->user_id;
    }
}