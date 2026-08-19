import { reactive } from 'vue'

// Server half of the motion engine. It emits the same attributes the client
// directives would set, so the markup arrives already tagged, and it hands
// components an inert scroll state so nothing has to guard for `undefined`.
export default defineNuxtPlugin((nuxtApp) => {
  const app = nuxtApp.vueApp

  app.directive('rv', {
    getSSRProps(binding) {
      const mode = binding.value || 'up'
      if (mode === 'flag') return {}
      const props = { 'data-rv': mode }
      if (binding.arg) props['data-rvd'] = String(binding.arg)
      return props
    },
  })

  app.directive('stagger', { getSSRProps: () => ({}) })
  app.directive('mag', { getSSRProps: () => ({}) })
  app.directive('lit', { getSSRProps: () => ({}) })
  app.directive('tilt', { getSSRProps: () => ({}) })
  app.directive('px', {
    getSSRProps: (binding) => ({ 'data-px': String(binding.value ?? 14) }),
  })

  return {
    provide: {
      motion: {
        gsap: null,
        ScrollTrigger: null,
        lenis: null,
        scroll: reactive({ y: 0, dir: 1, velocity: 0, progress: 0 }),
        reduce: false,
        ctx: () => ({ revert() {} }),
      },
    },
  }
})
