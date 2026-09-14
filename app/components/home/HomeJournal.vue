<script setup>
import { ARTICLES } from '~/content/site'
import { img } from '~/utils/img'

const lead = ARTICLES[0]
const rest = ARTICLES.slice(1)
</script>

<template>
  <section class="band">
    <div class="band-lead">
      <header class="jhd">
        <h2 class="d2" v-rv="'mask'">Ce que nous écrivons.</h2>
        <NuxtLink to="/articles" class="lnk" v-rv:8="'up'">Tous les articles<Ar /></NuxtLink>
      </header>

      <div class="g">
        <NuxtLink to="/articles" class="lead" v-rv="'up'">
          <div class="shot lp"><img :src="img(lead.img)" alt="" v-px="18" /></div>
          <div class="lt">
            <p class="cat">{{ lead.kicker }}</p>
            <h3 class="d3">{{ lead.title }}</h3>
            <p class="body">{{ lead.excerpt }}</p>
            <p class="xs meta">{{ lead.date }}</p>
          </div>
        </NuxtLink>

        <div class="side">
          <NuxtLink v-for="(a, i) in rest" :key="a.slug" to="/articles" class="row" v-rv:[8+i*7]="'up'">
            <div class="shot rp"><img :src="img(a.img)" alt="" v-px="12" /></div>
            <div>
              <p class="cat">{{ a.kicker }}</p>
              <h3 class="t2">{{ a.title }}</h3>
              <p class="xs meta">{{ a.date }}</p>
            </div>
          </NuxtLink>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.jhd { display: flex; align-items: baseline; justify-content: space-between; gap: 24px;
  flex-wrap: wrap; margin-bottom: clamp(24px, 2.8vw, 42px) }
.g { display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(0, .75fr);
  gap: clamp(22px, 3vw, 56px); align-items: start }

.lead { display: grid; gap: 20px }
.lp { border-radius: var(--r); aspect-ratio: 16 / 8.4 }
.lt .d3 { margin: 10px 0 12px; transition: color .3s var(--e) }
.lead:hover .d3 { color: var(--red) }
.cat { margin: 0; font-size: .78rem; font-weight: 660; color: var(--red) }
.meta { margin-top: 14px }

.side { display: flex; flex-direction: column }
.row { display: grid; grid-template-columns: 120px 1fr; gap: 18px; align-items: start;
  padding: 20px 0; border-top: 1px solid var(--line) }
.side .row:last-child { border-bottom: 1px solid var(--line) }
.rp { border-radius: 8px; aspect-ratio: 4 / 3 }
.row .t2 { margin: 8px 0 0; transition: color .3s var(--e) }
.row:hover .t2 { color: var(--red) }
.row .meta { margin-top: 10px }

@media (max-width: 1000px) {
  .g { grid-template-columns: 1fr }
  .row { grid-template-columns: 96px 1fr; gap: 14px }
}
@media (max-width: 480px) { .row { grid-template-columns: 1fr } .rp { aspect-ratio: 16 / 9 } }
</style>
