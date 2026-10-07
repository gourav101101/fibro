FIBRO HOSTINGER DEPLOYMENT

This ZIP contains production PHP dependencies and all built frontend assets.
Do not run npm or a Vite server on Hostinger.

1. Back up the existing hosting files and database. Preserve the existing
   production .env, APP_KEY and uploaded images when updating an existing site.
2. Extract this ZIP in the DOMAIN DIRECTORY ABOVE public_html, so you have:
     domain-directory/fibro-app/artisan
     domain-directory/public_html/index.php
     domain-directory/public_html/build/manifest.json
   Do not extract the entire ZIP inside public_html. Only public_html's contents
   belong in the website document root. Enable hidden files in File Manager.
3. Remove any old development marker named hot from public_html.
4. Keep the production .env in fibro-app. For a new site, copy .env.example to
   .env there, then set the real HTTPS APP_URL and MariaDB credentials.
   Use PHP 8.3 or newer. Keep APP_ENV=production and APP_DEBUG=false.
   APP_PUBLIC_PATH can be omitted with this exact sibling-folder layout.
   If already set, it MUST contain the hosting absolute path to public_html,
   never a Windows path or the old application's public directory.
5. In the hosting terminal, change directory to fibro-app and run:
     php artisan config:clear
     php artisan view:clear
     php artisan package:discover
   For a NEW installation only:
     php artisan key:generate
     php artisan migrate --force
     php artisan db:seed --class=ContentSeeder --force
   For an existing installation, preserve its APP_KEY and database; run required
   migrations after backup, and do not reseed existing content unnecessarily.
   For this website update, apply the targeted category additions and corrections:
     php artisan db:seed --class=ProductCategoryUpdateSeeder --force
   This preserves custom product edits and adds the workwear/blackout categories.
   Finally run:
     php artisan optimize
6. For a new administrator, temporarily fill ADMIN_SEED_NAME, ADMIN_SEED_EMAIL
   and ADMIN_SEED_PASSWORD in .env, then run:
     php artisan config:clear
     php artisan db:seed --class=AdminUserSeeder --force
   Remove ADMIN_SEED_PASSWORD from .env and run php artisan optimize again.
7. Ensure PHP can write storage, bootstrap/cache and public_html/images/uploads
   plus public_html/images/credentials/uploads. Check the homepage, animations,
   mobile menu, languages, contact form and /admin/login.

If no hosting terminal is available, ask hosting support to run the above
commands. Do not create a public web route that runs Artisan commands.

VITE TROUBLESHOOTING
- Manifest not found: confirm public_html/build/manifest.json exists, and check
  APP_PUBLIC_PATH and the folder layout above. Clear cached configuration.
- Requests to localhost:5173: remove public_html/hot and refresh the page.
- Missing CSS/JS: upload the entire build directory from the same ZIP, not just
  manifest.json. Clear hosting/CDN/browser caches after replacing assets.

Do not upload the old whole-project ZIP: it contains local .env/database files
and browser cache. No local credentials, database, sessions or logs are included
in this new package. It does not contain your production database content.
