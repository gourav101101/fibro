<?php
// Build a fresh MariaDB database from migrations and public starter content.
// Never read/export the local database, enquiry records or administrator logins.
$database = $argv[1] ?? '';
if (! preg_match('/^fibro_package_[0-9]{14}$/', $database)) {
    throw new InvalidArgumentException('Expected isolated fibro_package_YYYYMMDDHHMMSS database name.');
}
require dirname(__DIR__).'/vendor/autoload.php';
$app = require dirname(__DIR__).'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$pdo = new PDO('mysql:host=127.0.0.1;charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pdo->exec("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
config(['database.default' => 'mariadb', 'database.connections.mariadb.host' => '127.0.0.1', 'database.connections.mariadb.port' => 3306, 'database.connections.mariadb.database' => $database, 'database.connections.mariadb.username' => 'root', 'database.connections.mariadb.password' => '', 'database.connections.mariadb.url' => null]);
Illuminate\Support\Facades\DB::purge('mariadb');
foreach ([['migrate', ['--force' => true]], ['db:seed', ['--class' => 'ContentSeeder', '--force' => true]]] as [$command, $arguments]) {
    if (Illuminate\Support\Facades\Artisan::call($command, $arguments) !== 0) {
        throw new RuntimeException(Illuminate\Support\Facades\Artisan::output());
    }
}
foreach (['admin_users', 'enquiries'] as $table) {
    if (Illuminate\Support\Facades\DB::table($table)->count() !== 0) {
        throw new RuntimeException('Fresh export must not contain private records.');
    }
}
echo "Prepared $database from migrations and ContentSeeder; no enquiries or admin accounts.\n";
