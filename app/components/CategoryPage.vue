<script setup>
import { CAT_BY_KEY, CATEGORIES } from '~/content/categories'
import { byGroup } from '~/content/services'
import { PITCH, H1 } from '~/content/offers'
import { CONTACT } from '~/content/site'
import { img } from '~/utils/img'

const props = defineProps({ group: { type: String, required: true } })

const c = computed(() => CAT_BY_KEY[props.group])
const services = computed(() => byGroup(props.group))

// Rows for the shared list: the one-line pitch reads better here than
// the full lede, which belongs on the detail page.
const rows = computed(() =>
  services.value.map((s) => ({
    t: H1[s.slug] || s.title,
    d: PITCH[s.slug] || s.lede,
    to: s.slug,
  })),
)

const others = computed(() => CATEGORIES.filter((x) => x.key !== props.group))

useHead(() => ({
  title: `${c.value.title} · Dilytics, fiduciaire à Genève`,
  meta: [{ name: 'description', content: c.value.lede.slice(0, 155) }],
}))
</script>

<template>
  <article :key="c.key">
    <!-- opening, in the same language as the detail pages -->
    <section class="open">
      <div class="band-lead">
        <nav class="crumb" aria-label="Fil d'ariane">
          <NuxtLink to="/">Accueil</NuxtLink>
          <span aria-hidden="true">·</span>
          <span class="here">{{ c.title }}</span>
        </nav>

        <div class="og">
          <div class="ot">
            <h1 class="d1" v-rv="'mask'">{{ c.title }}</h1>
            <p class="pitch" v-rv:8="'up'">{{ c.pitch }}</p>
            <p class="body ld" v-rv:14="'up'">{{ c.lede }}</p>
            <div class="acts" v-rv:20="'up'">
              <a :href="CONTACT.booking" target="_blank" rel="noopener" class="cta cta-ink">
                <span>Réserver un entretien</span><Ar />
              </a>
              <a :href="CONTACT.phoneHref" class="lnk tel">{{ CONTACT.phone }}<Ar /></a>
            </div>
          </div>

          <div class="shot opic" v-rv:6="'zoom'">
            <img :src="img(c.img)" :alt="c.title" v-px="20" />
            <PhotoNote :id="c.img" />
          </div>
        </div>

        <ul class="facts">
          <li v-for="(f, i) in c.facts" :key="f.k" v-rv:[i*6]="'up'">
            <span class="fig fv">{{ f.v }}</span>
            <p class="fig-l">{{ f.k }}</p>
          </li>
        </ul>
      </div>
    </section>

    <!-- the prestations of this family, with the same interaction as the home -->
    <section class="band">
      <div class="band-lead">
        <header class="hd">
          <h2 class="d2" v-rv="'mask'">{{ services.length }} prestations<br />dans cette famille.</h2>
          <p class="body" v-rv:8="'up'">
            Chaque page dit ce qui est inclus, comment cela se passe, et ce que les gens
            nous demandent le plus souvent.
          </p>
        </header>

        <ServiceList :items="rows" />
      </div>
    </section>

    <!-- what an engagement covers, as a list rather than a floating card -->
    <section class="band">
      <div class="band-lead cov">
        <div class="cov-l">
          <h2 class="d3" v-rv="'mask'">{{ c.promise }}</h2>
          <NuxtLink to="/contact" class="lnk cl" v-rv:8="'up'">Demander un devis<Ar /></NuxtLink>
        </div>

        <ul class="cov-r">
          <li v-for="(b, i) in c.bullets" :key="b" v-rv:[i*5]="'up'">
            <svg width="15" height="15" viewBox="0 0 14 14" fill="none" aria-hidden="true">
              <path d="M2.5 7.5 5.5 10.5 11.5 4" stroke="currentColor" stroke-width="1.9"
                stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span>{{ b }}</span>
          </li>
        </ul>
      </div>
    </section>

    <!-- the question this family actually raises -->
    <section class="band">
      <div class="band-lead note">
        <div class="shot npic" v-rv="'zoom'">
          <img :src="img('meet')" alt="" v-px="16" />
          <PhotoNote id="meet" />
        </div>
        <div class="ntxt">
          <h2 class="d3" v-rv="'mask'">{{ c.aside.t }}</h2>
          <p class="body" v-rv:8="'up'">{{ c.aside.d }}</p>
          <div class="nacts" v-rv:12="'up'">
            <a :href="CONTACT.booking" target="_blank" rel="noopener" class="cta cta-red">
              <span>Prendre rendez-vous</span><Ar />
            </a>
            <a :href="CONTACT.phoneHref" class="lnk">{{ CONTACT.phone }}<Ar /></a>
          </div>
        </div>
      </div>
    </section>

    <!-- the two other families -->
    <section class="band">
      <div class="band-lead">
        <h2 class="d3 ohd" v-rv="'mask'">Vous cherchiez autre chose ?</h2>
        <div class="others">
          <NuxtLink v-for="(o, i) in others" :key="o.key" :to="o.slug" class="oc surf surf-h"
            v-rv:[i*6]="'up'">
            <div class="shot opic2"><img :src="img(o.img)" alt="" /><PhotoNote :id="o.img" compact /></div>
            <div class="oin">
              <h3 class="t1">{{ o.title }}</h3>
              <p class="sm">{{ o.pitch }}</p>
              <span class="ogo">Voir la famille<Ar /></span>
            </div>
          </NuxtLink>
        </div>
      </div>
    </section>

    <AskBlock />
    <SiteCta />
  </article>
