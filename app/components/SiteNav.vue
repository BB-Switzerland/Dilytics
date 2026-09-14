<script setup>
import { MENU } from '~/content/nav'
import { CONTACT } from '~/content/site'
import { img } from '~/utils/img'

const route = useRoute()
const open = ref(null)
const drawer = ref(false)
const acc = ref(null)
let timer = null

const panel = computed(() => MENU.find((m) => m.label === open.value) || null)
const panelIndex = computed(() => MENU.findIndex((m) => m.label === open.value))

// The bar frosts over as soon as the page moves, and steps out of the way while
// the reader is going down; it comes straight back on the first upward flick.
const { scroll } = useMotion()
const stuck = computed(() => scroll.y > 10)
const gone = computed(
  () => scroll.y > 340 && scroll.dir === 1 && !open.value && !drawer.value,
)
// The home hero is a dark photograph. While the bar still sits on it, before
// the frosted background fades in, the wordmark and the links go light, or
// they would be ink on navy.
const over = computed(
  () => route.path === '/' && !stuck.value && !open.value && !drawer.value,
)

/* sliding underline under the open trigger */
const bar = ref(null)
const mark = reactive({ x: 0, w: 0, on: false })

function place() {
  const el = bar.value
  if (!el || panelIndex.value < 0) return (mark.on = false)
  const btn = el.children[panelIndex.value]
  if (!btn) return (mark.on = false)
  mark.x = btn.offsetLeft
  mark.w = btn.offsetWidth
  mark.on = true
}

const show = (label) => {
  clearTimeout(timer)
  open.value = label
  nextTick(place)
}
const hide = () => {
  timer = setTimeout(() => {
    open.value = null
    mark.on = false
  }, 140)
}
const shut = () => {
  clearTimeout(timer)
  open.value = null
  mark.on = false
  drawer.value = false
}

function onKey(e) {
  if (e.key === 'Escape') shut()
}

watch(drawer, (v) => {
  document.body.style.overflow = v ? 'hidden' : ''
})
watch(() => route.fullPath, shut)

onMounted(() => window.addEventListener('keydown', onKey))
onBeforeUnmount(() => {
  window.removeEventListener('keydown', onKey)
  document.body.style.overflow = ''
})
</script>

<template>
  <header class="nv" :class="{ stuck: stuck || open, dr: drawer, gone, over }" @mouseleave="hide">
    <div class="bar band-lead">
      <NuxtLink to="/" class="brand" aria-label="Dilytics, accueil"><Logo /></NuxtLink>

      <nav ref="bar" class="mid" aria-label="Navigation principale">
        <!-- The trigger is the family page itself: hovering opens the panel,
             clicking goes to the parent page. -->
        <NuxtLink
          v-for="m in MENU"
          :key="m.label"
          :to="m.to"
          class="tg"
          :class="{ on: open === m.label }"
          :aria-expanded="open === m.label"
          @mouseenter="show(m.label)"
          @focus="show(m.label)"
          @click="shut()"
        >
          {{ m.label }}
        </NuxtLink>
        <NuxtLink to="/contact" class="tg flat" @mouseenter="hide">Contact</NuxtLink>
        <span class="mark" :class="{ on: mark.on }"
          :style="{ transform: `translateX(${mark.x}px) scaleX(${mark.w})` }" />
      </nav>

      <div class="end">
        <a :href="CONTACT.phoneHref" class="tel">{{ CONTACT.phone }}</a>
        <a :href="CONTACT.booking" target="_blank" rel="noopener" class="cta cta-red cta-sm"><span>Rendez-vous</span><Ar /></a>
        <button class="bg" :aria-expanded="drawer" aria-label="Menu" @click="drawer = !drawer"><i /><i /></button>
      </div>
    </div>

    <div class="mega" :class="{ on: !!panel }" @mouseenter="show(open)">
      <div v-if="panel" :key="panel.label" class="mg band-lead">
        <div class="zone intro">
          <h2 class="d3">{{ panel.label }}</h2>
          <p class="sm">{{ panel.blurb }}</p>
          <NuxtLink :to="panel.to" class="lnk" @click="shut">
            Voir les {{ panel.items.length }} prestations<Ar />
          </NuxtLink>
        </div>

        <ul class="zone links">
          <li v-for="(it, i) in panel.items" :key="it.to" :style="{ '--i': i }">
            <NuxtLink :to="it.to" @click="shut">
              <span class="nm">{{ it.label }}</span>
              <Ar />
            </NuxtLink>
          </li>
        </ul>

        <div class="zone aside">
          <div class="shot pic"><img :src="img(panel.img)" alt="" /><PhotoNote :id="panel.img" compact /></div>
          <p class="xs">Une question avant de choisir ?</p>
          <a :href="CONTACT.phoneHref" class="ph">{{ CONTACT.phone }}</a>
        </div>
      </div>
    </div>
  </header>

  <div class="drw" :class="{ on: drawer }">
    <div class="di">
      <div v-for="m in MENU" :key="m.label">
        <button class="gt" :aria-expanded="acc === m.label" @click="acc = acc === m.label ? null : m.label">
          {{ m.label }}<i :class="{ on: acc === m.label }" />
        </button>
        <div class="gb" :class="{ on: acc === m.label }">
          <div class="gl">
            <NuxtLink :to="m.to" class="top-link" @click="shut">
              Vue d'ensemble<Ar />
            </NuxtLink>
            <NuxtLink v-for="it in m.items" :key="it.to" :to="it.to" @click="shut">{{ it.label }}</NuxtLink>
          </div>
        </div>
      </div>
      <NuxtLink to="/contact" class="gt" @click="shut">Contact</NuxtLink>
      <div class="df">
        <a :href="CONTACT.phoneHref" class="d2 dt">{{ CONTACT.phone }}</a>
        <a :href="CONTACT.booking" target="_blank" rel="noopener" class="cta cta-red" @click="shut">
          <span>Prendre rendez-vous</span><Ar />
        </a>
      </div>
    </div>
  </div>
