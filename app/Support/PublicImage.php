<?php

namespace App\Support;

use Illuminate\Support\Str;

class PublicImage
{
    public static function url(?string $image, ?string $directory = null): ?string
    {
        if (! $image) {
            return null;
        }

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        $path = ltrim(str_replace('\\', '/', $image), '/');

        if (Str::startsWith($path, 'images/')) {
            return asset($path);
        }

        if ($directory && ! Str::startsWith($path, trim($directory, '/').'/')) {
            $path = trim($directory, '/').'/'.$path;
        }

        return asset('images/'.$path);
    }
}
