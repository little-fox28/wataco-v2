import tailwindcss from '@tailwindcss/vite';
import { defineConfig } from 'vite';

export default defineConfig(({ command }) => {
    const isBuild = command === 'build';

    return {
        base: isBuild ? '/wp-content/themes/wataco_theme/dist/' : '/',
        server: {
            port: 3000,
            cors: true,
            origin: 'http://localhost:8000',
        },
        build: {
            manifest: false,
            outDir: 'dist',
            emptyOutDir: true,
            sourcemap: false,
            minify: 'esbuild',
            cssMinify: true,
            target: 'es2019',
            reportCompressedSize: false,
        },
        esbuild: {
            legalComments: 'none',
        },
        plugins: [
            tailwindcss(),
        ],
    }
});