import tailwindcss from '@tailwindcss/vite';
import { defineConfig } from 'vite';

export default defineConfig(({ command }) => {
    const isBuild = command === 'build';

    return {
        base: isBuild ? '/wp-content/themes/wataco-theme/dist/' : '/',
        server: {
            port: 3000,
            cors: true,
            origin: 'http://localhost:8000',
        },
        build: {
            manifest: true,
            outDir: 'dist',
            emptyOutDir: true,
            sourcemap: false,
            minify: 'esbuild',
            cssMinify: true,
            target: 'es2019',
            reportCompressedSize: false,
            rollupOptions: {
                input: [
                    'resources/css/app.css',
                    'resources/js/app.js',
                    'resources/css/editor-style.css',
                ],
                output: {
                    entryFileNames: 'assets/[name]-[hash].js',
                    chunkFileNames: 'assets/[name]-[hash].js',
                    assetFileNames: 'assets/[name]-[hash][extname]',
                },
            }
        },
        esbuild: {
            legalComments: 'none',
        },
        plugins: [
            tailwindcss(),
        ],
    }
});