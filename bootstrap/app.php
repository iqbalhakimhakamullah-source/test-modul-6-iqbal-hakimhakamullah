<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Redirect storage path ke /tmp pada environment Vercel (serverless, read-only filesystem)
$storagePath = match (true) {
    !empty($_ENV['APP_STORAGE']) => $_ENV['APP_STORAGE'],
    !empty($_SERVER['APP_STORAGE']) => $_SERVER['APP_STORAGE'],
    (getenv('APP_STORAGE') !== false) => getenv('APP_STORAGE'),
    isset($_ENV['VERCEL']), isset($_SERVER['VERCEL']), (getenv('VERCEL') !== false) => '/tmp/storage',
    default => null,
};

if ($storagePath !== null) {
    if (!is_dir($storagePath . '/framework/views')) {
        @mkdir($storagePath . '/framework/views', 0755, true);
        @mkdir($storagePath . '/framework/cache/data', 0755, true);
        @mkdir($storagePath . '/framework/sessions', 0755, true);
        @mkdir($storagePath . '/logs', 0755, true);
    }
    $app->useStoragePath($storagePath);
}

return $app;
