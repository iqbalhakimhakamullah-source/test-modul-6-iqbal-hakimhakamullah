<?php

// Vercel Serverless Function Entry Point untuk Laravel
$storagePath = '/tmp/storage';
$directories = [
    $storagePath . '/app',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Paksa Laravel agar menyimpan file sementara di /tmp (karena Vercel read-only)
putenv('APP_STORAGE=' . $storagePath);
putenv('VIEW_COMPILED_PATH=' . $storagePath . '/framework/views');

// Panggil file index utama Laravel
require __DIR__ . '/../public/index.php';