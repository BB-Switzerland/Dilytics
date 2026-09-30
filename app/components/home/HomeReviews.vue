<script setup>
import { REVIEWS, PARTNERS, DISTINCTIONS } from '~/content/site'
import { img } from '~/utils/img'

// Four reviews to a slide, laid out as a mosaic: the first of the four large.
const slides = []
for (let i = 0; i < REVIEWS.length; i += 4) slides.push(REVIEWS.slice(i, i + 4))

// Native scroll snapping moves the slides (swipe, trackpad, keyboard); the
// arrows only scroll to the previous or next snap point. On a phone each
// review is its own snap point (the slides are display: contents there).
// data-lenis-prevent-horizontal on the track leaves a sideways trackpad
// swipe to the browser: Lenis would otherwise take it for the page.
const track = ref(null)
const at = ref(0)
const count = ref(slides.length)
const stops = () => {
  const t = track.value
  const s = [...t.children]
  return s.length && getComputedStyle(s[0]).display === 'contents' ? [...t.querySelectorAll('.rv')] : s
}
// a stop's scroll position (the track's padding holds the shadows); the last
// ones may sit past the end of the track
const max = () => track.value.scrollWidth - track.value.clientWidth
const pos = (el) => Math.min(el.offsetLeft - parseFloat(getComputedStyle(track.value).paddingLeft), max())
let raf = 0
const sync = () => {
  // an arrow's glide holds the target, so a second click goes one further
  if (raf) return
  const t = track.value
  const s = stops()
  count.value = s.length
  let best = 0
  s.forEach((el, i) => { if (Math.abs(pos(el) - t.scrollLeft) < Math.abs(pos(s[best]) - t.scrollLeft)) best = i })
  at.value = t.scrollLeft >= max() - 2 ? s.length - 1 : best
}
// The arrows glide on their own clock, snapping off for the ride: a snapping
// track catches every frame of a scripted scroll, and the browsers' own
// smooth scroll stutters or jumps there.
const halt = () => {
  if (!raf) return
  cancelAnimationFrame(raf)
  raf = 0
  track.value.style.scrollSnapType = ''
}
const glide = (to) => {
  const t = track.value
  halt()
  const from = t.scrollLeft
  if (matchMedia('(prefers-reduced-motion: reduce)').matches) { t.scrollLeft = to; return }
  const t0 = performance.now()
  t.style.scrollSnapType = 'none'
  const step = (now) => {
    const k = Math.min(1, (now - t0) / 800)
    t.scrollLeft = from + (to - from) * (1 - (1 - k) ** 4)
    if (k < 1) raf = requestAnimationFrame(step)
    else { halt(); sync() }
  }
  raf = requestAnimationFrame(step)
}
const go = (d) => {
  const s = stops()
  at.value = Math.min(s.length - 1, Math.max(0, at.value + d))
  glide(pos(s[at.value]))
}
// a hand on the track takes over from a glide
const grab = (e) => { if (e.type === 'touchstart' || Math.abs(e.deltaX) > Math.abs(e.deltaY)) { halt(); sync() } }
onMounted(() => { sync(); window.addEventListener('resize', sync) })
onBeforeUnmount(() => { halt(); window.removeEventListener('resize', sync) })
</script>

<template>
  <section class="band">
    <div class="band-lead">
      <div class="top-r">
        <h2 class="d2" v-rv="'mask'">Ce que disent nos clients.</h2>
        <div class="ctl">
          <button type="button" class="prev" aria-label="Avis précédents" :disabled="at === 0" @click="go(-1)"><Ar /></button>
          <span class="sm ct" aria-live="polite">{{ at + 1 }} / {{ count }}</span>
          <button type="button" class="next" aria-label="Avis suivants" :disabled="at >= count - 1" @click="go(1)"><Ar /></button>
        </div>
      </div>

      <div ref="track" class="track" tabindex="0" aria-label="Avis clients" data-lenis-prevent-horizontal v-rv="'up'"
        @scroll.passive="sync" @wheel.passive="grab" @touchstart.passive="grab">
        <div v-for="(s, k) in slides" :key="k" class="slide" :class="'n' + s.length">
          <figure v-for="(r, i) in s" :key="r.name" class="rv surf" :class="{ big: !i }">
            <blockquote>{{ r.quote }}</blockquote>
            <figcaption>
              <span class="who">
                <span class="t2">{{ r.name }}</span>
                <span v-if="r.role || r.company" class="sm">{{ [r.role, r.company].filter(Boolean).join(', ') }}</span>
              </span>
              <img v-if="r.logo" :src="img(r.logo)" :alt="r.org" class="org" loading="lazy" />
            </figcaption>
          </figure>
        </div>
      </div>

      <h3 class="d3 pth" v-rv="'mask'">Nos partenaires.</h3>
      <ul class="logos" v-stagger>
        <li v-for="p in PARTNERS" :key="p.name">
          <img v-if="p.img" :src="img(p.img)" :alt="p.name" loading="lazy" />
          <span v-else class="t2">{{ p.name }}</span>
        </li>
      </ul>

      <ul class="marks" v-stagger>
        <li v-for="d in DISTINCTIONS" :key="d.v">
          <span class="top">
            <img v-if="d.img" :src="img(d.img)" :alt="d.alt" class="lg" />
            <span v-else class="fig mv">{{ d.v }}</span>
          </span>
          <span class="sm">{{ d.t }}</span>
        </li>
      </ul>
    </div>
  </section>
