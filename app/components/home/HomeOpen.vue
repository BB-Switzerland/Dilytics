<script setup>
import { CONTACT } from '~/content/site'
import { img } from '~/utils/img'

const root = ref(null)
const m = useMotion()
let ctx = null

// Published figures only, the same ones the About page carries.
const strip = [
  { v: '+312', l: 'Sociétés accompagnées depuis 1999' },
  { v: '21', l: "Secteurs d'activité couverts par nos mandats" },
  { v: '15 min', l: 'Entretien de découverte, gratuit' },
]

onMounted(() => {
  if (m.reduce || !m.gsap) return
  const { gsap } = m

  ctx = gsap.context(() => {
    const tl = gsap.timeline({ defaults: { ease: 'expo.out' } })

    tl.from('.bg', { clipPath: 'inset(100% 0 0 0)', duration: 1.6 }, 0)
      .from('.bg img', { scale: 1.32, duration: 2 }, 0)
      .from('.scrim', { opacity: 0, duration: 1.4 }, 0.2)
      .from('.kick', { y: 20, opacity: 0, duration: 0.9 }, 0.3)
      .from('.ld', { y: 30, opacity: 0, duration: 1 }, 0.72)
      .from('.acts > *', { y: 26, opacity: 0, duration: 0.9, stagger: 0.08 }, 0.84)
      .from('.strip li', { y: 30, opacity: 0, duration: 1, stagger: 0.09 }, 1)
      .from('.rule-top', { scaleX: 0, duration: 1.2, ease: 'power3.out' }, 1)

    // the photograph holds back as the page leaves, the text goes with it
    gsap.to('.bg img', {
      yPercent: 12,
      ease: 'none',
      scrollTrigger: { trigger: root.value, start: 'top top', end: 'bottom top', scrub: 0.6 },
    })
    gsap.to('.inner', {
      yPercent: -14,
      opacity: 0.25,
      ease: 'none',
      scrollTrigger: { trigger: root.value, start: 'top top', end: 'bottom top', scrub: 0.5 },
    })
  }, root.value)
})

onBeforeUnmount(() => ctx?.revert())
</script>

<template>
  <section ref="root" class="hero">
    <div class="bg">
      <img :src="img('meet')" alt="L'équipe Dilytics en réunion dans ses bureaux à Genève" />
    </div>
    <div class="scrim" aria-hidden="true" />

    <div class="inner wrap">
      <p class="kick">Dilytics · Fiduciaire à Genève</p>

      <Head3
        :lines="['La fiduciaire qui', 'vous rend du temps.']"
        cls="d1 hh"
        :accent="1"
        :delay="0.38"
      />

      <p class="body ld">
        Depuis {{ CONTACT.since }}, notre fiduciaire à Genève vous libère de vos obligations
        fiscales, juridiques et administratives, à travers un accompagnement personnalisé ou
        une aide ponctuelle. Notre équipe intervient dans toute la Suisse romande et à l'étranger.
      </p>

      <div class="acts">
        <a :href="CONTACT.booking" target="_blank" rel="noopener" class="cta cta-red" v-mag>
          <span>Réserver mon entretien</span><Ar />
        </a>
        <a :href="CONTACT.phoneHref" class="lnk tel">{{ CONTACT.phone }}<Ar /></a>
      </div>
    </div>

    <div class="foot wrap">
      <span class="rule-top" aria-hidden="true" />
      <ul class="strip">
        <li v-for="s in strip" :key="s.l">
          <span class="sv num">{{ s.v }}</span>
          <span class="sl">{{ s.l }}</span>
        </li>
      </ul>
    </div>
  </section>
</template>

<style scoped>
.hero {
  position: relative; isolation: isolate; overflow: hidden;
  /* svh, not vh: on a phone `vh` is the LARGE viewport: the height the page
     gets once the address bar has slid away. Sizing to it means the bar covers
     the bottom of the hero for as long as it is showing. svh is the small
     viewport, bar included, so the whole hero is visible at every moment.
     Not dvh either: dvh changes while the bar collapses, which would resize
     the section mid-scroll and force ScrollTrigger to re-measure. */
  min-height: 620px;                    /* browsers without svh */
  min-height: min(94svh, 900px);
  display: flex; flex-direction: column; justify-content: flex-end;
  padding-top: calc(var(--nav-h) + clamp(24px, 3.6vw, 60px));
  padding-bottom: clamp(20px, 2.4vw, 36px);
  background: var(--ink); color: var(--paper);
}

