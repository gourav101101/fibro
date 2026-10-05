# Hostinger deployment — Laravel / PHP / MariaDB

Fibro now runs as a Laravel 13 application. A Blade layout serves pre-rendered
public-page HTML; React hydrates the existing interactions in the browser. There is
no Next.js runtime, Node.js server, SSR worker or VPS requirement for this setup.

## Requirements

Latest content update (5 October 2026): deploy `public/images/facilities/`, its
generated responsive images, and `public/documents/fibro-grs-scope-certificate.pdf`
alongside the four build artifacts. These add the client presentation's real
facility photos and the full GRS scope document. Earlier ZIPs do not include this
update; rebuild the package before uploading. No database replacement is needed
for these facility and certificate additions.

### User-confirmed Hostinger configuration — 2 October 2026

The user reports the site works at `https://test.mdarena.in` with MariaDB at
`127.0.0.1:3306`, database and username `u308075782_fibro`, `utf8mb4` /
`utf8mb4_unicode_ci`, file sessions/cache, synchronous queues and log mail.
These non-secret settings are reflected in `.env.example`. Keep the actual
database password and existing application key only in the server's private
`fibro-app/.env`; `.env.example` does not configure Laravel by itself.

The working configuration supplied by the user also enabled local mode and debug
output and disabled secure session cookies. For the HTTPS deployment use
`APP_ENV=production`, `APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true` and
`LOG_LEVEL=warning`. The report does not establish which changed value resolved
the earlier 500 error; do not assume local/debug mode is required to run the site.
After changing the server configuration, run `php artisan config:clear` and
`php artisan optimize` from `fibro-app`. Never generate a new application key
as part of a routine update. The local developer `.env` remains independent.

Existing ZIP archives are snapshots; rebuild the deployment package to include
updated templates. They do not supply production secrets automatically.

- PHP 8.3 or newer, with Laravel's standard extensions plus `pdo_mysql`.
- MariaDB and a database user assigned to the Fibro database.
- Composer 2 on the host, or a production `vendor` folder built for compatible PHP.
- Apache/LiteSpeed rewrites (the supplied `public/.htaccess`).
- Node.js 22.12+ or 24 and npm on the build machine only.
- HTTPS and a domain configured to serve Laravel's **public** directory.

## Build before upload

The consolidated October client amendments also require `routes/frontend.php`
(Circular textiles route), `resources/data/blackout.json`, the ITTA logo and both
`public/video/fibro-*-explainer.webm` clips with their matching poster WebPs.
Upload the current `ProductCategoryUpdateSeeder.php`, both category JSON files
and all four build artifacts together. The targeted seeder now also adds blackout
curtains, corrects the baby-diaper image/name and creates the new page SEO records.
After deployment, run the targeted seeder below and `php artisan optimize` to
refresh routes/views/configuration. Existing ZIP archives predate these changes.

For the October workwear/category-photo update, deploy the rebuilt assets,
generated views/page registry, new public images, `resources/data/workwear.json`
and `database/seeders/ProductCategoryUpdateSeeder.php`. Then run
`php artisan db:seed --class=ProductCategoryUpdateSeeder --force` from `fibro-app`.
This adds workwear if absent and replaces only the two old image placeholders;
it preserves other product edits and later uploaded images. Do not rerun the full
ContentSeeder or import a fresh database for this update.

For the Hostinger "Upload your website files" importer, the prepared
`fibro-hostinger-upload.zip` includes `fibro-database.sql` (fresh MariaDB schema
and seeded starter content) with the sibling PHP deployment directories. See
`docs/hostinger-import-readme.txt`. Select PHP/Laravel hosting if asked; this is not
a Node.js application. Hostinger still needs to provision the database, configure
the production `.env` and initialize the application key/admin. Do not import the
starter SQL over a live database. The importer has not been tested on the account.

To create a clean Hostinger ZIP on Windows, run `npm run lint`, `npm run build`
and `php artisan test`, then `powershell -NoProfile -ExecutionPolicy Bypass -File scripts/package-hostinger.ps1`.
The script installs production Composer dependencies in an isolated staging folder
and creates `fibro-hostinger-YYYYMMDD-HHMMSS.zip` in the project root. Extract it
**above** `public_html`; it contains sibling `fibro-app` and `public_html`
directories plus `START-HERE.txt`. Local `.env`, databases, caches, logs, browser
profiles and Node dependencies are excluded. Preserve the live `.env`, application
key, database and uploaded images when updating an existing deployment.

