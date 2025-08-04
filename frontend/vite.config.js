import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [vue()],
    server: {
        port: 8080,
        proxy: {
            '/api': {
                target: 'http://backend',
                changeOrigin: true,
                secure: false,
            },
            '/sanctum': {
                target: 'http://backend',
                changeOrigin: true,
                secure: false,
            },
        },
    },
})
