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
    
    // Buku (Bisa diakses semua role)
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
    
    // Route A2 (SQLi)
    Route::get('/buku-cari', [BukuController::class, 'cari']);

    // Route A4 (IDOR)
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']);

    // Profil Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // PERBAIKAN A3: Route DELETE (Ganti Route GET lama)
    // ==========================================
    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

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

    // Route SEMENTARA untuk ngetes perbaikan XSS
Route::get('/tes-xss', function () {
    return view('buku.index', [
        'judul_xss' => "<script>alert('250441100017')</script>", 
        'kategoris' => \App\Models\Kategori::all()
    ]);
});

});

require __DIR__.'/auth.php';