<script setup>
import { CONTACT } from '~/content/site'

// The page says what the cabinet does and why it matters, but never what
// happens once you call. Each stage is named by its heading alone, with no
// number and no label above it. Every line below is the cabinet's own
// published wording; no service level is invented here.
const steps = [
  {
    t: 'Quinze minutes, gratuites',
    d: "Par téléphone ou en visioconférence. Vous nous dites où vous en êtes, nous vous disons si nous pouvons vous aider.",
  },
  {
    t: 'Un conseiller qui prend le temps',
    d: "Nos conseillers prennent le temps de comprendre votre situation avant de proposer quoi que ce soit.",
  },
  {
    t: 'Adaptée à votre domaine',
    d: "Chaque dossier est unique. Nos conseils s'adaptent à votre activité et à votre situation, pas l'inverse.",
  },
  {
    t: 'Nous anticipons vos défis',
    d: 'Un accompagnement qui va au-delà de la simple assistance et qui anticipe vos défis à venir.',
  },
]

const root = ref(null)

useGsap(({ gsap }) => {
  const track = {
    trigger: '.track',
    start: 'top 74%',
    end: 'bottom 72%',
    scrub: 0.5,
  }
  // The red line draws through the stages, and each one comes up out of grey as
  // the line reaches it: the progression is the animation, not decoration.
  gsap.fromTo('.fill', { scaleX: 0 }, { scaleX: 1, ease: 'none', scrollTrigger: track })
  gsap.fromTo('.st', { opacity: 0.3 }, { opacity: 1, ease: 'none', stagger: 0.6, scrollTrigger: track })
}, root)
</script>

<template>
  <section ref="root" class="band start">
    <div class="band-lead">
      <header class="hd">
        <h2 class="d2" v-rv="'mask'">Quinze minutes pour savoir<br />si nous pouvons vous aider.</h2>
        <p class="body" v-rv:8="'up'">
          Vous aimeriez parler avec un de nos conseillers à propos d'un service, ou simplement
          savoir si notre fiduciaire peut vous être utile ? Voici comment cela se passe.
        </p>
      </header>

      <div class="track">
        <div class="line"><span class="fill" /></div>
        <ol>
          <li v-for="s in steps" :key="s.t" class="st">
            <h3 class="t1">{{ s.t }}</h3>
            <p class="sm">{{ s.d }}</p>
          </li>
        </ol>
      </div>

      <div class="foot" v-rv="'up'">
        <a :href="CONTACT.booking" target="_blank" rel="noopener" class="cta cta-ink" v-mag>
          <span>Réserver mon entretien</span><Ar />
        </a>
        <a :href="CONTACT.phoneHref" class="lnk tel">{{ CONTACT.phone }}<Ar /></a>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hd { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 46ch);
  gap: clamp(18px, 3vw, 64px); align-items: end; margin-bottom: clamp(30px, 3.6vw, 58px) }

.line { height: 1px; background: var(--line); position: relative; margin-bottom: clamp(22px, 2.4vw, 34px) }
.fill { position: absolute; inset: 0; background: var(--red); transform-origin: 0 50%;
  transform: scaleX(0) }

.track ol { list-style: none; margin: 0; padding: 0;
  display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: clamp(20px, 3vw, 54px) }
.st { display: flex; flex-direction: column }
.st h3 { margin-bottom: 9px; max-width: 18ch }
.st .sm { max-width: 34ch }

.foot { display: flex; align-items: center; flex-wrap: wrap; gap: 14px 28px;
  margin-top: clamp(34px, 4vw, 62px) }
.tel { font-size: .95rem }
.tel:hover { color: var(--red) }

@media (max-width: 1000px) {
  .hd { grid-template-columns: 1fr; align-items: start; gap: 18px }
  .track ol { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 30px }
}
@media (max-width: 620px) {
  .track ol { grid-template-columns: 1fr; gap: 26px }
  /* stacked, the horizontal line no longer describes anything */
  .line { display: none }
}
</style>
