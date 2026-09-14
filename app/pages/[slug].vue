<script setup>
import { BY_SLUG, SERVICES } from '~/content/services'
import { CAT_BY_KEY } from '~/content/categories'
import { PRICE, PITCH, H1 } from '~/content/offers'
import { BODY } from '~/content/bodies'
import { CONTACT } from '~/content/site'
import { img } from '~/utils/img'

const route = useRoute()

definePageMeta({
  validate: async (route) => {
    const { BY_SLUG } = await import('~/content/services')
    return !!BY_SLUG[`/${route.params.slug}/`]
  },
})

const s = computed(() => BY_SLUG[`/${route.params.slug}/`])
const parent = computed(() => CAT_BY_KEY[s.value.group])
const price = computed(() => PRICE[s.value.slug] || null)
const heading = computed(() => H1[s.value.slug] || s.value.title)
const b = computed(() => BODY[s.value.slug] || null)
const tagline = computed(() => b.value?.tagline || PITCH[s.value.slug] || s.value.lede)
const secs = computed(() => b.value?.sections || [])

// A photograph breaks the reading column after the first section, on guides
// long enough to need something to look at.
const picAfter = computed(() => (secs.value.length > 2 ? 0 : -1))

const cross = computed(() => {
  const out = [...s.value.related]
  for (const o of SERVICES) {
    if (out.length >= 4) break
    if (o.slug !== s.value.slug && !out.includes(o.slug) && o.group === s.value.group) out.push(o.slug)
  }
  for (const o of SERVICES) {
    if (out.length >= 4) break
    if (o.slug !== s.value.slug && !out.includes(o.slug)) out.push(o.slug)
  }
  return out.slice(0, 4)
})

useHead(() => ({
  title: `${heading.value} · Dilytics, fiduciaire à Genève`,
  meta: [{ name: 'description', content: tagline.value.slice(0, 155) }],
}))

const openFaq = ref(0)

/* ---------------------------------------------------------------- the guide
   A long explanation is not a grid of cards. It is an article, and an article
   is read one column at a time, so the sections run down a single measure and
   a rail on the left says, at every moment, which one you are in. */
const doc = ref(null)
const here = ref(0)
const m = useMotion()

useGsap(({ gsap, ScrollTrigger }) => {
  gsap.utils.toArray('.sec').forEach((el, i) => {
    ScrollTrigger.create({
      trigger: el,
      start: 'top 42%',
      end: 'bottom 42%',
      onToggle: (self) => {
        if (self.isActive) here.value = i
      },
    })
  })
}, doc)

function jump(i) {
  const el = document.getElementById(`sec-${i}`)
  if (!el) return
  if (m.lenis) m.lenis.scrollTo(el, { offset: -110, duration: 1.1 })
  else el.scrollIntoView({ behavior: 'smooth', block: 'start' })
}
</script>

