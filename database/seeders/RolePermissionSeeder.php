<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat 16 Permission
        $permissions = [
            'Akses dashboard admin', 'Akses dashboard petugas', 'Lihat daftar buku',
            'Kelola data buku', 'Kelola data pengguna', 'Kelola role pengguna',
            'Kelola peminjaman', 'Kelola pengembalian', 'Mengajukan peminjaman buku',
            'Memproses persetujuan peminjaman', 'Mencatat pengembalian buku',
            'Melihat status peminjaman sendiri', 'Melihat riwayat peminjaman sendiri',
            'Lihat laporan perpustakaan', 'Lihat profil sendiri', 'Ubah profil sendiri'
        ];

        foreach ($permissions as $p) {
            Permission::create(['name' => $p]);
        }

        // 2. Buat Role
        $admin = Role::create(['name' => 'admin']);
        $petugas = Role::create(['name' => 'petugas']);
        $siswa = Role::create(['name' => 'siswa']);

        // 3. Beri Permission ke Role
        $admin->givePermissionTo(Permission::all());
        
        $petugas->givePermissionTo([
            'Akses dashboard petugas', 'Lihat daftar buku', 'Kelola data buku',
            'Kelola peminjaman', 'Kelola pengembalian', 'Memproses persetujuan peminjaman',
            'Mencatat pengembalian buku', 'Lihat laporan perpustakaan', 'Lihat profil sendiri', 'Ubah profil sendiri'
        ]);

        $siswa->givePermissionTo([
            'Lihat daftar buku', 'Mengajukan peminjaman buku', 'Melihat status peminjaman sendiri',
            'Melihat riwayat peminjaman sendiri', 'Lihat profil sendiri', 'Ubah profil sendiri'
        ]);

        // 4. Buat Akun Dummy
        $uAdmin = User::create(['name' => 'Admin Perpus', 'email' => 'admin@gmail.com', 'password' => bcrypt('password')]);
        $uAdmin->assignRole('admin');

        $uPetugas = User::create(['name' => 'Petugas Perpus', 'email' => 'petugas@gmail.com', 'password' => bcrypt('password')]);
        $uPetugas->assignRole('petugas');

        $uSiswa = User::create(['name' => 'Siswa Perpus', 'email' => 'siswa@gmail.com', 'password' => bcrypt('password')]);
        $uSiswa->assignRole('siswa');
    }
}