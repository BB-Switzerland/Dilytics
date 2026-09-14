<script setup>
const props = defineProps({
  to: { type: Number, required: true },
  ms: { type: Number, default: 1500 },
})

const el = ref(null)
// The server renders the real figure, so a crawler, a link preview or a visitor
// without JavaScript never reads "0". It is only zeroed once the tween that
// counts it back up is in hand.
const shown = ref(props.to)

useGsap(({ gsap }) => {
  shown.value = 0
  const box = { n: 0 }
  gsap.to(box, {
    n: props.to,
    duration: props.ms / 1000,
    ease: 'power2.out',
    snap: { n: 1 },
    onUpdate: () => (shown.value = box.n),
    onComplete: () => (shown.value = props.to),
    scrollTrigger: { trigger: el.value, start: 'top 88%', once: true },
  })
}, el)
</script>

<template>
  <span ref="el">{{ shown }}</span>
</template>
