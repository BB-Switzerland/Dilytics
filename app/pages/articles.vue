<script setup>
import { ARTICLES } from '~/content/site'
import { img } from '~/utils/img'

useHead({ title: 'Articles · Dilytics, fiduciaire à Genève' })

const lead = ARTICLES[0]
const rest = ARTICLES.slice(1)
// the recurring subjects of the articles actually published
const topics = ['TVA', "Création d'entreprise", 'Start-up', 'bexio', 'Fiscalité', 'Rentabilité']
</script>

<template>
  <article>
    <section class="op wrap">
      <nav class="crumb"><NuxtLink to="/">Accueil</NuxtLink><span>·</span><span class="cur">Articles</span></nav>
      <div class="og">
        <Head3 :lines="['Nos analyses,', 'sans jargon.']" :accent="1" />
        <p class="body" v-rv:16="'up'">
          Trouvez les conseils dont vous avez besoin. Dilytics propose une série d'articles
          en lien avec la création d'entreprise et la fiscalité en Suisse.
        </p>
      </div>

      <NuxtLink to="/articles" class="lead" v-rv:12="'up'">
        <div class="shot lp"><img :src="img(lead.img)" alt="" /></div>
        <div class="lt">
          <span class="idx">{{ lead.kicker }}</span>
          <h2 class="d3">{{ lead.title }}</h2>
          <p class="body">{{ lead.excerpt }}</p>
          <span class="xs mt">{{ lead.date }}</span>
        </div>
      </NuxtLink>
    </section>

    <section class="bay-s">
      <div class="wrap">
        <ul class="topics">
          <li v-for="(t, i) in topics" :key="t" v-rv:[i*4]="'up'">{{ t }}</li>
        </ul>
        <div class="grid">
          <NuxtLink v-for="(a, i) in rest" :key="a.slug" to="/articles" class="a" v-rv:[i*8]="'up'">
            <div class="shot pic"><img :src="img(a.img)" alt="" /></div>
            <span class="idx">{{ a.kicker }}</span>
            <h3 class="t1">{{ a.title }}</h3>
            <p class="sm">{{ a.excerpt }}</p>
            <span class="xs mt">{{ a.date }}</span>
          </NuxtLink>
          <div class="soon" v-rv:16="'up'">
            <h3 class="t1">La suite arrive</h3>
            <p class="sm">Nous publions une analyse par mois. Laissez-nous votre adresse et vous la recevrez avant tout le monde.</p>
            <NuxtLink to="/contact" class="lnk">S'inscrire<Ar /></NuxtLink>
          </div>
        </div>
      </div>
    </section>

    <SiteCta :title="['Une question', 'précise ?']" text="Les articles ne remplacent pas un avis sur votre situation. Quinze minutes suffisent souvent à trancher." />
  </article>
</template>

<style scoped>
.op { padding-top: calc(var(--nav-h) + clamp(26px, 4vw, 56px)) }
.crumb { display: flex; gap: 10px; align-items: center; font-size: .8rem; color: var(--faint); margin-bottom: clamp(20px, 2.6vw, 34px) }
.crumb a:hover { color: var(--red) }
.cur { color: var(--ink); font-weight: 560 }
.og { display: grid; grid-template-columns: 1.2fr minmax(0, 46ch); gap: clamp(20px, 3.4vw, 64px);
  align-items: end; margin-bottom: clamp(28px, 3.4vw, 48px) }

.lead { display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(0, .95fr); gap: clamp(20px, 3vw, 48px); align-items: center }
.lp { aspect-ratio: 16 / 10 }
.lt .d3 { margin: 12px 0 14px; transition: color .3s }
.lead:hover .d3 { color: var(--red) }
.mt { display: block; margin-top: 16px }

.topics { list-style: none; margin: 0 0 28px; padding: 0; display: flex; flex-wrap: wrap; gap: 8px }
.topics li { font-size: .82rem; font-weight: 550; padding: 8px 16px; border: 1px solid var(--line); border-radius: 99px; transition: .3s var(--e) }
.topics li:hover { background: var(--ink); border-color: var(--ink); color: var(--paper) }

.grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: clamp(16px, 2vw, 30px) }
.a { display: flex; flex-direction: column }
.pic { aspect-ratio: 16 / 10; margin-bottom: 16px }
.a .t1 { margin: 9px 0 9px; transition: color .3s }
.a:hover .t1 { color: var(--red) }
.a p { max-width: 38ch }
.soon { background: var(--sand); border-radius: var(--r); padding: clamp(20px, 2.4vw, 32px);
  display: flex; flex-direction: column; align-items: flex-start; justify-content: center; gap: 12px }
.soon p { max-width: 32ch }

@media (max-width: 960px) {
  .og, .lead { grid-template-columns: 1fr }
  .grid { grid-template-columns: 1fr; max-width: 560px }
}
</style>
