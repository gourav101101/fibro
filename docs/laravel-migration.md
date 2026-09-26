# Laravel migration verification

Completed 12 September 2026. GIMS was used for framework structure only. No hospital
records, credentials, application controllers, branding or database files were copied.
Its initial Composer dependency baseline was subsequently updated to patched releases.

## Architecture

- Laravel 13.31 / PHP 8.3+ owns routing, sessions, request validation and persistence.
- The Blade document contains pre-rendered English homepage HTML generated at build
  time. React hydrates the existing components for the same interaction behaviour.
- Vite replaces Next.js builds. Responsive WebP images replace the Next image endpoint.
- There is no Next.js dependency or production Node.js process.
- Marketing content remains source-based. Future admin editing/database-driven page
  content will need additional implementation; a database alone does not create a CMS.
- Enquiries now submit to Laravel and are stored. Automatic notification emails and
  an admin inbox are not implemented. The public email and WhatsApp links remain.

## Verified

- Production asset build and frontend lint pass.
- Composer metadata validates. npm and Composer audits report no advisories at the
  time of the migration.
- Earlier backend verification passed on SQLite and a separate MySQL-compatible server;
  the production deployment target is MariaDB through Laravel's `mariadb` connection:
  initial HTML, stored project/sample context and language, invalid input/consent,
  bounds, honeypot, request throttling and absence of a public enquiry listing.
- Real browser tests at 1920, 1440, 390 and 320 pixels verify layout and dialog fit.
- All three hero stories, six application tabs, material details and layer controls
  work. Native scrolling and existing focus/keyboard behaviour are retained.
- Language selection, keyboard navigation, outside dismissal and French/Hindi
  persistence work. New enquiry labels and feedback are translated.
- A real browser submission was persisted to the local database; test rows were
  removed afterwards. Untrusted-origin requests without a CSRF token are rejected.
  Laravel 13 also accepts browser-verified same-origin requests by design.
- No broken image responses, JavaScript exceptions or console errors were found in
  the completed browser review.

## Handoff

The local preview is http://127.0.0.1:8000 and currently uses SQLite. The production
environment example uses MariaDB. Hostinger deployment and credentials have not been
configured; follow [the deployment guide](hostinger-deployment.md).

Original source backup: `D:/Fibro/workspace-support/backups/fibro-nextjs-before-laravel`.
Browser screenshots are in `D:/Fibro/workspace-support/reviews`; historical review
scripts are in `D:/Fibro/workspace-support/tools`, outside the deployment project.
