export default defineNuxtConfig({
  compatibilityDate: '2025-08-01',
  devtools: { enabled: false },
  css: ['~/assets/css/main.css'],
  app: {
    head: {
      htmlAttrs: { lang: 'fr' },
      meta: [
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
        { name: 'theme-color', content: '#f6f5f2' },
      ],
      link: [
        { rel: 'icon', href: '/favicon.ico', sizes: '48x48' },
        { rel: 'icon', href: '/favicon.png', type: 'image/png', sizes: '512x512' },
        { rel: 'apple-touch-icon', href: '/apple-touch-icon.png' },
      ],
      script: [
        {
          // Holds the first screen back for the fraction of a second the motion
          // engine needs to arm, so nothing paints and then jumps. The timer is
          // the safety net: if the bundle never runs, the page shows anyway.
          innerHTML:
            "var d=document.documentElement;d.classList.add('mo');" +
            "setTimeout(function(){d.classList.remove('mo')},2200)",
          tagPosition: 'head',
        },
      ],
    },
    pageTransition: { name: 'pt', mode: 'out-in' },
  },
  // Lenis owns scrolling, including the jump to top between pages.
  vite: { server: { allowedHosts: true } },
})
