import tailwindcss from '@tailwindcss/vite'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  future: {
    compatibilityVersion: 4,
  },

  ssr: false,

  css: ['~/assets/css/main.css'],

  vite: {
    plugins: [
      tailwindcss(),
    ],
  },

  runtimeConfig: {
    public: {
      apiBase: (globalThis as any).process?.env?.NUXT_PUBLIC_API_BASE || 'http://localhost:8000/api'
    }
  },

  compatibilityDate: '2025-07-15',
  devtools: { enabled: true }
})