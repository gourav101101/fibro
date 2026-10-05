FIBRO - PHP / LARAVEL WEBSITE BACKUP

For Hostinger's "Upload your website files" importer.
This is a PHP 8.3+ / MariaDB application, not a Node.js or static Vite website.
All frontend assets and production PHP dependencies are already built.
No npm build command or dist output directory is needed on the host.

Archive contents:
  public_html/       Website document root, index.php and compiled assets
  fibro-app/         Private Laravel application and production vendor files
  fibro-database.sql  Fresh MariaDB schema and starter company content

HOSTINGER IMPORT / MIGRATION CONFIGURATION
1. Deploy public_html and fibro-app as siblings. Only public_html is web-accessible.
2. Import fibro-database.sql into an EMPTY MariaDB database. It includes migration
   history and starter content. It is not a backup of an existing live database.
3. Create fibro-app/.env from .env.example. Set the actual domain APP_URL and
   Hostinger DB_HOST, DB_DATABASE, DB_USERNAME and DB_PASSWORD. Keep production
   settings. APP_PUBLIC_PATH may be omitted with the supplied sibling layout.
4. From fibro-app, run php artisan key:generate for a NEW installation only,
   then php artisan package:discover and php artisan optimize.
5. Create the administrator with AdminUserSeeder using private ADMIN_SEED_NAME,
   ADMIN_SEED_EMAIL and ADMIN_SEED_PASSWORD environment settings. Remove the
   password setting afterward. No administrator password is included in this ZIP.
6. PHP needs write access to fibro-app/storage, fibro-app/bootstrap/cache,
   public_html/images/uploads and public_html/images/credentials/uploads.

For an existing live site, preserve its .env, APP_KEY, database and uploaded files.
Do not import this fresh starter database over an existing production database.

If the upload summary detects Node.js, React or Vite hosting, choose PHP / Laravel
if that choice is available; otherwise ask Hostinger support to deploy this PHP
backup. Changing the output directory to public/build alone will not run Laravel.

The archive does not contain local credentials, enquiries, administrator accounts,
SQLite files, Node dependencies, browser caches or development markers.
Database credentials must be assigned by the host; the ZIP cannot predict them.
