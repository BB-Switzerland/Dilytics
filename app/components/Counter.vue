<script setup>
const props = defineProps({
  to: { type: Number, required: true },
  ms: { type: Number, default: 1500 },
})

const el = ref(null)
const shown = ref(0)
const m = useMotion()

onMounted(() => {
  if (m.reduce || !m.gsap) shown.value = props.to
})

useGsap(({ gsap }) => {
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
