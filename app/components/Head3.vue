<!-- Display headline: each line clipped, rising into place. -->
<script setup>
const props = defineProps({
  lines: { type: Array, required: true },
  cls: { type: String, default: 'd1' },
  accent: { type: Number, default: -1 },
  as: { type: String, default: 'h1' },
  // 'load' for a headline that is already on screen, 'scroll' further down
  mode: { type: String, default: 'load' },
  delay: { type: Number, default: 0.1 },
  // set when a parent timeline claims the lines for itself
  hold: { type: Boolean, default: false },
})

const el = ref(null)
const m = useMotion()
let ctx = null

defineExpose({ el })

onMounted(() => {
  if (props.hold || m.reduce || !m.gsap) return
  // Synchronous, not deferred: the `from` has to re-establish the hidden state
  // in the same tick the pre-paint guard is dropped.
  ctx = m.gsap.context(() => {
    m.gsap.from(el.value.querySelectorAll('.ln > i'), {
      yPercent: 118,
      duration: 1.25,
      ease: 'expo.out',
      stagger: 0.085,
      delay: props.delay,
      scrollTrigger:
        props.mode === 'scroll' ? { trigger: el.value, start: 'top 86%', once: true } : undefined,
    })
  }, el.value)
})

onBeforeUnmount(() => ctx?.revert())
</script>

<template>
  <component :is="as" ref="el" :class="[cls, 'hd']" data-hd>
    <span v-for="(l, i) in lines" :key="i" class="ln">
      <i :class="{ ac: i === accent }">{{ l }}</i>
    </span>
  </component>
</template>

<style scoped>
.ln { display: block; overflow: hidden; padding-bottom: .09em; margin-bottom: -.09em }
.ln > i { display: block; font-style: normal; will-change: transform }
/* only until the engine arms — see .mo in main.css */
:global(.mo) .ln > i { transform: translateY(104%) }
.ac { color: var(--red) }
@media (prefers-reduced-motion: reduce) { :global(.mo) .ln > i { transform: none } }
</style>
