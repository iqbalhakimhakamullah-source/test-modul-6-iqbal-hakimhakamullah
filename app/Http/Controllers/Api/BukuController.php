<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Http\Resources\BukuResource;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        // Menggunakan API Resource untuk membungkus data
        return BukuResource::collection(Buku::with('kategori')->latest()->get());
    }

    public function store(Request $request)
    {

                // Sesuai instruksi: Gunakan $request->validate()
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|min:3|max:150',
            'penulis' => 'required|string|min:3|max:100',
            'tahun_terbit' => 'required|integer|between:1900,' . date('Y'),
        ], [
            // --- INI PESAN BAHASA INDONESIANYA ---
            'kategori_id.required' => 'Kategori wajib diisi.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'judul.required' => 'Judul buku wajib diisi.',
            'judul.string' => 'Judul buku harus berupa teks.',
            'judul.min' => 'Judul buku minimal 3 karakter.',
            'judul.max' => 'Judul buku maksimal 150 karakter.',
            'penulis.required' => 'Penulis wajib diisi.',
            'penulis.string' => 'Penulis harus berupa teks.',
            'penulis.min' => 'Penulis minimal 3 karakter.',
            'penulis.max' => 'Penulis maksimal 100 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.between' => 'Tahun terbit harus antara 1900 sampai tahun saat ini.',
        ]);

        $buku = Buku::create($validated);
        return new BukuResource($buku->load('kategori'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);
        if (!$buku) return response()->json(['message' => 'not found'], 404);
        
        return new BukuResource($buku);
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);
        if (!$buku) return response()->json(['message' => 'not found'], 404);

                // Sesuai instruksi: Gunakan $request->validate()
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|min:3|max:150',
            'penulis' => 'required|string|min:3|max:100',
            'tahun_terbit' => 'required|integer|between:1900,' . date('Y'),
        ], [
            // --- INI PESAN BAHASA INDONESIANYA ---
            'kategori_id.required' => 'Kategori wajib diisi.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'judul.required' => 'Judul buku wajib diisi.',
            'judul.string' => 'Judul buku harus berupa teks.',
            'judul.min' => 'Judul buku minimal 3 karakter.',
            'judul.max' => 'Judul buku maksimal 150 karakter.',
            'penulis.required' => 'Penulis wajib diisi.',
            'penulis.string' => 'Penulis harus berupa teks.',
            'penulis.min' => 'Penulis minimal 3 karakter.',
            'penulis.max' => 'Penulis maksimal 100 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.between' => 'Tahun terbit harus antara 1900 sampai tahun saat ini.',
        ]);

        $buku->update($validated);
        return new BukuResource($buku->load('kategori'));
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);
        if (!$buku) return response()->json(['message' => 'not found'], 404);

        $buku->delete();
        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }
}