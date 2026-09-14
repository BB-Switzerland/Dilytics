<!-- A visible marker on a stock picture that a real photograph must replace.
     Driven by content/photos.js, and renders nothing once NOTES is off. The
     parent must be positioned, which every `.shot` already is. -->
<script setup>
import { NOTES, PHOTOS } from '~/content/photos'

const props = defineProps({
  id: { type: String, required: true },
  // a small thumbnail: the label alone, without the brief
  compact: { type: Boolean, default: false },
  // an article illustration, taken from the published article, not shot
  article: { type: Boolean, default: false },
  // 'bl' bottom left, 'tl' top left, 'hero' top right under the navigation
  at: { type: String, default: 'bl' },
  frame: { type: Boolean, default: true },
})

const entry = computed(() => (NOTES ? PHOTOS[props.id] : null))
const label = computed(() =>
  props.compact ? 'À remplacer' : props.article ? 'Image à remplacer' : 'Photo réelle à fournir',
)
const brief = computed(() =>
  props.article ? "Reprendre l'image de l'article publié sur dilytics.ch." : entry.value?.brief,
)
</script>

<template>
  <template v-if="entry">
    <span v-if="frame" class="pnf" aria-hidden="true" />
    <span class="pn" :class="[at, { c: compact }]">
      <strong>{{ label }}</strong>
      <span v-if="!compact">{{ brief }}</span>
    </span>
  </template>
</template>

<style scoped>
.pnf { position: absolute; inset: 8px; z-index: 3; pointer-events: none;
  border: 2px dashed var(--red); border-radius: 8px }
.pn { position: absolute; z-index: 4; left: 14px; bottom: 14px; max-width: min(340px, calc(100% - 28px));
  display: flex; flex-direction: column; gap: 3px; padding: 9px 12px 10px; border-radius: 6px;
  background: var(--red); color: #fff; font-size: .74rem; font-weight: 500; line-height: 1.35;
  letter-spacing: 0; text-align: left; pointer-events: none;
  box-shadow: 0 12px 26px -14px rgba(0, 25, 52, .55) }
.pn strong { font-size: .8rem; font-weight: 720 }
.pn.tl { top: 14px; bottom: auto }
.pn.hero { top: calc(var(--nav-h) + 18px); right: var(--pad); left: auto; bottom: auto }
.pn.c { left: 6px; bottom: 6px; padding: 4px 7px; max-width: calc(100% - 12px) }
.pn.c strong { font-size: .66rem }
</style>
