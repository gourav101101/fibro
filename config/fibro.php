<?php
// The deployment ZIP places public_html beside the private application.
// Resolve the same public directory for Artisan as public/index.php uses for HTTP.
$hostingerPublicPath = dirname(base_path()).'/public_html';

return ['public_path' => env('APP_PUBLIC_PATH',
    is_file($hostingerPublicPath.'/build/manifest.json') && ! is_dir(base_path('public'))
        ? $hostingerPublicPath
        : null
)];