</template>

<style scoped>
.nv { position: fixed; inset: 0 0 auto; z-index: 100;
  transition: transform .55s var(--e) }
.nv.gone { transform: translateY(-102%) }

/* over the dark hero */
.nv.over .brand { color: var(--paper) }
.nv.over .tg { color: rgba(244, 242, 238, .74) }
.nv.over .tg:hover, .nv.over .tg.on { color: var(--paper) }
.nv.over .tel { color: var(--paper) }
.nv.over .tel:hover { color: var(--red) }
.nv.over .bg i { background: var(--paper) }
.nv.over .bg { border-color: rgba(244, 242, 238, .34) }
.nv::before {
  content: ''; position: absolute; inset: 0; background: rgba(246, 245, 242, .9);
  backdrop-filter: blur(22px) saturate(1.8); -webkit-backdrop-filter: blur(22px) saturate(1.8);
  opacity: 0; transition: opacity .4s var(--e);
}
.nv.stuck::before { opacity: 1 }
.bar { height: var(--nav-h); display: flex; align-items: center; gap: 24px; position: relative }
.brand { width: 116px; flex: none; color: var(--ink) }

.mid { display: flex; align-items: center; margin-left: auto; position: relative; align-self: stretch }
.tg {
  display: flex; align-items: center; padding: 0 clamp(10px, 1vw, 15px); height: 100%;
  font-size: .875rem; font-weight: 570; letter-spacing: -.012em; white-space: nowrap;
  color: var(--muted); transition: color .3s var(--e);
}
.tg:hover, .tg.on { color: var(--ink) }
.flat.router-link-active { color: var(--red) }
/* one pixel wide, scaled to the trigger: the slide and the resize both run on
   the compositor instead of re-laying out the bar every frame */
.mark {
  position: absolute; left: 0; bottom: 0; width: 1px; height: 2px; background: var(--red);
  transform-origin: 0 50%; opacity: 0; transition: transform .5s var(--e), opacity .3s var(--e);
}
.mark.on { opacity: 1 }

.end { display: flex; align-items: center; gap: 16px; flex: none }
.tel { font-size: .85rem; font-weight: 570; white-space: nowrap; transition: color .3s }
.tel:hover { color: var(--red) }
.bg { display: none; width: 42px; height: 42px; border-radius: 50%; flex-direction: column;
  align-items: center; justify-content: center; gap: 5px; border: 1px solid var(--line) }
.bg i { width: 15px; height: 1.6px; background: var(--ink); transition: .35s var(--e) }
.dr .bg i:first-child { transform: translateY(3.3px) rotate(45deg) }
.dr .bg i:last-child { transform: translateY(-3.3px) rotate(-45deg) }

