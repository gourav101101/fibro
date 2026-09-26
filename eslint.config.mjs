import js from '@eslint/js';
import globals from 'globals';
export default [
 { ignores: ['vendor/**','node_modules/**','public/**','.next/**','.build/**','src/**'] },
 { ...js.configs.recommended, files: ['resources/js/**/*.{js,jsx}','scripts/*.mjs','vite.config.js'], languageOptions: { globals: { ...globals.browser,...globals.node }, parserOptions: { ecmaFeatures: { jsx: true } } }, rules: { 'no-unused-vars':'off', 'no-empty':['error',{allowEmptyCatch:true}] } }
];
