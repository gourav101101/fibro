import fs from 'node:fs/promises';
import { build } from 'vite';
import sharp from 'sharp';
async function imageFiles(directory, prefix = '') {
  const files = [];
  for (const entry of await fs.readdir(directory, { withFileTypes: true })) {
    if (entry.name === 'optimized') continue;
    const relative = `${prefix}${entry.name}`;
    if (entry.isDirectory()) files.push(...await imageFiles(`${directory}/${entry.name}`, `${relative}/`));
    else files.push(relative);
  }
  return files;
}
await fs.mkdir('public/images/optimized', { recursive: true });
for (const file of await imageFiles('public/images')) {
  if (!/\.(png|jpe?g)$/i.test(file)) continue;
  for (const width of [480, 800, 1280, 1920]) {
    const output = `public/images/optimized/${file.replace(/\.[^.]+$/, '')}-${width}.webp`;
    const source = `public/images/${file}`;
    const previous = await fs.stat(output).catch(() => null);
    if (previous && previous.mtimeMs >= (await fs.stat(source)).mtimeMs) continue;
    await fs.mkdir(output.slice(0, output.lastIndexOf('/')), { recursive: true });
    await sharp(source).rotate().resize(width).webp({ quality: 84 }).toFile(output);
  }
}
await build();
await build({ build: { ssr: 'resources/js/frontend/render.jsx', outDir: 'storage/app/build', emptyOutDir: true, rollupOptions: { output: { entryFileNames: 'render.mjs' } } } });
const { render, pages } = await import('../storage/app/build/render.mjs');
await fs.mkdir('resources/views/frontend/generated', { recursive: true });
const currentViews = new Set(pages.map(page => `${page.id}.blade.php`));
for (const file of await fs.readdir('resources/views/frontend/generated')) {
  if (file.endsWith('.blade.php') && !currentViews.has(file)) {
    await fs.unlink(`resources/views/frontend/generated/${file}`);
  }
}
for (const page of pages) {
  await fs.writeFile(`resources/views/frontend/generated/${page.id}.blade.php`, render(page.id).replaceAll('__FIBRO_BASE_PATH__', "{{ rtrim(request()->getBaseUrl(), '/') }}") + '\n');
}
await fs.mkdir('resources/data',{recursive:true});
await fs.writeFile('resources/data/pages.json',JSON.stringify(pages,null,2)+'\n');
console.log(`${pages.length} Laravel pages and frontend assets built. No Node.js runtime required.`);
