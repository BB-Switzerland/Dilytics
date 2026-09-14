<!-- Content the site is still waiting for: a photograph, a testimonial, a
     figure. Marked in the same red as the photo notes, so a review shows at a
     glance everything that has to come from Dilytics. -->
<script setup>
defineProps({
  label: { type: String, required: true },
  hint: { type: String, default: '' },
  // a picture slot: keeps a photographic ratio and shows a camera
  photo: { type: Boolean, default: false },
  // on a navy band
  dark: { type: Boolean, default: false },
})
</script>

<template>
  <div class="pd" :class="{ ph: photo, dk: dark }">
    <svg v-if="photo" class="cam" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
      stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M3 8.5A1.5 1.5 0 0 1 4.5 7h2.3l1.6-2.2h7.2L17.2 7h2.3A1.5 1.5 0 0 1 21 8.5v9a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 17.5v-9Z" />
      <circle cx="12" cy="13" r="3.6" />
    </svg>
    <strong>{{ label }}</strong>
    <span v-if="hint">{{ hint }}</span>
  </div>
</template>

<style scoped>
.pd { display: flex; flex-direction: column; align-items: flex-start; justify-content: center; gap: 6px;
  height: 100%; padding: clamp(18px, 2vw, 28px); border: 2px dashed var(--red);
  border-radius: var(--r); background: rgba(214, 29, 65, .045); font-size: .88rem; line-height: 1.45 }
.pd strong { color: var(--red); font-size: .92rem; font-weight: 720; letter-spacing: -.01em }
.pd span { color: var(--muted); max-width: 46ch }
.ph { aspect-ratio: 4 / 3; height: auto; align-items: center; text-align: center; background: var(--sand) }
.ph span { max-width: 30ch }
.cam { width: 30px; height: 30px; color: var(--red); margin-bottom: 4px }
.dk { background: rgba(214, 29, 65, .14) }
.dk strong { color: var(--paper) }
.dk span { color: rgba(244, 242, 238, .74) }
</style>
