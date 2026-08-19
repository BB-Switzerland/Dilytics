<script setup>
// Numbered rows with a navy fill on hover and the neighbours dimmed. Shared by
// the home and the family pages so the interaction is identical wherever
// prestations are listed. No image preview: the photography is illustrative,
// and tying a stock photo to a named prestation reads as a promise it isn't.
defineProps({
  items: { type: Array, required: true }, // [{ t, d, to }]
})

const hot = ref(-1)
</script>

<template>
  <div class="stage" @pointerleave="hot = -1">
    <ol class="rows" :class="{ live: hot > -1 }" v-stagger>
      <li
        v-for="(r, i) in items"
        :key="r.to"
        :class="{ on: hot === i }"
        @pointerenter="hot = i"
        @focusin="hot = i"
        @focusout="hot = -1"
      >
        <NuxtLink :to="r.to">
          <span class="fill" aria-hidden="true" />
          <span class="nb">{{ String(i + 1).padStart(2, '0') }}</span>
          <span class="nm">{{ r.t }}</span>
          <span class="dc">{{ r.d }}</span>
          <span class="arw" aria-hidden="true">
            <svg viewBox="0 0 46 12" fill="none">
              <path class="shaft" d="M0 6h38" stroke="currentColor" stroke-width="1.6" />
              <path class="head" d="M34 1.5 39.5 6 34 10.5" stroke="currentColor"
                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
        </NuxtLink>
      </li>
    </ol>
  </div>
</template>

<style scoped>
.rows { list-style: none; margin: 0; padding: 0 }
.rows.live li:not(.on) a { opacity: .38 }

.rows a {
  display: grid; grid-template-columns: 58px minmax(0, .95fr) minmax(0, 1.05fr) 60px;
  align-items: center; gap: clamp(14px, 2.4vw, 40px);
  padding: clamp(20px, 2.2vw, 32px) clamp(12px, 1.6vw, 26px);
  border-top: 1px solid var(--line); position: relative;
  color: var(--ink); transition: color .4s var(--e), opacity .45s var(--e);
}
.rows li:last-child a { border-bottom: 1px solid var(--line) }

/* a real element, not a negative z-index pseudo, so the fill always paints */
.fill { position: absolute; inset: 0; background: var(--ink);
  transform: scaleY(0); transform-origin: 50% 100%; transition: transform .55s var(--e) }
.rows li.on .fill { transform: scaleY(1) }
.nb, .nm, .dc, .arw { position: relative }
.rows li.on a { color: var(--paper) }

.nb { font-size: .78rem; font-weight: 700; letter-spacing: .06em; color: var(--red);
  transition: transform .5s var(--e) }
.rows li.on .nb { transform: translateY(-2px) }

.nm { font-size: clamp(1.15rem, 1.75vw, 1.62rem); font-weight: 740; letter-spacing: -.028em;
  line-height: 1.1; transition: transform .55s var(--e) }
.rows li.on .nm { transform: translateX(10px) }

.dc { font-size: .88rem; line-height: 1.45; color: var(--muted); max-width: 46ch;
  transition: color .4s var(--e), transform .55s var(--e) }
.rows li.on .dc { color: rgba(244, 242, 238, .76); transform: translateX(6px) }

.arw { justify-self: end; color: var(--red); display: block; width: 46px }
.arw svg { display: block; width: 46px; height: 12px; overflow: visible }
.shaft { transform: scaleX(.34); transform-origin: 0 50%; transition: transform .55s var(--e) }
.head { transform: translateX(-14px); transition: transform .55s var(--e) }
.rows li.on .arw { color: var(--paper) }
.rows li.on .shaft { transform: scaleX(1) }
.rows li.on .head { transform: none }

@media (max-width: 900px) {
  .rows.live li:not(.on) a { opacity: 1 }
  .rows a { grid-template-columns: 40px 1fr; gap: 6px 14px; padding: 18px 0 }
  .dc { grid-column: 2; max-width: none }
  .arw, .fill { display: none }
  .rows li.on a { color: var(--ink) }
  .rows li.on .nm, .rows li.on .dc { transform: none }
  .rows li.on .dc { color: var(--muted) }
}
</style>
