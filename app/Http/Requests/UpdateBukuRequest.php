<?php

namespace App\Http\Requests;

class UpdateBukuRequest extends StoreBukuRequest
{
    public function rules(): array
    {
        // Ambil aturan dari StoreBukuRequest
        $rules = parent::rules();
        
        // Ubah 'required' menjadi 'sometimes' agar boleh kosong saat update parsial
        $rules['kategori_id'] = 'sometimes|exists:kategoris,id';
        $rules['judul'] = 'sometimes|string|min:3|max:150';
        $rules['penulis'] = 'sometimes|string|min:3|max:100';
        $rules['tahun_terbit'] = 'sometimes|integer|between:1900,' . date('Y');

        return $rules;
    }
}