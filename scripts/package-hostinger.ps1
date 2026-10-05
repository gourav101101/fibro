$ErrorActionPreference = 'Stop'
$projectRoot = Split-Path $PSScriptRoot -Parent
$stamp = Get-Date -Format 'yyyyMMdd-HHmmss'
$stage = Join-Path $projectRoot "storage/app/hostinger-package-$stamp"
$private = Join-Path $stage 'fibro-app'
$web = Join-Path $stage 'public_html'
$zipPath = Join-Path $projectRoot "fibro-hostinger-$stamp.zip"

New-Item -ItemType Directory -Path $private, $web | Out-Null
foreach ($directory in @('app', 'config', 'routes', 'resources')) {
    Copy-Item -LiteralPath (Join-Path $projectRoot $directory) -Destination $private -Recurse
}
New-Item -ItemType Directory -Path (Join-Path $private 'bootstrap/cache'), (Join-Path $private 'database') | Out-Null
Get-ChildItem -LiteralPath (Join-Path $projectRoot 'bootstrap') -File | Copy-Item -Destination (Join-Path $private 'bootstrap')
foreach ($directory in @('factories', 'migrations', 'seeders')) {
    if (Test-Path -LiteralPath (Join-Path $projectRoot "database/$directory")) {
        Copy-Item -LiteralPath (Join-Path $projectRoot "database/$directory") -Destination (Join-Path $private 'database') -Recurse
    }
}
foreach ($file in @('artisan', 'composer.json', 'composer.lock', '.env.example')) {
    Copy-Item -LiteralPath (Join-Path $projectRoot $file) -Destination $private
}
foreach ($directory in @('app/private', 'app/public', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs')) {
    New-Item -ItemType Directory -Path (Join-Path $private "storage/$directory") -Force | Out-Null
}
Get-ChildItem -LiteralPath (Join-Path $projectRoot 'public') -Force |
    Where-Object { $_.Name -ne 'hot' } | Copy-Item -Destination $web -Recurse
Copy-Item -LiteralPath (Join-Path $projectRoot 'docs/hostinger-zip-readme.txt') -Destination (Join-Path $stage 'START-HERE.txt')

# Install from the lockfile into staging; never change local development dependencies.
$composerCommand = (Get-Command composer).Source
$composerPhar = Join-Path (Split-Path $composerCommand -Parent) 'composer.phar'
$phpModules = & php -m
if ($phpModules -notcontains 'zip' -and (Test-Path -LiteralPath $composerPhar)) {
    & php -d extension=zip $composerPhar install --working-dir=$private --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-scripts
} else {
    & composer install --working-dir=$private --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-scripts
}
if ($LASTEXITCODE -ne 0) { throw 'Production Composer install failed.' }

$manifestPath = Join-Path $web 'build/manifest.json'
$manifest = Get-Content -LiteralPath $manifestPath -Raw | ConvertFrom-Json
if (-not $manifest.'resources/js/frontend/app.jsx') { throw 'Frontend entry missing from manifest.' }
foreach ($entry in $manifest.PSObject.Properties.Value) {
    foreach ($asset in @($entry.file) + @($entry.css) + @($entry.assets)) {
        if ($asset -and -not (Test-Path -LiteralPath (Join-Path $web "build/$asset"))) { throw "Missing built asset: $asset" }
    }
}
foreach ($file in @('resources/data/pages.json', 'resources/views/frontend/generated/home.blade.php', 'vendor/autoload.php')) {
    if (-not (Test-Path -LiteralPath (Join-Path $private $file))) { throw "Missing deployment artifact: $file" }
}
if (-not (Test-Path -LiteralPath (Join-Path $web 'images/optimized'))) { throw 'Missing optimized images.' }
if ((Test-Path -LiteralPath (Join-Path $private '.env')) -or (Test-Path -LiteralPath (Join-Path $web 'hot'))) { throw 'Local configuration leaked into staging.' }

Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem
$archive = [System.IO.Compression.ZipFile]::Open($zipPath, [System.IO.Compression.ZipArchiveMode]::Create)
try {
    foreach ($item in Get-ChildItem -LiteralPath $stage -Recurse -Force) {
        $entryName = $item.FullName.Substring($stage.Length + 1).Replace('\', '/')
        if ($item.PSIsContainer) {
            $archive.CreateEntry($entryName + '/') | Out-Null
        } else {
            [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($archive, $item.FullName, $entryName, [System.IO.Compression.CompressionLevel]::Optimal) | Out-Null
        }
    }
} finally {
    $archive.Dispose()
}
Write-Output "ZIP: $zipPath"
Write-Output "Staging: $stage"
