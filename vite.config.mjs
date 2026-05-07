import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

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
            rollupOptions: {
                // WordPress theme doesn't need entry files - Tailwind CSS plugin handles everything
                input: 'style.css',
                output: {
                    entryFileNames: 'assets/[name]-[hash].js',
                    chunkFileNames: 'assets/[name]-[hash].js',
                    assetFileNames: 'assets/[name]-[hash][extname]',
                },
            },
        },
        esbuild: {
            legalComments: 'none',
        },
        plugins: [
            tailwindcss(),
        ],
    }
});
