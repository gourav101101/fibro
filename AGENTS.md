# Fibro Laravel application

- This is Laravel 13 with Vite and React. Do not run Next.js commands or recreate src/app.
- Laravel serves resources/views/frontend/pages/home.blade.php and handles database writes.
- Edit homepage components in resources/js/frontend and styles in resources/css/frontend.
- Public views use frontend/layouts, frontend/pages and frontend/partials. Backend views
  are reserved for a future admin area; do not create public admin routes as placeholders.
- npm run build generates browser assets, responsive WebP images and a matching
  pre-rendered Blade partials and resources/data/pages.json. Deploy all four artifacts
  together; see docs/hostinger-deployment.md. Public page content is in data/site.js;
  shared inner-page layouts are in pages/inside/InsidePage.jsx.
- Keep the established Fibro visual design, accessible interactions, native scrolling,
  language support and company-source constraints in docs/company-content-brief.md.
- Run npm run lint, npm run build and php artisan test for changes that affect those layers.
- Never commit credentials, local databases, generated caches or enquiry data.
