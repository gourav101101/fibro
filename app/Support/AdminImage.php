<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminImage
{
    public static function store(?UploadedFile $file, string $directory, ?string $current = null): ?string
    {
        if (! $file) return $current;

        $directory = trim($directory, '/');
        $filename = Str::uuid().'.'.strtolower($file->extension());
        Storage::disk('web')->putFileAs('images/'.$directory, $file, $filename);
        self::deleteManaged($current);

        $path = $directory.'/'.$filename;
        if (Str::startsWith($directory, ['uploads/products', 'uploads/services', 'credentials/'])) return $path;
        return '/images/'.$path;
    }

    public static function deleteManaged(?string $image): void
    {
        if (! $image) return;
        $path = ltrim(str_replace('\\', '/', $image), '/');
        if (Str::startsWith($path, 'images/')) $path = substr($path, 7);
        if (Str::startsWith($path, ['uploads/', 'credentials/uploads/'])) {
            Storage::disk('web')->delete('images/'.$path);
        }
    }
}
