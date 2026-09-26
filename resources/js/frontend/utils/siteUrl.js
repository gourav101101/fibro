const serverBasePath = '__FIBRO_BASE_PATH__';

export function basePath() {
  if (typeof window !== 'undefined') return window.__FIBRO_BASE_PATH__ || '';
  return serverBasePath;
}

export function siteUrl(value = '/') {
  if (!value || /^(?:[a-z][a-z0-9+.-]*:|#)/i.test(value)) return value;
  const path = value.startsWith('/') ? value : `/${value}`;
  return `${basePath()}${path}` || '/';
}

export function sitePath(pathname) {
  const base = basePath();
  const path = base && pathname.startsWith(base) ? pathname.slice(base.length) : pathname;
  return path.replace(/\/$/, '') || '/';
}

export function publicImageUrl(value, directory = '') {
  if (!value || /^(?:https?:)?\/\//i.test(value)) return value;
  let path = String(value).replaceAll('\\', '/').replace(/^\/+/, '');
  path = path.replace(/^(?:images\/+)+/i, '');
  const folder = directory.replace(/^\/+|\/+$/g, '');
  if (folder && !path.startsWith(`${folder}/`)) path = `${folder}/` + path;
  return siteUrl('/images/' + path);
}
