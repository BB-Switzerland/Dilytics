// Access to the shared engine: gsap, ScrollTrigger, the Lenis instance and a
// reactive scroll state ({ y, dir, velocity, progress }).
export function useMotion() {
  return useNuxtApp().$motion
}

// Run a GSAP context for the lifetime of the component. Everything created
// inside `fn` is scoped to `scope` and reverted on unmount, so a page can be
// left and re-entered without leaving dead triggers behind.
//
//   const root = ref(null)
//   useGsap(({ gsap }) => { gsap.from('.card', { y: 40 }) }, root)
export function useGsap(fn, scope) {
  const m = useMotion()
  let ctx = null

  let alive = true

  onMounted(() => {
    if (m.reduce || !m.gsap) return
    // One frame, so layout has settled and measurements are real.
    requestAnimationFrame(() => {
      if (!alive) return
      ctx = m.gsap.context(() => fn(m), scope?.value || undefined)
      m.ScrollTrigger.refresh()
    })
  })

  onBeforeUnmount(() => {
    alive = false
    ctx?.revert()
  })
  return () => ctx
}