<template>
  <article :key="s.slug">
    <!-- hero -->
    <section class="hero">
      <div class="band-lead">
        <nav class="crumb" aria-label="Fil d'ariane">
          <NuxtLink to="/">Accueil</NuxtLink>
          <span aria-hidden="true">·</span>
          <NuxtLink :to="parent.slug">{{ parent.nav }}</NuxtLink>
          <span aria-hidden="true">·</span>
          <span class="here">{{ heading }}</span>
        </nav>

        <div class="hg">
          <div>
            <h1 class="d1" v-rv="'mask'">{{ heading }}</h1>
            <p class="tag" v-rv:8="'up'">{{ tagline }}</p>
            <p class="body ld" v-rv:12="'up'">{{ b ? b.intro : s.lede }}</p>
            <div class="acts" v-rv:18="'up'">
              <a :href="CONTACT.booking" target="_blank" rel="noopener" class="cta cta-ink" v-mag>
                <span>Réserver un entretien</span><Ar />
              </a>
              <NuxtLink to="/contact" class="lnk tel">Nous écrire<Ar /></NuxtLink>
            </div>
          </div>

          <div class="shot hpic" v-rv:6="'zoom'">
            <img :src="img(s.img)" :alt="heading" v-px="16" />
            <PhotoNote :id="s.img" />
          </div>
        </div>
      </div>
    </section>

    <!-- three named benefits: the first thing a visitor should grasp -->
    <section v-if="b?.benefits" class="ben">
      <div class="band-lead">
        <ul v-stagger>
          <li v-for="x in b.benefits" :key="x.t">
            <span class="bi"><Ico :name="x.ico" /></span>
            <h2 class="t1">{{ x.t }}</h2>
            <p class="sm">{{ x.d }}</p>
          </li>
        </ul>
      </div>
    </section>

    <!-- the explanation, read as an article with a rail that keeps your place -->
    <section v-if="secs.length" class="guide">
      <div class="gwrap">
        <aside class="rail">
          <div class="stick">
            <p class="rt">Sommaire</p>
            <nav aria-label="Sommaire">
              <a v-for="(sec, i) in secs" :key="sec.t" :href="`#sec-${i}`"
                :class="{ on: here === i }" @click.prevent="jump(i)">{{ sec.t }}</a>
            </nav>

            <div class="ask">
              <p class="xs">Une question avant de vous lancer ?</p>
              <a :href="CONTACT.phoneHref" class="ph">{{ CONTACT.phone }}</a>
            </div>
          </div>
        </aside>

        <div ref="doc" class="doc">
          <template v-for="(sec, i) in secs" :key="sec.t">
            <section :id="`sec-${i}`" class="sec">
              <h2 class="sh" v-rv="'mask'">{{ sec.t }}</h2>
              <p v-for="(par, j) in sec.p" :key="j" class="p" v-rv:[j*4]="'text'">{{ par }}</p>
            </section>

            <figure v-if="i === picAfter" class="brk" v-rv="'zoom'">
              <div class="shot fpic">
                <img :src="img(parent.img)" :alt="parent.nav" v-px="18" />
                <PhotoNote :id="parent.img" />
              </div>
            </figure>
          </template>
        </div>
      </div>
    </section>

    <!-- what the engagement covers, when the service publishes a list -->
    <section v-if="b?.list" class="tint">
      <div class="band-lead lwrap">
        <h2 class="d2 lhd" v-rv="'mask'">{{ b.list.t }}</h2>
        <ul class="lst" v-stagger>
          <li v-for="it in b.list.items" :key="it">
            <span class="lk"><Ico name="check" /></span>{{ it }}
          </li>
        </ul>
      </div>
    </section>

    <PriceBlock v-if="price" :price="price" :label="heading" :offer="b?.offer || null"
      :facts="s.facts || []" />

    <!-- questions -->
    <section class="tint">
      <div class="band-lead fwrap">
        <div class="fhd">
          <h2 class="d2" v-rv="'mask'">Questions fréquentes</h2>
          <p class="sm" v-rv:8="'text'">Votre situation ne rentre dans aucune case ?
            Appelez-nous, la première conversation ne vous engage à rien.</p>
          <a :href="CONTACT.phoneHref" class="fph" v-rv:12="'text'">{{ CONTACT.phone }}</a>
        </div>
        <div class="faq" v-stagger>
          <div v-for="(f, i) in s.faq" :key="i" class="q surf" :class="{ on: openFaq === i }">
            <button :aria-expanded="openFaq === i" @click="openFaq = openFaq === i ? -1 : i">
              <span class="t2">{{ f.q }}</span><i aria-hidden="true" />
            </button>
            <div class="a"><div><p class="sm">{{ f.a }}</p></div></div>
          </div>
        </div>
      </div>
    </section>

    <CrossSell :slugs="cross" />
    <AskBlock />
    <SiteCta />
  </article>
</template>

<style scoped>
.hero { padding-top: calc(var(--nav-h) + clamp(24px, 3.4vw, 54px)); padding-bottom: clamp(30px, 3.6vw, 58px) }
.crumb { display: flex; gap: 10px; align-items: center; flex-wrap: wrap;
  font-size: .8rem; color: var(--faint); margin-bottom: clamp(18px, 2.4vw, 32px) }
.crumb a:hover { color: var(--red) }
.here { color: var(--ink); font-weight: 560 }

.hg { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, .96fr);
  gap: clamp(26px, 4.4vw, 88px); align-items: center }
.tag { margin: 18px 0 0; font-size: clamp(1.18rem, 1.62vw, 1.55rem); font-weight: 680;
  letter-spacing: -.026em; line-height: 1.24; color: var(--red); max-width: 30ch }
.ld { margin-top: 16px; max-width: 52ch }
.acts { display: flex; align-items: center; flex-wrap: wrap; gap: 12px 24px; margin-top: 28px }
.tel:hover { color: var(--red) }
.hpic { aspect-ratio: 4 / 3.2; border-radius: var(--r-lg) }

/* three benefits */
.ben { padding-bottom: clamp(38px, 4.4vw, 76px) }
.ben ul { list-style: none; margin: 0; padding: clamp(26px, 3vw, 44px) 0 0;
  border-top: 1px solid var(--line);
  display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: clamp(22px, 3.4vw, 62px) }
.ben li { display: flex; flex-direction: column }
.bi { width: 30px; height: 30px; color: var(--red); margin-bottom: 16px }
.ben h2 { margin-bottom: 8px }
.ben .sm { max-width: 34ch }

/* ---------------------------------------------------------------- the guide */
.guide { padding-block: clamp(30px, 4vw, 70px) clamp(40px, 5vw, 84px) }
/* No `align-items: start` here: it would shrink the rail to its own content
   height, leaving the sticky block no distance to travel. The rail has to span
   the whole row, the height of the article, for sticky to mean anything. */
.gwrap { max-width: 1140px; margin-inline: auto; padding-inline: var(--pad);
  display: grid; grid-template-columns: 232px minmax(0, 1fr);
  gap: clamp(36px, 6vw, 96px) }
