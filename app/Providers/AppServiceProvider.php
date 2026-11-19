<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Paksa HTTPS di environment production/Vercel untuk mencegah Mixed Content
        if (config('app.env') === 'production' || isset($_ENV['VERCEL']) || env('VERCEL')) {
            URL::forceScheme('https');
        }

        // SOAL 3: Definisi Gate 'kelola-buku'
        Gate::define('kelola-buku', function (User $user) {
            return $user->hasRole('admin') || $user->hasRole('petugas');
        });
    }
}