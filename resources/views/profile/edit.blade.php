@extends('layouts.app')

@section('title', 'Ubah Profil')

@section('content')
    <h2>Pengaturan Akun</h2>

    <div style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #d7ccc8; max-width: 600px; margin-top: 20px;">
        
        <!-- ================= FORM UBAH NAMA & EMAIL ================= -->
        <h3 style="color: #5d4037; margin-bottom: 15px; font-weight: bold;">Informasi Profil</h3>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div style="margin-bottom: 15px;">
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Nama:</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                @error('name') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Email:</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                @error('email') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; align-items: center;">
                <button type="submit" class="btn">Simpan Perubahan</button>
                @if (session('status') === 'profile-updated')
                    <span style="color: green; margin-left: 15px; font-size: 14px;">Berhasil disimpan!</span>
                @endif
            </div>
        </form>

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

        <!-- ================= FORM UBAH PASSWORD ================= -->
        <h3 style="color: #5d4037; margin-bottom: 15px; font-weight: bold;">Ubah Password</h3>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div style="margin-bottom: 15px;">
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Password Saat Ini:</label>
                <input type="password" name="current_password" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                @error('current_password', 'updatePassword') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Password Baru:</label>
                <input type="password" name="password" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                @error('password', 'updatePassword') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; font-weight:bold; margin-bottom:5px;">Konfirmasi Password Baru:</label>
                <input type="password" name="password_confirmation" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="display: flex; align-items: center;">
                <button type="submit" class="btn">Ubah Password</button>
                @if (session('status') === 'password-updated')
                    <span style="color: green; margin-left: 15px; font-size: 14px;">Password berhasil diubah!</span>
                @endif
            </div>
        </form>
    </div>
@endsection