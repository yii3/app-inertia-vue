import { fileURLToPath, URL } from 'node:url'
import vue from '@vitejs/plugin-vue'
import { defineConfig } from 'vite'

export default defineConfig(({ command }) => ({
    base: command === 'build' ? '/build/' : '/',
    plugins: [vue()],
    publicDir: false,
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
        },
    },
    build: {
        emptyOutDir: true,
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: fileURLToPath(new URL('./resources/js/app.ts', import.meta.url)),
        },
    },
    server: {
        host: '127.0.0.1',
        port: 5173,
        strictPort: true,
    },
}))