</template>

<style scoped>
.open { padding-top: calc(var(--nav-h) + clamp(24px, 3.4vw, 52px)); padding-bottom: clamp(30px, 3.4vw, 52px) }
.crumb { display: flex; gap: 10px; align-items: center; font-size: .8rem; color: var(--faint);
  margin-bottom: clamp(18px, 2.4vw, 32px) }
.crumb a:hover { color: var(--red) }
.here { color: var(--ink); font-weight: 560 }

.og { display: grid; grid-template-columns: minmax(0, .96fr) minmax(0, 1.04fr);
  gap: clamp(26px, 4vw, 80px); align-items: center }
.pitch { margin: 18px 0 0; font-size: clamp(1.08rem, 1.4vw, 1.32rem); font-weight: 660;
  letter-spacing: -.022em; line-height: 1.3; color: var(--red); max-width: 34ch }
.ld { margin-top: 16px; max-width: 46ch }
.acts { display: flex; align-items: center; flex-wrap: wrap; gap: 12px 24px; margin-top: 28px }
.tel { font-size: .95rem }
.tel:hover { color: var(--red) }
.opic { aspect-ratio: 4 / 3.1; border-radius: var(--r-lg) }

.facts { list-style: none; margin: clamp(30px, 3.6vw, 56px) 0 0;
  padding: clamp(22px, 2.4vw, 32px) 0 0; border-top: 1px solid var(--line);
  display: grid; grid-template-columns: repeat(3, 1fr); gap: clamp(18px, 2.4vw, 40px) }
.facts li { display: flex; flex-direction: column; gap: 10px }
.fv { font-size: clamp(1.5rem, 2.2vw, 2.2rem) }
.facts .fig-l { max-width: 22ch }

.hd { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 44ch);
  gap: clamp(20px, 3.4vw, 68px); align-items: end; margin-bottom: clamp(24px, 2.8vw, 42px) }

/* coverage */
.cov { display: grid; grid-template-columns: minmax(0, .74fr) minmax(0, 1.26fr);
  gap: clamp(24px, 4vw, 76px); align-items: start }
.cl { margin-top: 20px; color: var(--red) }
.cov-r { list-style: none; margin: 0; padding: 0 }
.cov-r li { display: grid; grid-template-columns: 22px 1fr; gap: 14px; align-items: start;
  padding: 16px 0; border-top: 1px solid var(--hair);
  font-size: clamp(.98rem, 1.15vw, 1.1rem); line-height: 1.4 }
.cov-r li:last-child { border-bottom: 1px solid var(--hair) }
.cov-r svg { color: var(--red); margin-top: 4px }

/* note */
.note { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.08fr);
  gap: clamp(24px, 4vw, 74px); align-items: center }
.npic { aspect-ratio: 4 / 3; border-radius: var(--r-lg) }
.ntxt .body { margin-top: 16px; max-width: 48ch }
.nacts { display: flex; align-items: center; flex-wrap: wrap; gap: 14px 24px; margin-top: 26px }

/* other families */
.ohd { margin-bottom: clamp(20px, 2.4vw, 34px) }
.others { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: clamp(14px, 1.8vw, 26px) }
.oc { display: grid; grid-template-columns: 200px minmax(0, 1fr); overflow: hidden }
.opic2 { border-radius: 0; height: 100% }
.oin { padding: clamp(20px, 2vw, 30px); display: flex; flex-direction: column }
.oin .sm { margin-top: 9px; flex: 1 }
.ogo { display: inline-flex; align-items: center; gap: 8px; margin-top: 18px;
  font-size: .85rem; font-weight: 640; color: var(--red) }
.ogo :deep(.ar) { transition: transform .4s var(--e) }
.oc:hover .ogo :deep(.ar) { transform: translateX(5px) }
.oc .t1 { transition: color .3s var(--e) }
.oc:hover .t1 { color: var(--red) }

@media (max-width: 1080px) {
  .og, .cov, .note, .hd { grid-template-columns: 1fr; gap: 26px }
  .opic { aspect-ratio: 16 / 10 }
  .note .npic { order: -1 }
  .others { grid-template-columns: 1fr }
}
@media (max-width: 620px) {
  .facts { grid-template-columns: 1fr; gap: 18px }
  .oc { grid-template-columns: 1fr }
  .opic2 { aspect-ratio: 16 / 9; height: auto }
}
</style>