The ZIP layout automatically resolves the sibling `public_html` for Artisan when
`APP_PUBLIC_PATH` is unset. An explicit `APP_PUBLIC_PATH` must use the correct
hosting path. Do not zip the entire working directory for deployment.

From the project directory:

```sh
npm ci
npm run build
```

The build creates four required deployment artifacts:

- `public/build` — versioned CSS, JavaScript and the Vite manifest.
- `public/images/optimized` — responsive WebP images.
- `resources/views/frontend/generated/` — initial HTML for all public pages, before JavaScript runs.
- `resources/data/pages.json` — page registry used by Laravel routing, metadata and the sitemap.

Upload these together with the Laravel application and original public assets,
including `public/video/fibro-film.mp4` and `public/video/fibro-film-poster.webp`.
These generated folders are ignored by Git: a checkout alone is not a deployment.
Do not upload the local `.env`, local databases, `node_modules`, `storage/app/build`, tests or
the old Next.js backup. Never upload a `public/hot` development marker.

Install production PHP dependencies in the deployment directory:

```sh
composer install --no-dev --optimize-autoloader --no-interaction
```

If Composer is unavailable on the host, run this in a separate staging copy on a
compatible build machine and include its `vendor` folder in the upload.

## XAMPP without /public

Keep the project at `D:/Xampp/htdocs/fibro`. The project-root `.htaccess` and
`index.php` now serve Laravel at `http://localhost/fibro/`, including assets and
`http://localhost/fibro/admin/login`. Apache must have `mod_rewrite` enabled and
`AllowOverride All` for `htdocs` (the current XAMPP configuration already does).

In the local `.env`, use `APP_URL=http://localhost/fibro` and
`SESSION_SECURE_COOKIE=false`, then run `php artisan config:clear`.
Browser requests to `/fibro/public/` redirect to `/fibro/`.
Form submissions from the old URLs use a 307 redirect to preserve the request
method and body, including login and logout submissions.
Application directories and hidden files are denied by the root rules; static requests are routed only to
the known asset directories in `public`.

These root files are for the project-root XAMPP layout. The Hostinger layout below
uses `public/.htaccess` and `public/index.php` in the web document root.

## Domain document root

Prefer pointing the domain at the application's `public` directory. The project
root, `.env`, database files and `vendor` must remain outside the web document root.

If your plan fixes the document root to `public_html`, place the application in a
private sibling directory such as `fibro-app`. Copy the **contents** of its `public`
directory into `public_html`, including `public/.htaccess`, `public/index.php`,
images, CSS, video and `build`. Use this layout:

```text
domain-directory/
  fibro-app/           Private Laravel application, .env and vendor
  public_html/         Contents of public/ only
    .htaccess
    index.php
    build/
    images/
    css/
    video/
```

The supplied `public/index.php` automatically loads a sibling named `fibro-app`
when the standard Laravel parent-directory layout is absent, and sets the public
path to its own directory. No index.php edits are needed for this layout. If you
choose another private folder name, update the `fibro-app` name in that entry point.
Keep the project-root `.htaccess` and root `index.php` in the private application;
do not substitute them for the files from `public/`.

Also set `APP_PUBLIC_PATH` in the server `.env` to the absolute `public_html` path.
Fibro's application provider supports this variable so Artisan and HTTP requests use the same
Vite manifest location. Use the actual directory paths from your hosting account.
Set `APP_URL=https://your-real-domain` without `/public` or `/public_html`.

Enable HTTPS through hPanel for the live domain. Keep the shared `.htaccess` usable
on local HTTP as well; do not hard-code the production hostname or HTTPS redirect
into the XAMPP rules. If a `.htaccess` file is not visible in Hostinger's File
Manager, enable hidden files.

## Production configuration

