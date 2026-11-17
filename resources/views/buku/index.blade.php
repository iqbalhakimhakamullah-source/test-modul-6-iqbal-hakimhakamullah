@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <h2>Daftar Buku</h2>
    <!-- CELAH A1: XSS -->
    <div>{{ isset($judul_xss) ? $judul_xss : '' }}</div>

    <div id="alert-box" style="display:none; padding: 10px; margin-bottom: 15px; border-radius: 5px;"></div>

    {{-- FORM TAMBAH BUKU: Hanya muncul untuk Admin & Petugas --}}
    @role('admin|petugas')
    <div class="form-container" style="background:#fff; padding:15px; border-radius:8px; margin-bottom: 20px; border: 1px solid #d7ccc8;">
        <h3 id="form-title" style="font-weight: bold; margin-bottom: 15px;">Tambah Buku Baru</h3>
        <form id="bukuForm">
            <input type="hidden" id="buku_id" name="id">
            <div style="margin-bottom:10px;">
                <label style="display:block; margin-bottom:5px;">Kategori:</label>
                <select id="kategori_id" name="kategori_id" required style="width:100%; padding:8px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:10px;">
                <label style="display:block; margin-bottom:5px;">Judul:</label>
                <input type="text" id="judul" name="judul" required style="width:100%; padding:8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="margin-bottom:10px;">
                <label style="display:block; margin-bottom:5px;">Penulis:</label>
                <input type="text" id="penulis" name="penulis" required style="width:100%; padding:8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="margin-bottom:10px;">
                <label style="display:block; margin-bottom:5px;">Tahun Terbit:</label>
                <input type="number" id="tahun_terbit" name="tahun_terbit" required style="width:100%; padding:8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <button type="submit" id="submit-btn" class="btn">Simpan</button>
            <button type="button" id="cancel-btn" style="display:none; background:#999; color:white; padding:10px 20px; border-radius:4px; border:none; cursor:pointer;" onclick="resetForm()">Batal Edit</button>
        </form>
    </div>
    @endrole

    <div class="overflow-x-auto">
        <table style="width:100%; border-collapse: collapse; background: #fff;">
            <thead>
                <tr style="background:#f3f4f6;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Kategori</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Judul Buku</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Penulis</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Tahun Terbit</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Aksi</th>
                </tr>
            </thead>
            <tbody id="buku-table-body">
            </tbody>
        </table>
    </div>

    <script>
        const apiUrl = '/api/buku';
        const tableBody = document.getElementById('buku-table-body');
        const form = document.getElementById('bukuForm');
        const alertBox = document.getElementById('alert-box');
        // Ambil role user yang sedang login
        const userRole = "{{ auth()->check() ? auth()->user()->getRoleNames()->first() : '' }}"; 

        function showAlert(message, isError = false) {
            alertBox.style.display = 'block';
            alertBox.style.backgroundColor = isError ? '#f8d7da' : '#d4edda';
            alertBox.style.color = isError ? '#721c24' : '#155724';
            alertBox.innerText = message;
            setTimeout(() => { alertBox.style.display = 'none'; }, 3000);
        }

        async function loadData() {
            try {
                const response = await fetch(apiUrl, { headers: { 'Accept': 'application/json' } });
                if (!response.ok) throw new Error('Gagal mengambil data.');
                const result = await response.json();
                
                tableBody.innerHTML = '';
                result.data.forEach((buku) => {
                    let aksiHtml = '-';
                    
                    // TOMBOL AKSI: Hanya muncul untuk admin & petugas
                    if (userRole === 'admin' || userRole === 'petugas') {
                        aksiHtml = `
                            <button onclick="editData(${buku.id}, '${buku.kategori_id}', '${buku.judul_buku}', '${buku.penulis}', ${buku.tahun_terbit})" style="background:#eab308; color:white; padding:5px 10px; border:none; border-radius:3px; cursor:pointer; margin-right:5px;">Ubah</button>
                            <button onclick="deleteData(${buku.id})" style="background:#ef4444; color:white; padding:5px 10px; border:none; border-radius:3px; cursor:pointer;">Hapus</button>
                        `;
                    }

                    const row = `
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;">${buku.kategori}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">${buku.judul_buku}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">${buku.penulis}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">${buku.tahun_terbit}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">${aksiHtml}</td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
            } catch (error) {
                showAlert(error.message, true);
            }
        }

        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const id = document.getElementById('buku_id').value;
                const isEdit = id !== '';
                const payload = {
                    kategori_id: document.getElementById('kategori_id').value,
                    judul: document.getElementById('judul').value,
                    penulis: document.getElementById('penulis').value,
                    tahun_terbit: document.getElementById('tahun_terbit').value,
                };

                const method = isEdit ? 'PUT' : 'POST';
                const url = isEdit ? `${apiUrl}/${id}` : apiUrl;

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                        body: JSON.stringify(payload)
                    });
                    const result = await response.json();

                    if (!response.ok) {
                        if (response.status === 422) {
                            const errors = Object.values(result.errors).flat().join(', ');
                            throw new Error(errors);
                        }
                        throw new Error(result.message || 'Terjadi kesalahan.');
                    }

                    showAlert(isEdit ? 'Berhasil diperbarui!' : 'Berhasil ditambahkan!');
                    resetForm();
                    loadData(); 
                } catch (error) {
                    showAlert(error.message, true);
                }
            });
        }

             async function deleteData(id) {
            if (!confirm('Yakin ingin menghapus buku ini?')) return;
            
            // Ambil token CSRF dari meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch(`/buku/${id}`, { // Ubah URL ke /buku/{id}, bukan /api/buku
                    method: 'DELETE',
                    headers: { 
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Sertakan token di sini
                    }
                });
                if (!response.ok) throw new Error('Gagal menghapus data.');
                showAlert('Buku berhasil dihapus.');
                loadData();
            } catch (error) {
                showAlert(error.message, true);
            }
        }

        function editData(id, kategori_id, judul, penulis, tahun_terbit) {
            document.getElementById('buku_id').value = id;
            document.getElementById('kategori_id').value = kategori_id;
            document.getElementById('judul').value = judul;
            document.getElementById('penulis').value = penulis;
            document.getElementById('tahun_terbit').value = tahun_terbit;

            document.getElementById('form-title').innerText = 'Edit Buku';
            document.getElementById('submit-btn').innerText = 'Update Buku';
            document.getElementById('cancel-btn').style.display = 'inline-block';
            window.scrollTo(0, 0);
        }

        function resetForm() {
            if(form) form.reset();
            if(document.getElementById('buku_id')) document.getElementById('buku_id').value = '';
            if(document.getElementById('form-title')) document.getElementById('form-title').innerText = 'Tambah Buku Baru';
            if(document.getElementById('submit-btn')) document.getElementById('submit-btn').innerText = 'Simpan';
            if(document.getElementById('cancel-btn')) document.getElementById('cancel-btn').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', loadData);
    </script>
@endsection