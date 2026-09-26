import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import { fileURLToPath } from 'node:url';
export default defineConfig({
  plugins: [laravel({ input: ['resources/js/frontend/app.jsx'], refresh: true }), react()],
  resolve: { alias: { '@': fileURLToPath(new URL('./resources/js/frontend', import.meta.url)) } },
  css: { modules: { generateScopedName: 'fibro_[name]_[local]' } },
});
