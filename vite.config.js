import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  server: {
    // host: '0.0.0.0', // biar bisa diakses dari HP
    host: '127.0.0.1',
    port: 5173,
    hmr: {
      // host: '192.168.1.9',
      host: 'localhost',
      protocol: 'ws',
    },
  },
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
})
