<script setup>
import { CONTACT } from '~/content/site'
import { img } from '~/utils/img'

const root = ref(null)
const m = useMotion()
let ctx = null

const bars = [38, 56, 74, 100]

onMounted(() => {
  if (m.reduce || !m.gsap) return
  const { gsap } = m

  // One timeline for the whole opening, so the photograph, the headline and the
  // two cards arrive as a single move instead of four unrelated ones.
  ctx = gsap.context(() => {
    const tl = gsap.timeline({ defaults: { ease: 'expo.out' } })

    tl.from('.main', { clipPath: 'inset(0 0 100% 0)', duration: 1.5 }, 0)
      .from('.main img', { scale: 1.3, duration: 1.9 }, 0)
      .from('.kick', { y: 20, opacity: 0, duration: 0.9 }, 0.15)
      .from('.ld', { y: 32, opacity: 0, duration: 1 }, 0.52)
      .from('.acts > *', { y: 26, opacity: 0, duration: 0.9, stagger: 0.08 }, 0.64)
      .from('.card', { y: 38, scale: 0.92, opacity: 0, duration: 1.15, stagger: 0.13 }, 0.8)
      .from('.bars i', { scaleY: 0, duration: 0.85, stagger: 0.07, ease: 'power3.out' }, 1.05)

    // Scroll-linked: the photograph holds back while the two cards pull apart,
    // so the composition opens as the page leaves.
    const drift = (sel, y) =>
      gsap.to(sel, {
        yPercent: y,
        ease: 'none',
        scrollTrigger: { trigger: root.value, start: 'top top', end: 'bottom top', scrub: 0.6 },
      })

    drift('.main img', 9)
    drift('.top', -30)
    drift('.bot', 20)
  }, root.value)
})

onBeforeUnmount(() => ctx?.revert())
</script>

<template>
  <section ref="root" class="hero">
    <div class="wrap g">
      <div class="txt">
        <p class="kick">Dilytics · Fiduciaire à Genève</p>

        <Head3 :lines="['La fiduciaire qui', 'vous rend du temps.']" :accent="1" :delay="0.28" />

        <p class="body ld">
          Depuis {{ CONTACT.since }}, notre fiduciaire à Genève vous libère de vos obligations
          fiscales, juridiques et administratives, à travers un accompagnement personnalisé ou
          une aide ponctuelle. Notre équipe intervient dans toute la Suisse romande et à l'étranger.
        </p>

        <div class="acts">
          <a :href="CONTACT.booking" target="_blank" rel="noopener" class="cta cta-ink" v-mag>
            <span>Réserver mon entretien</span>
          </a>
          <a :href="CONTACT.phoneHref" class="lnk tel">{{ CONTACT.phone }}<Ar /></a>
        </div>
      </div>

      <div class="art">
        <div class="shot main">
          <img :src="img('duo')" alt="L'équipe Dilytics en rendez-vous client" />
        </div>

        <figure class="card top">
          <div class="ch"><span class="cl">Sociétés accompagnées depuis 1999</span></div>
          <span class="cv num">+312</span>
          <div class="bars">
            <i v-for="(b, i) in bars" :key="i" :style="{ '--h': b + '%', '--i': i }" />
          </div>
        </figure>

        <figure class="card bot">
          <div class="ch"><span class="cl">Entretien de découverte</span></div>
          <span class="cv num">15 min</span>
          <span class="cd">gratuit, par téléphone ou en visioconférence</span>
        </figure>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero { padding-top: calc(var(--nav-h) + clamp(28px, 4.4vw, 86px)); padding-bottom: clamp(34px, 4.4vw, 84px) }
.g {
  display: grid; grid-template-columns: minmax(0, .92fr) minmax(0, 1.08fr);
  gap: clamp(28px, 4.6vw, 104px); align-items: center;
}

.kick { font-size: .8rem; font-weight: 620; letter-spacing: .11em; text-transform: uppercase;
  color: var(--faint); margin: 0 0 clamp(16px, 1.8vw, 26px) }
.ld { margin-top: clamp(20px, 2vw, 30px); max-width: 50ch }
.acts { display: flex; align-items: center; flex-wrap: wrap; gap: 12px 26px; margin-top: clamp(26px, 2.8vw, 40px) }
.tel { font-size: .95rem }
.tel:hover { color: var(--red) }

.art { position: relative }
.main { border-radius: var(--r-lg); aspect-ratio: 4 / 3.45 }
.main img { transform: scale(1.09); transition: none }

.card {
  position: absolute; margin: 0; background: var(--white); border-radius: 16px;
  padding: 16px 20px 18px; display: flex; flex-direction: column;
  box-shadow: 0 20px 44px -22px rgba(0, 25, 52, .34), 0 2px 8px -3px rgba(0, 25, 52, .14);
}
/* Both cards sit fully inside the photo, insets only. */
.top { top: clamp(18px, 2.6vw, 42px); right: clamp(18px, 2.2vw, 38px); width: clamp(190px, 15.5vw, 238px) }
.bot { bottom: clamp(18px, 2.6vw, 42px); left: clamp(18px, 2.2vw, 38px); width: clamp(186px, 14.5vw, 226px) }

.ch { display: flex; align-items: baseline; justify-content: space-between; gap: 10px }
.cl { font-size: .76rem; font-weight: 640; color: var(--ink); line-height: 1.3 }
.cv { font-size: clamp(1.7rem, 2.1vw, 2.2rem); margin: 10px 0 0; color: var(--ink) }
.cd { font-size: .72rem; line-height: 1.35; color: var(--muted); margin-top: 7px }

.bars { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; align-items: end; height: 46px; margin-top: 14px }
.bars i { display: block; height: var(--h); border-radius: 5px; background: var(--red);
  opacity: calc(.42 + var(--i) * .19); transform-origin: 50% 100% }

/* held back only until the opening timeline takes over — see .mo in main.css */
:global(.mo) .kick,
:global(.mo) .ld,
:global(.mo) .acts,
:global(.mo) .card { opacity: 0 }
:global(.mo) .main { clip-path: inset(0 0 100% 0) }

@media (max-width: 1000px) {
  .g { grid-template-columns: 1fr; gap: 32px }
  .art { order: -1 }
  .main { aspect-ratio: 16 / 11 }
  .top { top: 14px; right: 14px }
  .bot { bottom: 14px; left: 14px }
}
@media (max-width: 560px) {
  .main { aspect-ratio: 4 / 3.4 }
  .card { position: static; width: auto !important; box-shadow: none; background: var(--sand); padding: 14px 16px 16px }
  .art { display: grid; grid-template-columns: 1fr 1fr; gap: 8px }
  .main { grid-column: 1 / -1; margin-bottom: 2px }
  .bars { height: 34px; margin-top: 10px }
  .cd { display: none }
}
@media (prefers-reduced-motion: reduce) {
  :global(.mo) .kick, :global(.mo) .ld, :global(.mo) .acts, :global(.mo) .card { opacity: 1 }
  :global(.mo) .main { clip-path: none }
}
</style>
