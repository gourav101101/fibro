import HomePage from './pages/home/HomePage';
import InsidePage from './pages/inside/InsidePage';
import { pages } from './data/site';
export default function SitePage({ pageId='home' }) {
  const page=pages.find(item=>item.id===pageId);
  if (!page) throw new Error('Unknown page: '+pageId);
  return page.type==='home'?<HomePage/>:<InsidePage page={page}/>;
}
