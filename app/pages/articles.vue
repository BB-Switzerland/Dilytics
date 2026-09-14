<script setup>
import { ARTICLES } from '~/content/site'
import { img } from '~/utils/img'

useHead({ title: 'Articles · Dilytics, fiduciaire à Genève' })

const lead = ARTICLES[0]
const rest = ARTICLES.slice(1)
</script>

<template>
  <article>
    <section class="op wrap">
      <nav class="crumb"><NuxtLink to="/">Accueil</NuxtLink><span>·</span><span class="cur">Articles</span></nav>
      <div class="og">
        <Head3 :lines="['Trouvez les conseils', 'dont vous avez besoin.']" :accent="1" />
        <p class="body" v-rv:16="'up'">
          Dilytics propose une série d'articles en lien avec la création d'entreprise et la
          fiscalité en Suisse.
        </p>
      </div>

      <NuxtLink to="/articles" class="lead" v-rv:12="'up'">
        <div class="shot lp"><img :src="img(lead.img)" alt="" /></div>
        <div class="lt">
          <span class="cat">{{ lead.kicker }}</span>
          <h2 class="d3">{{ lead.title }}</h2>
          <p class="body">{{ lead.excerpt }}</p>
          <span class="xs mt">{{ lead.date }}</span>
        </div>
      </NuxtLink>
    </section>

    <section class="bay-s">
      <div class="wrap">
        <div class="grid">
          <NuxtLink v-for="(a, i) in rest" :key="a.slug" to="/articles" class="a" v-rv:[i*8]="'up'">
            <div class="shot pic"><img :src="img(a.img)" alt="" /></div>
            <span class="cat">{{ a.kicker }}</span>
            <h3 class="t1">{{ a.title }}</h3>
            <p class="sm">{{ a.excerpt }}</p>
            <span class="xs mt">{{ a.date }}</span>
          </NuxtLink>
        </div>
      </div>
    </section>

    <SiteCta :title="['Une question', 'précise ?']" />
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
/* the article's subject, set like the home page's journal */
.cat { font-size: .78rem; font-weight: 660; color: var(--red) }

.grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: clamp(16px, 2vw, 30px) }
.a { display: flex; flex-direction: column }
.pic { aspect-ratio: 16 / 10; margin-bottom: 16px }
.a .t1 { margin: 9px 0 9px; transition: color .3s }
.a:hover .t1 { color: var(--red) }
.a p { max-width: 38ch }

@media (max-width: 960px) {
  .og, .lead { grid-template-columns: 1fr }
  .grid { grid-template-columns: 1fr; max-width: 560px }
}
</style>