Create a file named exactly `.env` in the private Laravel application directory.
Laravel reads `.env` at runtime; `.env.example` is only a safe template and will not
configure the application by itself. Copy the keys from `.env.example` into `.env`,
then set `APP_URL` to the real HTTPS domain and fill in the Hostinger MariaDB host,
name, username and password. Do not place `.env` inside `public_html` and do not share
or commit its values.
Keep `APP_ENV=production`, `APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true`,
`SESSION_DRIVER=file`, `CACHE_STORE=file` and `QUEUE_CONNECTION=sync`.

Use these database keys with the values shown in Hostinger's MariaDB panel:

```dotenv
DB_CONNECTION=mariadb
DB_HOST=your-hostinger-database-host
DB_PORT=3306
DB_DATABASE=your-hostinger-database-name
DB_USERNAME=your-hostinger-database-user
DB_PASSWORD=your-private-database-password
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

MariaDB uses PHP's `pdo_mysql` extension even though Laravel's connection name is
`mariadb`.

For a **new** installation only, generate its unique key:

```sh
php artisan key:generate
```

Keep this key stable on future deployments. Then run:

```sh
php artisan migrate --force
php artisan db:seed --class=ContentSeeder --force
php artisan optimize
```

`ContentSeeder` creates the initial products, services, materials, hero stories,
company details, certifications and Page SEO records. Run it for the first deployment;
later content should normally be managed through the admin panel.

Create the first administrator with a unique email and a strong temporary password.
Add these three values to the server `.env` temporarily:

```dotenv
ADMIN_SEED_NAME="Fibro Admin"
ADMIN_SEED_EMAIL=your-private-admin-email@example.com
ADMIN_SEED_PASSWORD=use-a-long-unique-password-here
```

Then run:

```sh
php artisan config:clear
php artisan db:seed --class=AdminUserSeeder --force
php artisan optimize
```

This command also replaces the password for an existing account with the same email,
so it can safely remove an old deployment password. After the account is created,
remove `ADMIN_SEED_PASSWORD` from `.env` and run
`php artisan optimize` again. The administrator signs in at `/admin/login`.

The PHP process must be able to write `storage`, `bootstrap/cache`, `public/images/uploads` and `public/images/credentials/uploads`. Ensure the hosting PHP `upload_max_filesize` and `post_max_size` allow uploads of at least 8 MB. Use suitable
ownership and host-supported permissions; do not make the whole project writable.
If your plan has no terminal access, arrange the migration through the hosting
deployment tooling or support; do not create a public route that runs Artisan.

## What is implemented

- Project/sample enquiries are saved to the `enquiries` table with name, email,
  optional company, material/application context, message, language and timestamps.
- CSRF protection, server validation, consent, a honeypot and five attempts per
  minute per IP. The form reports success only after a successful database write.
- Contact email and WhatsApp remain available as alternatives.
- The authenticated admin area at `/admin/login` manages enquiries, products,
  services, materials, hero stories, company details, certifications and page SEO. Public content reads these records from MariaDB, so normal admin edits require no frontend rebuild.
- Product, service, material, hero and certification forms accept JPG, PNG and WebP uploads up to 8 MB. Uploaded files are stored below `public/images/uploads` or `public/images/credentials/uploads`.
- Admin login is rate limited and admin pages are excluded from search indexing.
- Automatic enquiry notification email is not implemented; new enquiries appear in
  the admin dashboard and enquiry inbox.
- The live local preview uses SQLite for convenience; production uses Laravel's
  MariaDB connection and schema support.

## Verify after deployment

Check `/`, `/products`, `/services`, `/about`, `/technology`, `/contact`,
`/sustainability`, `/manufacturing-quality`, the four logos in the homepage
responsibility section,
product and service detail links, `/sitemap.xml`, `/up`, all three hero stories and their CTAs,
material detail panels, the layer animation, nine application tabs, mobile
navigation, French/Hindi selection, WhatsApp and the enquiry dialog. Send one
clearly labelled test enquiry and confirm exactly one row appears in MariaDB.
Check that missing/invalid input is rejected and that `.env` is not publicly served.
Sign in at `/admin/login`, verify the mobile menu, open each admin section, and test
one harmless content edit before launch.
Back up the production database and retain the application key before later updates.

Changing public-page content requires `npm run build` and uploading all four build
artifacts again. Future database-driven content can be supplied by Laravel when
that feature is implemented; current marketing content is still maintained in source.