.bg { position: absolute; inset: 0; z-index: -2; will-change: clip-path }
.bg img { width: 100%; height: 100%; object-fit: cover; object-position: 50% 42%;
  transform: scale(1.08); transition: none }

/* Two ramps: one across, so the headline always sits on the deep end, and one
   up from the floor to carry the figures. */
.scrim { position: absolute; inset: 0; z-index: -1; background:
  linear-gradient(102deg, rgba(0, 25, 52, .93) 0%, rgba(0, 25, 52, .78) 34%,
    rgba(0, 25, 52, .40) 66%, rgba(0, 25, 52, .22) 100%),
  linear-gradient(to top, rgba(0, 25, 52, .68) 0%, rgba(0, 25, 52, 0) 46%) }

.inner, .foot { width: 100%; align-self: stretch }
.inner { flex: 1; display: flex; flex-direction: column; justify-content: center }
.kick { font-size: .8rem; font-weight: 620; letter-spacing: .11em; text-transform: uppercase;
  color: rgba(244, 242, 238, .72); margin: 0 0 clamp(18px, 2vw, 30px) }
.hh { font-size: clamp(2.35rem, 5.3vw, 5rem); letter-spacing: -.042em; max-width: 15ch }
.ld { margin-top: clamp(16px, 1.8vw, 26px); max-width: 56ch; line-height: 1.55;
  color: rgba(244, 242, 238, .9) }
.acts { display: flex; align-items: center; flex-wrap: wrap; gap: 12px 28px;
  margin-top: clamp(20px, 2.4vw, 34px) }
.tel { font-size: 1rem; color: var(--paper) }
.tel:hover { color: var(--red) }

/* the figures ride the bottom edge of the image */
.foot { position: relative; margin-top: clamp(22px, 3.2vw, 52px); flex: none }
.rule-top { display: block; height: 1px; background: rgba(244, 242, 238, .24);
  transform-origin: 0 50% }
.strip { list-style: none; margin: 0; padding: clamp(14px, 1.6vw, 22px) 0 0;
  display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: clamp(18px, 3vw, 60px) }
.strip li { display: flex; flex-direction: column; gap: 8px }
.sv { font-size: clamp(1.6rem, 2.6vw, 2.5rem); color: var(--paper) }
.sl { font-size: .85rem; line-height: 1.4; color: rgba(244, 242, 238, .74) }

/* held back only until the opening timeline takes over; see .mo in main.css */
:global(.mo) .kick,
:global(.mo) .ld,
:global(.mo) .acts,
:global(.mo) .strip li { opacity: 0 }
:global(.mo) .bg { clip-path: inset(100% 0 0 0) }

@media (max-width: 860px) {
  /* one full screen, address bar included */
  .hero { min-height: 100svh; padding-top: calc(var(--nav-h) + 20px) }
  .scrim { background:
    linear-gradient(to top, rgba(0, 25, 52, .92) 12%, rgba(0, 25, 52, .58) 58%, rgba(0, 25, 52, .42) 100%) }
  .ld { font-size: .97rem; max-width: 44ch }
  .strip { gap: 14px }
  .sv { font-size: 1.5rem }
  .sl { font-size: .72rem }
}
@media (max-width: 520px) {
  /* the three figures stay side by side; stacked they cost 100px of height
     the small screens do not have */
  .strip { gap: 10px }
  .sv { font-size: 1.25rem }
  .sl { font-size: .67rem; line-height: 1.3 }
}
@media (prefers-reduced-motion: reduce) {
  :global(.mo) .kick, :global(.mo) .ld, :global(.mo) .acts, :global(.mo) .strip li { opacity: 1 }
  :global(.mo) .bg { clip-path: none }
}
</style>
