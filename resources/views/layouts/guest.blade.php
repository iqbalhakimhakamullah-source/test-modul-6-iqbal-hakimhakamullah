<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Perpustakaan') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="background-color: #fdf6e3; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; font-family: Georgia, serif;">
        
        <div style="width: 100%; max-width: 400px; background: #fff; padding: 30px; border-radius: 8px; border: 1px solid #d7ccc8; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <!-- Logo / Judul -->
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="color: #5d4037; font-size: 24px; margin: 0;">Perpustakaan Digital</h2>
                <p style="color: #8b5e3c; font-size: 14px; margin-top: 5px;">Silakan masuk ke akun Anda</p>
            </div>

            <!-- Konten Form Login -->
            {{ $slot }}
            
        </div>
    </body>
</html>