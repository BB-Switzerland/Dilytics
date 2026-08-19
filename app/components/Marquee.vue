<script setup>
// An endless band of what the cabinet actually does. It runs on its own, but
// the scroll bends it: flick down and it races ahead, scroll back up and it
// turns around. That reaction is the whole point — it makes the page feel like
// one physical object rather than a stack of boxes.
const props = defineProps({
  items: { type: Array, required: true },
  seconds: { type: Number, default: 46 },
})

const root = ref(null)
const m = useMotion()
let ctx = null
let unhook = null

onMounted(() => {
  if (m.reduce || !m.gsap) return
  const { gsap } = m

  ctx = gsap.context(() => {
    const loop = gsap.to('.run', {
      xPercent: -50,
      ease: 'none',
      duration: props.seconds,
      repeat: -1,
    })

    let cur = 1
    const follow = () => {
      const want = (m.scroll.dir === -1 ? -1 : 1) * (1 + Math.min(Math.abs(m.scroll.velocity) / 9, 3.6))
      cur += (want - cur) * 0.07
      loop.timeScale(cur)
    }
    gsap.ticker.add(follow)
    unhook = () => gsap.ticker.remove(follow)
  }, root.value)
})

onBeforeUnmount(() => {
  unhook?.()
  ctx?.revert()
})
</script>

<template>
  <div ref="root" class="mq" aria-hidden="true">
    <div class="run">
      <span v-for="(t, i) in [...props.items, ...props.items]" :key="i" class="it">
        {{ t }}
        <svg class="sep" viewBox="8320.86 6471.35 14590.54 3681.25" aria-hidden="true">
          <path d="M8320.86,7130.28L22911.4,6471.35L15581.6,10152.6L18136.9,7767.6L8320.86,7130.28ZM19413.7,7415.73L19093.1,7415.73L19093.1,7095.16L18818.3,7095.16L18818.3,7415.73L18497.8,7415.73L18497.8,7690.5L18818.3,7690.5L18818.3,8011.05L19093.1,8011.05L19093.1,7690.5L19413.7,7690.5L19413.7,7415.73Z" />
        </svg>
      </span>
    </div>
  </div>
</template>

<style scoped>
.mq { overflow: hidden; padding-block: clamp(18px, 2vw, 30px);
  border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);
  -webkit-mask-image: linear-gradient(90deg, transparent, #000 7%, #000 93%, transparent);
  mask-image: linear-gradient(90deg, transparent, #000 7%, #000 93%, transparent) }
.run { display: flex; width: max-content; will-change: transform }
.it { display: inline-flex; align-items: center; white-space: nowrap;
  font-size: clamp(1.5rem, 2.6vw, 2.6rem); font-weight: 780; letter-spacing: -.034em;
  color: var(--ink) }
/* the house mark, sized off the type it sits between */
.sep { flex: none; display: block; height: .3em; width: 1.19em;
  margin: 0 clamp(20px, 2.2vw, 38px); fill: var(--red) }
</style>
