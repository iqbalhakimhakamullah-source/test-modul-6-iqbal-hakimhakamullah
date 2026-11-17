@props(['buku'])

<div class="buku-card">
    <h3>{{ $buku->judul }}</h3>
    <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
    <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>

    <div class="badge">
        {{ $badge ?? 'Umum' }}
    </div>

    <div class="slot-tambahan">
        {{ $slot }}
    </div>

    <a href="/buku/{{ $buku->id }}" class="btn-detail">Lihat Detail</a>
</div>