</template>

<style scoped>
.top-r { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px;
  margin-bottom: clamp(26px, 3vw, 46px) }
.ctl { display: flex; align-items: center; gap: 14px; flex: none }
.ctl button { width: 48px; height: 48px; border-radius: 50%; border: 1px solid var(--line); background: var(--white);
  color: var(--ink); display: grid; place-items: center; cursor: pointer; transition: border-color .3s, opacity .3s }
.ctl button:hover:not(:disabled) { border-color: var(--ink) }
.ctl button:disabled { opacity: .35; cursor: default }
.prev :deep(.ar) { transform: rotate(180deg) }
.ct { min-width: 3.2em; text-align: center; font-variant-numeric: tabular-nums }

/* the scroller clips what overflows it, the cards' shadow too: room for it,
   taken back by the margin; sideways as wide as the gap, so no neighbour peeks */
.track { --g: clamp(14px, 1.6vw, 24px); position: relative; display: flex; gap: var(--g); overflow-x: auto;
  padding: 0 var(--g) 44px; margin: 0 calc(var(--g) * -1) -44px; scroll-padding-inline: var(--g);
  scroll-snap-type: x mandatory; scrollbar-width: none; overscroll-behavior-x: contain }
.track::-webkit-scrollbar { display: none }
.slide { flex: 0 0 100%; scroll-snap-align: start; display: grid;
  grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr) minmax(0, 1fr); gap: clamp(14px, 1.6vw, 24px) }
.slide .big { grid-row: 1 / 3 }
.n4 > :nth-child(2), .n3 > :nth-child(n + 2), .n2 > :nth-child(2) { grid-column: 2 / 4 }
.n2 > :nth-child(2) { grid-row: 1 / 3 }

.rv { margin: 0; padding: clamp(22px, 2.2vw, 34px); display: flex; flex-direction: column;
  justify-content: space-between; gap: 22px }
blockquote { margin: 0; font-size: 1rem; font-weight: 500; line-height: 1.5; text-wrap: pretty }
.big blockquote { font-size: clamp(1.08rem, 1.4vw, 1.3rem); font-weight: 600; line-height: 1.42; letter-spacing: -.018em }
blockquote::before { content: '«\00a0'; color: var(--red) }
blockquote::after { content: '\00a0»'; color: var(--red) }
figcaption { display: flex; align-items: center; justify-content: space-between; gap: 16px;
  padding-top: 16px; border-top: 1px solid var(--line) }
.who { display: flex; flex-direction: column; gap: 3px; min-width: 0 }
/* the company's logo in the partners' register: grey, white dropped */
.org { flex: none; width: auto; height: 44px; max-width: 120px; object-fit: contain; object-position: right center;
  filter: grayscale(1); mix-blend-mode: multiply }

.pth { margin: clamp(56px, 6vw, 100px) 0 clamp(26px, 2.8vw, 42px) }
/* the partners stay in the background: no tiles, small and faded, full on hover */
.logos { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(6, minmax(0, 1fr));
  gap: clamp(32px, 3.8vw, 60px) clamp(20px, 3vw, 52px); align-items: center }
.logos li { display: flex; align-items: center; justify-content: center; height: clamp(36px, 3.2vw, 48px) }
/* one register for logos drawn in every colour: grey, and white backgrounds dropped */
.logos img { max-width: min(100%, 124px); max-height: 100%; width: auto; height: auto; object-fit: contain;
  filter: grayscale(1); mix-blend-mode: multiply; opacity: .5; transition: opacity .3s }
.logos li:hover img { opacity: .9 }
.logos .t2 { text-align: center; font-size: .82rem; line-height: 1.2; opacity: .5 }

.marks { list-style: none; margin: clamp(52px, 5.6vw, 92px) 0 0; padding: clamp(34px, 3.6vw, 56px) 0 0;
  border-top: 1px solid var(--line);
  display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: clamp(18px, 2.4vw, 40px) }
.marks li { display: flex; flex-direction: column; gap: 10px }
/* one height for every mark, so a badge and a figure share the same baseline */
.top { display: flex; align-items: flex-end; height: clamp(62px, 5.6vw, 84px) }
.lg { width: auto; height: 100% }
.mv { font-size: clamp(1.6rem, 2.4vw, 2.4rem) }

@media (max-width: 1000px) {
  .slide { grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) }
  .slide > * { grid-column: auto !important; grid-row: auto !important }
  .slide .big { grid-column: 1 / 3 !important }
  .logos { grid-template-columns: repeat(4, minmax(0, 1fr)) }
}
/* a phone: one review at a time, the next one peeking */
@media (max-width: 620px) {
  .track { align-items: flex-start }
  .slide { display: contents }
  .rv { flex: 0 0 86%; scroll-snap-align: start }
  .logos { grid-template-columns: repeat(3, minmax(0, 1fr)) }
  .marks { grid-template-columns: 1fr }
}
</style>
