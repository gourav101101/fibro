# International contact and language support

Implemented 12 September 2026.

- WhatsApp uses the user-confirmed +91 99252 39699 (`https://wa.me/919925239699`) with a draft greeting. Following the link opens WhatsApp; no message is sent automatically.
- A persistent footer link and a floating shortcut share the contact configuration. The floating shortcut is hidden while the hero or footer is visible, avoiding duplicate footer actions and overlap with the hero story controls.
- The user confirmed no official social profiles exist and explicitly requested platform homepages. Footer links point to LinkedIn, Instagram and Facebook homepages under a platform-links label; they do not claim to be Fibro accounts. Replace these in `resources/js/frontend/data/company.js` when company profiles are available.
- The language selector offers English, Hindi and French. Translations are bundled locally in `resources/js/frontend/data/translations.json`; no third-party translation widget processes visitor content.
- Text is localised through the React render tree, including dialogs and accessibility labels. Component state, element IDs, focus references and interaction callbacks are preserved. `Localized` does not mutate the browser DOM or translate URLs.
- The choice persists in local storage, with English server rendering and a client preference restored after hydration. If storage is unavailable, switching still works for the current session.
- The document language updates with the selection. Hindi uses Noto Sans Devanagari. Company names, postal contact details and material abbreviations are retained. The enquiry form is translated and stores the selected language with the submitted requirements. An email link remains available as an alternative.
- These are language views of the homepage, not separate indexed locale URLs. Dedicated locale routes, translated metadata and hreflang can be added if multilingual search indexing becomes a requirement.
- Translation wording was authored for this implementation. A company terminology/editorial review is appropriate before a multilingual public launch.

Maintenance: add English source strings and corresponding French/Hindi entries together. Exact text is the dictionary key; missing translations fall back to English. When adding a new self-rendering component, wrap its returned content in `Localized` as the existing homepage components do. The form submits to Laravel; no third-party service receives enquiries.
