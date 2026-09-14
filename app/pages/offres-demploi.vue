<script setup>
import { CONTACT } from '~/content/site'
import { img } from '~/utils/img'

useHead({ title: "Offres d'emploi · Dilytics, fiduciaire à Genève" })

// PLACEHOLDER: sample postings, for the design only. The live site currently
// shows no open position. Replace with real openings before going live, or
// empty the array: the page falls back to its own "no position" state.
const offers = [
  {
    t: 'Comptable confirmé·e',
    p: '80 à 100 %',
    l: 'Petit-Lancy, Genève',
    d: "Portefeuille de mandats PME, de la saisie au bouclement. Vous êtes autonome sur un cycle complet et vous aimez le contact client.",
  },
  {
    t: 'Fiscaliste',
    p: '60 à 100 %',
    l: 'Petit-Lancy, Genève',
    d: "Déclarations de personnes physiques et morales, réclamations, conseil ponctuel. Une bonne connaissance du droit genevois est attendue.",
  },
  {
    t: 'Apprenti·e employé·e de commerce',
    p: '100 %',
    l: 'Petit-Lancy, Genève',
    d: "Formation complète en fiduciaire, encadrée par l'équipe. Rentrée en août.",
  },
]

// "Ce que nous offrons", verbatim from the careers page.
const perks = [
  { t: 'Formation continue', d: 'Nous prenons en charge vos formations pour vous permettre d’évoluer et de grandir avec nous.' },
  { t: 'Horaires flexibles', d: 'Adaptés à vos besoins, pour un meilleur équilibre entre vie professionnelle et personnelle.' },
  { t: 'Autonomie et responsabilité', d: 'Prenez en main vos projets et contribuez activement au succès de l’entreprise.' },
  { t: 'Équipe pluridisciplinaire', d: 'Collaborez avec des experts de divers domaines pour enrichir vos compétences.' },
  { t: 'Environnement digitalisé', d: 'Travaillez avec une diversité de logiciels comptables pour vous familiariser avec les outils de demain.' },
  { t: 'Confort au travail', d: 'Profitez de boissons gratuites au bureau et d’un cadre agréable.' },
  { t: 'Événements d’entreprise', d: 'Participez à des moments de convivialité et de partage avec toute l’équipe.' },
]
</script>

<template>
  <article>
    <section class="op wrap">
      <nav class="crumb"><NuxtLink to="/">Accueil</NuxtLink><span>·</span><span class="cur">Carrière</span></nav>
      <div class="og">
        <div>
          <Head3 :lines="['Rejoignez Dilytics', 'et donnez un élan', 'à votre carrière.']" :accent="2" />
          <p class="body ld" v-rv:22="'up'">
            Chez Dilytics, nous sommes une équipe passionnée, innovante et résolument tournée
            vers l'avenir, qui valorise ses collaborateurs autant que ses clients.
          </p>
        </div>
        <div class="shot opic" v-rv:6="'zoom'"><img :src="img('duo')" alt="" /><PhotoNote id="duo" /></div>
      </div>
    </section>

    <section class="bay">
      <div class="wrap">
        <h2 class="d2 hd" v-rv="'up'">Postes ouverts.</h2>

        <p v-if="!offers.length" class="body none" v-rv:6="'up'">
          Aucun poste n'est ouvert actuellement. Si vous êtes passionné·e, prêt·e à relever des
          défis et souhaitez faire carrière au sein d'une entreprise qui valorise ses
          collaborateurs, écrivez-nous.
        </p>

        <ul v-else class="of">
          <li v-for="(o, i) in offers" :key="o.t" v-rv:[i*7]="'up'">
            <div class="oi">
              <h3 class="t1">{{ o.t }}</h3>
              <p class="sm">{{ o.d }}</p>
            </div>
            <span class="xs">{{ o.p }}</span>
            <span class="xs">{{ o.l }}</span>
            <a :href="`mailto:${CONTACT.mail}?subject=${encodeURIComponent('Candidature : ' + o.t)}`" class="cta cta-line cta-sm">
              <span>Postuler</span><Ar />
            </a>
          </li>
        </ul>
      </div>
    </section>

    <section class="pb">
      <div class="wrap">
        <h2 class="d3 ph">Travailler ici</h2>
        <ul class="pk">
          <li v-for="(p, i) in perks" :key="p.t" v-rv:[i*6]="'up'">
            <h3 class="t2">{{ p.t }}</h3>
            <p class="sm">{{ p.d }}</p>
          </li>
        </ul>
      </div>
    </section>

    <SiteCta
      :title="['Candidature', 'spontanée ?']"
      text="Si vous êtes passionné·e, prêt·e à relever des défis et souhaitez faire carrière au sein d'une entreprise qui valorise ses collaborateurs, écrivez-nous."
      :action="{ label: 'Nous écrire', to: '/contact' }"
    />
  </article>
</template>

<style scoped>
.op { padding-top: calc(var(--nav-h) + clamp(26px, 4vw, 56px)) }
.crumb { display: flex; gap: 10px; align-items: center; font-size: .8rem; color: var(--faint); margin-bottom: clamp(20px, 2.6vw, 34px) }
.crumb a:hover { color: var(--red) }
.cur { color: var(--ink); font-weight: 560 }
.og { display: grid; grid-template-columns: minmax(0, 1.12fr) minmax(0, .88fr); gap: clamp(24px, 3.6vw, 64px); align-items: end }
.ld { margin-top: 22px; max-width: 46ch }
.opic { aspect-ratio: 4 / 3 }
.none { max-width: 54ch }

.hd { margin-bottom: clamp(24px, 3vw, 40px) }
.of { list-style: none; margin: 0; padding: 0 }
.of li { display: grid; grid-template-columns: 1fr 110px 170px auto; gap: 20px; align-items: center;
  padding-block: 26px; border-top: 1px solid var(--line) }
.of li:last-child { border-bottom: 1px solid var(--line) }
.oi p { margin-top: 8px; max-width: 54ch }

.pb { background: var(--sand); padding-block: clamp(44px, 5vw, 88px) }
.ph { margin-bottom: clamp(24px, 3vw, 40px) }
.pk { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(4, 1fr); gap: clamp(16px, 2vw, 34px) }
.pk li { padding-top: 18px; border-top: 2px solid var(--red) }
.pk p { margin-top: 9px }

@media (max-width: 1000px) {
  .og { grid-template-columns: 1fr }
  .of li { grid-template-columns: 1fr; gap: 12px; justify-items: start }
  .pk { grid-template-columns: repeat(2, 1fr) }
}
@media (max-width: 560px) { .pk { grid-template-columns: 1fr } }
</style>
