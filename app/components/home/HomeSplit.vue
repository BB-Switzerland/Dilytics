<script setup>
import { img } from '~/utils/img'

// What sets the cabinet apart from a classic fiduciary, each point in its own
// published words: the About page, the team's statements, the family pages.
const points = [
  {
    t: 'Des interlocuteurs qui prennent le temps',
    d: 'Nos conseillers prennent le temps de comprendre votre situation afin de vous proposer des solutions personnalisées.',
  },
  {
    t: 'Un esprit entrepreneurial',
    d: 'Nous réunissons des experts passés par différents secteurs, capables de proposer des solutions innovantes à une clientèle exigeante.',
  },
  {
    t: "L'automatisation au service du conseil",
    d: "Partenaire Platine de bexio, nous allions rigueur comptable et innovation, notamment grâce à l'automatisation et à l'intelligence artificielle.",
  },
  {
    t: 'Une fiduciaire 360',
    d: 'Comptabilité, fiscalité, salaires, révision, création : si vous avez des demandes particulières, nos prestations sont entièrement personnalisables.',
  },
]
</script>

<template>
  <section class="band split">
    <div class="g">
      <div class="art" v-rv="'up'">
        <div class="shot big"><img :src="img('desk')" alt="" v-px="20" /></div>
        <div class="surf badge">
          <img :src="img('bexio_platine')" alt="Badge bexio Partenaire Platine" class="bx" />
          <p class="fig-l k">Partenaire<br />bexio</p>
        </div>
      </div>

      <div class="txt">
        <h2 class="d2" v-rv="'mask'">Ce qui nous distingue d'une fiduciaire classique.</h2>
        <p class="body ld" v-rv:8="'up'">
          Les fiduciaires classiques n'accompagnent pas leurs clients dans les problématiques du
          quotidien. Dilytics ne commet pas cette erreur.
        </p>

        <ul class="pts">
          <li v-for="(p, i) in points" :key="p.t" v-rv:[14+i*7]="'up'">
            <h3 class="t2">{{ p.t }}</h3>
            <p class="sm">{{ p.d }}</p>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>

<style scoped>
/* The photo runs off the left edge of the page and the text takes the other
   half: wide enough for the heading to hold on two lines and for the points to
   sit two by two, so the section stays about as tall as the photograph. */
.g { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
  gap: clamp(28px, 4.4vw, 80px); align-items: center;
  max-width: calc(var(--w-page) + 50vw); padding-right: var(--pad) }
.art { position: relative }
.big { border-radius: 0 var(--r-lg) var(--r-lg) 0; aspect-ratio: 4 / 2.9 }
.badge { position: absolute; bottom: clamp(18px, 2.4vw, 34px); right: clamp(18px, 2.2vw, 34px);
  display: flex; align-items: center; gap: 14px; padding: 12px 20px 12px 12px }
/* bexio's own badge, cropped to its edges; the card gives it the breathing room */
.bx { width: auto; height: clamp(62px, 5.6vw, 84px) }
.badge .k { margin: 0; line-height: 1.3 }

.ld { margin-top: 16px; max-width: 58ch }
.pts { list-style: none; margin: clamp(22px, 2.4vw, 32px) 0 0; padding: 0;
  display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); column-gap: clamp(20px, 2.4vw, 40px) }
.pts li { padding: 15px 0 6px; border-top: 1px solid var(--line) }
.pts p { margin-top: 6px }

@media (max-width: 1000px) {
  .g { grid-template-columns: 1fr; gap: 28px; padding-left: var(--pad); max-width: none }
  .big { border-radius: var(--r-lg); aspect-ratio: 16 / 10 }
}
@media (max-width: 620px) {
  .pts { grid-template-columns: 1fr }
  .pts li { padding-bottom: 14px }
}
</style>
