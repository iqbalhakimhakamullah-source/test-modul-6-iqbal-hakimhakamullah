<?php

// =====================================================
// Vercel Serverless Function Entry Point untuk Laravel
// =====================================================

// 1. Buat semua direktori yang dibutuhkan Laravel di /tmp
//    (filesystem Vercel bersifat read-only kecuali /tmp)
$storagePath = '/tmp/storage';
$directories = [
    $storagePath . '/app/public',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/testing',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    '/tmp/views',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// 2. Set semua environment variable yang diperlukan SEBELUM Laravel boot
//    Ini memastikan Laravel tidak mencoba menulis ke filesystem read-only
$envOverrides = [
    'APP_STORAGE'          => $storagePath,
    'VIEW_COMPILED_PATH'   => '/tmp/views',
    'APP_CONFIG_CACHE'     => '/tmp/config.php',
    'APP_EVENTS_CACHE'     => '/tmp/events.php',
    'APP_PACKAGES_CACHE'   => '/tmp/packages.php',
    'APP_ROUTES_CACHE'     => '/tmp/routes.php',
    'APP_SERVICES_CACHE'   => '/tmp/services.php',
    'LOG_CHANNEL'          => 'stderr',
    'SESSION_DRIVER'       => 'cookie',
    'CACHE_STORE'          => 'array',
];

foreach ($envOverrides as $key => $value) {
    // Set di semua tempat agar Laravel pasti bisa baca
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

// 3. Normalisasi SCRIPT_NAME dan PHP_SELF agar Laravel tidak menganggap ada prefix /api
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

// 4. Forward request ke public/index.php Laravel
require __DIR__ . '/../public/index.php';
