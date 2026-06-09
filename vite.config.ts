import { defineConfig } from 'vite';

export default defineConfig({
  server: {
    port: 3000,
    host: '0.0.0.0',
    hmr: false,
    watch: null,
  },
  build: {
    outDir: 'dist',
    rollupOptions: {
      input: {
        main: 'index.html',
        chiSiamo: 'chi-siamo.html',
        servizi: 'servizi.html',
        contatti: 'contatti.html',
        prodottoTulipani: 'prodotto-tulipani.html',
      }
    }
  }
});
