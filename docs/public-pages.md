# Public website pages

The current site has 21 public pages: Home; About; Products and nine application
detail pages; Services and four service detail pages; Materials & Technology;
Contact; Environment & Sustainability; Manufacturing & Quality. Blog, News, Careers and Downloads are
excluded by client instruction.

Current homepage/company content takes precedence over the older scope PDF.
Product detail pages explain applications and enquiry considerations without
inventing specifications, certifications or availability.
Company photographs and the additional mobile number are pending; existing
illustrative imagery remains in use.

The homepage and both responsibility pages display the four client-supplied GRS,
ISO 9001:2015, Sedex and ISPF logos under “Certifications & industry programmes”.
These are logo assets, not certificate documents. No certificate identifiers,
validity dates, audit results, membership status or universal certified-product
claims have been invented. Buyers are directed to the team for relevant scope
and documentation. Process copy describes dry hot-melt coating specifically;
it does not claim factory-wide zero water use, carbon neutrality or quantified savings.

Edit `resources/js/frontend/data/responsibility.js` for the two page definitions,
process topics and logo labels. Shared rendering is in
`components/Responsibility/Responsibility.jsx`; original supplied logos are in
`public/images/credentials/` and must be included in hosting uploads.

Edit `resources/js/frontend/data/site.js` for page definitions and detail content;
edit `pages/inside/InsidePage.jsx` for the shared page layout. Maintain
French and Hindi keys in `data/translations.json`. Language selection is a browser
preference; separate indexed locale URLs are not implemented.

Run `npm run build` after edits. It generates all Blade snapshots, the page
registry, browser assets and responsive images. See hostinger-deployment.md for
the four artifacts that must be deployed together. The September 12 RAR predates
these pages and must be rebuilt before use as a current hosting package.

Contact and contextual enquiry forms use the existing validated Laravel endpoint
and database storage. An admin CMS, file uploads
and enquiry notification emails are not part of this public-page implementation.