.rail { align-self: stretch; height: 100% }

.stick { position: sticky; top: calc(var(--nav-h) + 34px) }
.rt { margin: 0 0 12px; font-size: .9rem; font-weight: 700; letter-spacing: -.015em; color: var(--ink) }
.rail nav { display: flex; flex-direction: column; align-items: flex-start; gap: 2px }
.rail a { position: relative; padding: 7px 0; font-size: .88rem; line-height: 1.35;
  font-weight: 560; color: var(--faint); transition: color .35s var(--e) }
.rail a::after { content: ''; position: absolute; left: 0; bottom: 3px; height: 1.5px; width: 100%;
  background: var(--red); transform: scaleX(0); transform-origin: 0 50%;
  transition: transform .5s var(--e) }
.rail a:hover { color: var(--ink) }
.rail a.on { color: var(--ink); font-weight: 680 }
.rail a.on::after { transform: scaleX(1) }

.ask { margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--line) }
.ask .xs { max-width: 22ch; margin-bottom: 6px }
.ph { font-size: 1.02rem; font-weight: 760; letter-spacing: -.03em; color: var(--red) }

.doc { max-width: 68ch }
.sec { padding-block: clamp(24px, 2.6vw, 38px); scroll-margin-top: calc(var(--nav-h) + 34px) }
.sec + .sec { border-top: 1px solid var(--hair) }
.sh { margin: 0 0 clamp(12px, 1.4vw, 20px); font-size: clamp(1.34rem, 1.95vw, 1.78rem);
  font-weight: 790; letter-spacing: -.032em; line-height: 1.12; text-wrap: balance }
.p { margin: 0 0 1.05em; font-size: clamp(1.02rem, 1.08vw, 1.11rem); line-height: 1.72;
  color: rgba(0, 25, 52, .8) }
.p:last-child { margin-bottom: 0 }

/* the photograph, set as a figure rather than dropped in a sidebar */
.brk { margin: 0 0 clamp(10px, 1.4vw, 18px) }
.fpic { aspect-ratio: 16 / 9; border-radius: var(--r-lg) }

/* list */
.tint { background: var(--sand); padding-block: clamp(44px, 5vw, 88px) }
.lwrap { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.2fr);
  gap: clamp(24px, 4vw, 76px); align-items: start }
.lhd { max-width: 18ch }
.lst { list-style: none; margin: 0; padding: 0; display: grid; gap: 0 }
.lst li { display: grid; grid-template-columns: 24px 1fr; gap: 14px; align-items: start;
  padding: 15px 0; border-top: 1px solid rgba(0, 25, 52, .1);
  font-size: clamp(1rem, 1.14vw, 1.1rem); line-height: 1.45 }
.lst li:last-child { border-bottom: 1px solid rgba(0, 25, 52, .1) }
.lk { width: 20px; height: 20px; color: var(--red); margin-top: 2px }

/* faq: the same two-column band as the coverage list above, so the page keeps
   one rhythm instead of dropping to a narrow centred column */
.fwrap { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.2fr);
  gap: clamp(24px, 4vw, 76px); align-items: start }
.fhd { position: sticky; top: calc(var(--nav-h) + 34px) }
.fhd .d2 { max-width: 12ch; margin-bottom: 18px }
.fhd .sm { max-width: 30ch; margin-bottom: 14px }
.fph { font-size: 1.05rem; font-weight: 760; letter-spacing: -.03em; color: var(--red) }
.faq { display: grid; gap: 10px }
.q { padding: 0 clamp(18px, 2vw, 26px) }
.q button { width: 100%; display: flex; align-items: center; justify-content: space-between;
  gap: 24px; padding: 20px 0; text-align: left; transition: color .3s var(--e) }
.q button:hover, .q.on button { color: var(--red) }
.q i { width: 13px; height: 13px; position: relative; flex: none }
.q i::before, .q i::after { content: ''; position: absolute; inset: 50% 0 auto; height: 1.6px;
  background: currentColor; transition: transform .4s var(--e) }
.q i::after { transform: rotate(90deg) }
.q.on i::after { transform: rotate(0) }
.a { display: grid; grid-template-rows: 0fr; transition: grid-template-rows .5s var(--e) }
.q.on .a { grid-template-rows: 1fr }
.a > div { overflow: hidden }
.a p { padding-bottom: 20px; max-width: 72ch }

@media (max-width: 1000px) {
  .hg, .lwrap, .fwrap { grid-template-columns: 1fr; gap: 26px }
  .fhd { position: static }
  .hpic { aspect-ratio: 16 / 10 }
  .ben ul { grid-template-columns: 1fr; gap: 26px }
  /* the rail is a reading aid; on one column the article speaks for itself */
  .gwrap { grid-template-columns: 1fr; gap: 0; max-width: 720px }
  .rail { display: none }
  .doc { max-width: none }
}
</style>
