# Fibro Laminates

Laravel 13 + PHP + MariaDB enquiry storage. Vite builds the existing React
public pages into browser assets and pre-rendered HTML served by a Blade layout.
Next.js is no longer used. No Node.js process is needed in production.

## Run locally

Requirements: PHP 8.3+, Composer 2, Node.js 22.12+ or 24, npm. MariaDB uses PHP's
`pdo_mysql` extension; local development can use `pdo_sqlite` with SQLite.

1. Run `composer install` and `npm ci`.
2. Create .env from .env.example and configure APP_URL, the database and local
   settings (APP_ENV=local, APP_DEBUG=true, SESSION_SECURE_COOKIE=false for HTTP).
3. Run `php artisan key:generate` once for a new installation.
4. Run `php artisan migrate`, then `npm run build`.
5. Run `php artisan serve` and open http://127.0.0.1:8000.

The current workspace already has a local SQLite database and a generated key.
For a new SQLite setup, create database/database.sqlite and set DB_CONNECTION=sqlite
and DB_DATABASE to its absolute path. Production configuration uses MariaDB.

For frontend hot reload, run `npm run dev` in a second terminal after the first
build. The production build also refreshes the pre-rendered HTML: rebuild before
reviewing production output or deploying. In Vite development mode React mounts
the page directly so changes do not hydrate against an outdated HTML snapshot.

## Edit

See [the folder guide](docs/project-structure.md) for the frontend/backend layout
and an explanation of the support files outside this application.

- Homepage: resources/js/frontend/pages/home/HomePage.jsx
- Other public pages: resources/js/frontend/pages/inside/InsidePage.jsx
- Products, services and page registry: resources/js/frontend/data/site.js
- Components: resources/js/frontend/components
- Company content: resources/js/frontend/data/company.js
- Translations: resources/js/frontend/data/translations.json
- Global styles: resources/css/frontend/app.css
- Page view: resources/views/frontend/pages/home.blade.php
- Inner-page view: resources/views/frontend/pages/inside.blade.php
- Shared layout: resources/views/frontend/layouts/app.blade.php
- Metadata and assets: resources/views/frontend/partials/head.blade.php
- Enquiry endpoint: app/Http/Controllers/Frontend/EnquiryController.php
- Database schema: database/migrations

React is retained for interaction fidelity. Laravel owns requests, sessions,
validation and database writes. The Blade HTML snapshot is built from the same
components, so production visitors receive readable content before JavaScript.
No client-side router or continuous SSR service is required.

## Checks

`npm run build`, `npm run lint`, `php artisan test`, `composer validate`.

See [Hostinger deployment](docs/hostinger-deployment.md) for the required generated
artifacts, PHP/MariaDB configuration and document-root setup. Enquiries are stored;
an authenticated admin dashboard is included; notification emails remain a future feature.

The original Next.js source was archived at
D:/Fibro/workspace-support/backups/fibro-nextjs-before-laravel before migration. That folder is not deployed.
