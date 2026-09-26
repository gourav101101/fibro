import { createRoot, hydrateRoot } from 'react-dom/client';
import SitePage from './SitePage';
import '../../css/frontend/app.css';
const root = document.getElementById('fibro-app');
if (root) {
  const pageId=root.dataset.page || 'home';
  if (window.__FIBRO_CMS__) createRoot(root).render(<SitePage pageId={pageId}/>);
  else if (import.meta.env.DEV) createRoot(root).render(<SitePage pageId={pageId}/>);
  else hydrateRoot(root, <SitePage pageId={pageId}/>);
}
