<?php
// Smoke-test an isolated package staging directory after the ZIP is created.
$stage = $argv[1];
require $stage.'/fibro-app/vendor/autoload.php';
$app = require $stage.'/fibro-app/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
if (realpath(public_path()) !== realpath($stage.'/public_html')) {
    throw new RuntimeException('Artisan resolved the wrong public path: '.public_path());
}
$tags = (string) $app->make(Illuminate\Foundation\Vite::class)(['resources/js/frontend/app.jsx']);
if (! str_contains($tags, '/build/assets/app-') || str_contains($tags, ':5173')) {
    throw new RuntimeException('Production Vite tags are invalid.');
}
config(['app.key' => 'base64:'.base64_encode(random_bytes(32)), 'session.driver' => 'array', 'cache.default' => 'array', 'database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::create('https://fibro.example/', 'GET'));
if ($response->getStatusCode() !== 200 || ! str_contains($response->getContent(), '/build/assets/app-')) {
    throw new RuntimeException('Packaged homepage failed: HTTP '.$response->getStatusCode());
}
echo "PASS: packaged production dependencies, automatic public path, Vite CSS/JS tags and homepage HTTP 200.\n";
