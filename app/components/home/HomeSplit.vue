<script setup>
import { img } from '~/utils/img'

const points = [
  { t: 'bexio, intégré et enseigné', d: "Nos spécialistes sont habilités à intégrer la solution et à former votre personnel à son utilisation." },
  { t: 'Comptabilité analytique', d: "Le passage au numérique nous permet de vous proposer des outils de comptabilité analytique et de contrôle des coûts." },
  { t: 'Des outils qui simplifient', d: "Nous mettons en place des outils qui simplifient votre quotidien." },
]
</script>

<template>
  <section class="band split">
    <div class="g">
      <div class="art" v-rv="'up'">
        <div class="shot big"><img :src="img('desk')" alt="Comptabilité numérique sur bexio" v-px="20" /></div>
        <div class="surf badge">
          <p class="fig-l k">Partenaire privilégié</p>
          <p class="v">Or, bexio</p>
        </div>
      </div>

      <div class="txt">
        <h2 class="d2" v-rv="'mask'">La saisie est<br />automatisée. Le<br />conseil, jamais.</h2>
        <p class="body ld" v-rv:8="'up'">
          Le passage au numérique nous permet de mieux accompagner nos clients, et de garder
          le temps là où il change quelque chose : lire vos chiffres et vous dire quoi en faire.
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
/* The photo runs off the left edge of the page; the text keeps the page measure. */
.g { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 47ch);
  gap: clamp(28px, 4.4vw, 88px); align-items: center;
  max-width: calc(var(--w-page) + 50vw); padding-right: var(--pad) }
.art { position: relative }
.big { border-radius: 0 var(--r-lg) var(--r-lg) 0; aspect-ratio: 4 / 2.9 }
.badge { position: absolute; bottom: clamp(18px, 2.4vw, 34px); right: clamp(18px, 2.2vw, 34px);
  padding: 14px 20px }
.badge .k { margin-bottom: 5px }
.badge .v { margin: 0; font-size: 1.15rem; font-weight: 780; letter-spacing: -.03em }

.ld { margin-top: 18px }
.pts { list-style: none; margin: clamp(26px, 2.8vw, 38px) 0 0; padding: 0 }
.pts li { padding: 17px 0; border-top: 1px solid var(--line) }
.pts li:last-child { border-bottom: 1px solid var(--line) }
.pts p { margin-top: 6px }

@media (max-width: 1000px) {
  .g { grid-template-columns: 1fr; gap: 28px; padding-left: var(--pad); max-width: none }
  .big { border-radius: var(--r-lg); aspect-ratio: 16 / 10 }
}
</style>
