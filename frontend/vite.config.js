import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    proxy: {
      // In development, route /data requests to the Laravel backend /storage/menus directory
      '/data': {
        target: 'http://127.0.0.1:8000',
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/data/, '/storage/menus'),
      },
      // Proxy storage files locally to bypass CORS when using react-pdf without Cloudinary
      '/storage': {
        target: 'http://127.0.0.1:8000',
        changeOrigin: true,
      }
    }
  }
})
