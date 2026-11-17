<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <h1>Perpustakaan Digital</h1>
    </header>

    <nav style="display: flex; justify-content: center; align-items: center; gap: 20px;">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('buku.index') }}">Daftar Buku</a>

        {{-- Menu Laporan hanya untuk Admin & Petugas --}}
        @can('Lihat laporan perpustakaan')
            <a href="{{ route('laporan.index') }}">Laporan</a>
        @endcan 
        
        @role('admin')
            <a href="{{ route('users.index') }}">Kelola Pengguna</a>
        @endrole

        {{-- BAGIAN LOGIN / LOGOUT --}}
        @auth
            <span style="color: white; font-size: 14px; margin-left: 20px;">Halo, {{ Auth::user()->name }}</span>
            
            {{-- Link Ubah Profil --}}
            <a href="{{ route('profile.edit') }}">Ubah Profil</a>
            
            <form method="POST" action="{{ route('logout') }}" style="display:inline; margin-left: 10px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:white; font-weight:bold; cursor:pointer; font-size: 16px; text-decoration: underline;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" style="margin-left: 20px;">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} Perpustakaan 250441100017. All rights reserved.
    </footer>
</body>
</html>