/* ---- mega panel */
.mega {
  position: absolute; top: 100%; left: 0; right: 0; background: var(--paper);
  border-bottom: 1px solid var(--line);
  clip-path: inset(0 0 100% 0); opacity: 0; pointer-events: none;
  transition: clip-path .5s var(--e), opacity .28s var(--e);
}
.mega.on { clip-path: inset(0 0 0 0); opacity: 1; pointer-events: auto }
.mg { display: grid; grid-template-columns: 260px minmax(0, 1fr) 232px;
  gap: clamp(26px, 3.6vw, 64px); padding-block: 30px 36px; align-items: start }

.intro .d3 { font-size: clamp(1.4rem, 1.8vw, 1.75rem); margin-bottom: 12px }
.intro .sm { max-width: 27ch; margin-bottom: 16px }
.intro .lnk { color: var(--red) }

/* One label per row, nothing else. The second line used to repeat the label,
   which is what made this panel unreadable. */
.links { list-style: none; margin: 0; padding: 0; column-gap: clamp(24px, 3vw, 56px);
  columns: 2; column-fill: balance }
.links li { opacity: 0; transform: translateY(9px); break-inside: avoid }
.mega.on .links li { animation: mgin .45s var(--e) forwards; animation-delay: calc(var(--i) * 26ms + 60ms) }
@keyframes mgin { to { opacity: 1; transform: none } }
.links a { display: flex; align-items: center; justify-content: space-between; gap: 16px;
  padding: 12px 0; border-bottom: 1px solid var(--hair); transition: color .3s var(--e) }
.nm { font-size: 1rem; font-weight: 600; letter-spacing: -.018em;
  transition: transform .35s var(--e) }
.links :deep(.ar) { flex: none; color: var(--red);
  opacity: 0; transform: translateX(-5px); transition: .35s var(--e) }
.links a:hover { color: var(--red) }
.links a:hover .nm { transform: translateX(5px) }
.links a:hover :deep(.ar) { opacity: 1; transform: none }

.aside .pic { aspect-ratio: 4 / 3; border-radius: 12px; margin-bottom: 14px }
.aside .xs { margin-bottom: 5px }
.ph { font-size: 1.05rem; font-weight: 740; letter-spacing: -.03em; color: var(--red) }

/* ---- mobile drawer */
.drw { position: fixed; inset: var(--nav-h) 0 0; z-index: 99; background: var(--paper);
  clip-path: inset(0 0 100% 0); transition: clip-path .6s var(--e); overflow-y: auto; visibility: hidden }
.drw.on { clip-path: inset(0 0 0 0); visibility: visible }
.di { padding: 6px var(--pad) 44px; display: flex; flex-direction: column }
.gt { display: flex; align-items: center; justify-content: space-between; width: 100%; text-align: left;
  padding: 18px 0; font-size: 1.3rem; font-weight: 780; letter-spacing: -.032em;
  border-bottom: 1px solid var(--hair) }
.gt i { width: 11px; height: 11px; position: relative; flex: none }
.gt i::before, .gt i::after { content: ''; position: absolute; inset: 50% 0 auto; height: 1.6px;
  background: var(--ink); transition: transform .35s var(--e) }
.gt i::after { transform: rotate(90deg) }
.gt i.on::after { transform: rotate(0) }
.gb { display: grid; grid-template-rows: 0fr; transition: grid-template-rows .45s var(--e) }
.gb.on { grid-template-rows: 1fr }
.gl { overflow: hidden; display: flex; flex-direction: column }
.gb a { padding: 10px 0 10px 16px; font-size: .95rem; color: var(--muted) }
.gb a:first-child { padding-top: 14px }
.gb a:last-child { padding-bottom: 16px }
.top-link { display: inline-flex; align-items: center; gap: 8px; color: var(--red) !important;
  font-weight: 620 }
.df { margin-top: 34px; display: flex; flex-direction: column; gap: 16px; align-items: flex-start }
.dt { color: var(--red) }

@media (max-width: 1180px) { .tel { display: none } }
@media (max-width: 1080px) {
  .mid, .mega { display: none }
  .bg { display: flex }
  .end { margin-left: auto }
}
@media (min-width: 1081px) { .drw { display: none } }
@media (max-width: 700px) { .mg { grid-template-columns: 1fr } }
@media (prefers-reduced-motion: reduce) {
  .mega.on .links li { animation: none; opacity: 1; transform: none }
}
</style>
