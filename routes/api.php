<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;

// Bisa diakses publik/semua role
Route::get('/buku', [BukuController::class, 'index']);
Route::get('/buku/{id}', [BukuController::class, 'show']);

// SOAL 3: Gunakan Gate untuk melindungi API CRUD
Route::middleware(['web', 'auth:web', 'can:kelola-buku'])->group(function () {
    Route::post('/buku', [BukuController::class, 'store']);
    Route::put('/buku/{id}', [BukuController::class, 'update']);
    Route::delete('/buku/{id}', [BukuController::class, 'destroy']);
});

Route::get('/rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori']);
Route::get('/rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);