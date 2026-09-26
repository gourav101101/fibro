import { renderToString } from 'react-dom/server';
import SitePage from './SitePage';
export { pages } from './data/site';
export function render(pageId='home') { return renderToString(<SitePage pageId={pageId}/>); }
