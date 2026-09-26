# Project structure

Open **D:/Fibro/fibro-laminates** in your editor. It is the Laravel project root
and the only folder needed to develop this website.

```text
app/
  Http/
    Controllers/
      Frontend/             Public pages, sitemap and enquiry controllers
    Requests/
      Frontend/             Server-side enquiry validation
  Models/                   Database models
  Providers/                Application configuration
bootstrap/                  Laravel startup and framework caches
config/                     Laravel configuration
database/migrations/        Versioned database schema
public/                     Web document root, images and built assets
resources/
  views/
    frontend/
      layouts/app.blade.php Shared public HTML layout
      pages/home.blade.php  Homepage view
      pages/inside.blade.php Product, service and company page view
      partials/head.blade.php Metadata, fonts and asset tags
      generated/            Build-generated public-page HTML; do not hand-edit
    backend/                Reserved for a future authenticated admin area
  js/frontend/
    pages/home/             Editable React homepage and its styles
    pages/inside/           Shared inner-page layout and styles
    components/             Header, footer, hero, forms and other interactions
    data/                   Company content, page registry and translations
    app.jsx                 Browser entry point
    render.jsx              Build-time HTML rendering
  css/frontend/             Global website styles
  data/pages.json           Generated Laravel page registry; do not hand-edit
routes/
  web.php                   Web route entry point
  frontend.php              Public website route definitions
scripts/build.mjs           Asset, responsive image and HTML build
storage/                    Runtime logs, sessions and temporary build files
tests/Feature/              Public pages, sitemap, 404 and enquiry tests
docs/                       Company brief, structure and deployment instructions
```

`frontend` and `backend` are useful team naming conventions, not mandatory Laravel
folder names. Backend **views** mean authenticated admin screens; PHP controllers and models
still belong under `app`, not in the views directory. The admin dashboard and login
are available at `/admin` and `/admin/login`.
has been added merely to populate that folder.

Laravel handles HTTP requests and MariaDB storage. The existing React components
remain responsible for the public website's interactions. Splitting folders does
not convert React components into Blade components; the Blade layout includes
HTML generated from those components during `npm run build`.

Keep `vendor` and `node_modules`: they are installed PHP and JavaScript dependencies,
not duplicate application code. `composer.json`, `composer.lock`, `package.json`,
`package-lock.json`, `artisan`, `vite.config.js` and the test/lint configuration are
normal project files. Keep `.env` private; commit only `.env.example`.

## Files outside the application

`D:/Fibro/workspace-support` groups the files left from design review and migration:

- `backups`: the original Next.js source and recovery copies.
- `reviews`: screenshots and reference-site captures.
- `tools`: historical review/migration scripts and document extraction tools.
- `documents`: extracted company-document review material.
- `caches`: browser profiles, package caches and isolated database test files.
- `logs`: historical local preview/test logs.

These are not part of Laravel and must not be uploaded to Hostinger. Historical
scripts may contain their original absolute paths; treat them as archived evidence,
not current development commands. Use the project's README for current commands.
