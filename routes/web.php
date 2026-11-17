<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

// Route Publik
Route::get('/', function () {
    return view('beranda');
})->name('home');

// Route yang WAJIB Login (Auth)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Buku (Lihat saja, semua role bisa)
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
    
    // Route Celah A2 (SQLi)
    Route::get('/buku-cari', [BukuController::class, 'cari']);

    // Route Celah A4 (IDOR)
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']);

    // Profil Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // SOAL 3: Route Kelola Buku pakai Gate
    // ==========================================
    Route::middleware(['can:kelola-buku'])->group(function () {
        // Route dummy untuk ngetes 403 Forbidden (Siswa ketik URL ini)
        Route::get('/buku/create', function () { 
            return "Halaman Form Tambah Buku"; 
        })->name('buku.create');
        
        // Route Hapus (Perbaikan A3)
        Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
        
        // Route API untuk CRUD (jika ditaruh di web.php)
        Route::post('/api/buku', [App\Http\Controllers\Api\BukuController::class, 'store']);
        Route::put('/api/buku/{id}', [App\Http\Controllers\Api\BukuController::class, 'update']);
        Route::delete('/api/buku/{id}', [App\Http\Controllers\Api\BukuController::class, 'destroy']);
    });

    // ==========================================
    // KHUSUS ADMIN
    // ==========================================
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
        Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    });

    // ==========================================
    // KHUSUS PETUGAS
    // ==========================================
    Route::middleware(['role:petugas'])->group(function () {
        Route::get('/petugas/dashboard', function () { 
            return view('petugas.dashboard'); 
        })->name('petugas.dashboard');
    });

    // ==========================================
    // LAPORAN
    // ==========================================
    Route::middleware(['permission:Lihat laporan perpustakaan'])->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

});

require __DIR__.'/auth.php';