<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kategori_id' => $this->kategori_id,
            'judul_buku' => $this->judul, 
            'penulis' => $this->penulis,
            'tahun_terbit' => $this->tahun_terbit,
            'kategori' => $this->kategori ? $this->kategori->nama : 'Tanpa Kategori', 
        ];
    }
}