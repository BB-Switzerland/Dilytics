<script setup>
// Reads the engine's scroll state, so the bar is on the same smoothed value as
// everything else rather than a raw window.scrollY of its own.
const { scroll } = useMotion()
</script>

<template>
  <div class="bar" aria-hidden="true">
    <span :style="{ transform: `scaleX(${scroll.progress})` }" />
  </div>
</template>

<style scoped>
.bar { position: fixed; inset: 0 0 auto; height: 2px; z-index: 120; pointer-events: none }
.bar span { display: block; height: 100%; background: var(--red); transform-origin: 0 50%;
  transform: scaleX(0) }
</style>
