<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route Publik
Route::get('/', function () {
    return view('beranda');
})->name('home');

// Route yang WAJIB Login (Auth)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');

    // Profile Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // KHUSUS ADMIN
    // ==========================================
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
        
        // Fitur Kelola Pengguna & Role
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
    // LAPORAN (Admin & Petugas)
    // ==========================================
    Route::middleware(['permission:Lihat laporan perpustakaan'])->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

}); // <--- Ini penutup grup Auth yang benar (cuma satu)

require __DIR__.'/auth.php';