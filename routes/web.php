<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('beranda'); })->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Buku & Peminjaman Siswa
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
    Route::get('/buku-cari', [BukuController::class, 'cari']);
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']); // Route A4

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // AKSES ADMIN & PETUGAS (GATE)
    // ==========================================
    Route::middleware(['can:kelola-buku'])->group(function () {
        // Halaman Operasional Peminjaman
        Route::get('/admin/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::put('/admin/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

        // Route Kelola Buku
        Route::get('/buku/create', function () { return "Form Tambah Buku"; })->name('buku.create');
        Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
        Route::post('/api/buku', [App\Http\Controllers\Api\BukuController::class, 'store']);
        Route::put('/api/buku/{id}', [App\Http\Controllers\Api\BukuController::class, 'update']);
        Route::delete('/api/buku/{id}', [App\Http\Controllers\Api\BukuController::class, 'destroy']);
    });

    // KHUSUS ADMIN
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [PeminjamanController::class, 'index'])->name('dashboard'); // Dashboard Admin pakai controller
        Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    });

    // KHUSUS PETUGAS
    Route::middleware(['role:petugas'])->group(function () {
        Route::get('/petugas/dashboard', [PeminjamanController::class, 'index'])->name('petugas.dashboard'); // Dashboard Petugas pakai controller
    });

    // LAPORAN
    Route::middleware(['permission:Lihat laporan perpustakaan'])->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

});

require __DIR__.'/auth.php';