<script setup>
// The four gains Dilytics asked to see spelled out, under the names it gave
// them. Each description is the cabinet's own wording, from its home, payroll,
// accounting, tax and About pages.
const items = [
  {
    ico: 'clock',
    t: 'Gain de temps',
    d: 'Nous vous libérons de vos obligations fiscales, juridiques et administratives. Concentrez-vous sur les activités qui font croître votre société.',
  },
  {
    ico: 'shield',
    t: 'Sécurisation',
    d: 'Une tenue comptable précise vous aide à respecter les exigences fiscales et légales, et à éviter pénalités et sanctions.',
  },
  {
    ico: 'chart',
    t: 'Optimisation',
    d: "Nos comptables-fiscalistes étudient votre situation et vous proposent des actions d'optimisation fiscale. La comptabilité analytique montre où réduire les coûts.",
  },
  {
    ico: 'talk',
    t: 'Accompagnement décisionnel',
    d: 'Des outils de comptabilité analytique et de contrôle des coûts pour prendre des décisions éclairées : budget, planification, tarification.',
  },
]
</script>

<template>
  <section class="band">
    <div class="band-lead">
      <header class="hd">
        <h2 class="d2" v-rv="'mask'">Un partenaire stratégique,<br />pas un simple appui comptable.</h2>
        <p class="body" v-rv:8="'up'">
          Nous voulons être un véritable partenaire stratégique pour les dirigeants, de la
          création à la transmission de leur entreprise. Voici ce que cela change concrètement.
        </p>
      </header>

      <ul v-stagger>
        <li v-for="x in items" :key="x.t">
          <span class="bi"><Ico :name="x.ico" /></span>
          <h3 class="t1">{{ x.t }}</h3>
          <p class="sm">{{ x.d }}</p>
        </li>
      </ul>
    </div>
  </section>
</template>

<style scoped>
.hd { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 46ch);
  gap: clamp(18px, 3vw, 64px); align-items: end; margin-bottom: clamp(30px, 3.6vw, 56px) }
ul { list-style: none; margin: 0; padding: clamp(26px, 3vw, 42px) 0 0; border-top: 1px solid var(--line);
  display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: clamp(22px, 3vw, 54px) }
li { display: flex; flex-direction: column }
.bi { width: 30px; height: 30px; color: var(--red); margin-bottom: 18px }
h3 { margin-bottom: 9px }
.sm { max-width: 34ch }

@media (max-width: 1000px) {
  .hd { grid-template-columns: 1fr; align-items: start; gap: 18px }
  ul { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 30px }
}
@media (max-width: 620px) { ul { grid-template-columns: 1fr; gap: 26px } }
</style>
