<script setup>
import { CONTACT } from '~/content/site'

// One band, two cards. The price sits on white; what stands beside it depends
// on the service: the free-offer when there is one, otherwise the key figures.
// A price card alone across the full width left half the band empty.
const props = defineProps({
  price: { type: Object, required: true },
  label: { type: String, required: true },
  offer: { type: Object, default: null },
  facts: { type: Array, default: () => [] },
})

const el = ref(null)
const aside = computed(() => (props.offer ? 'offer' : props.facts.length ? 'facts' : null))

// The figure is the one number the visitor came for, so it counts up to itself.
const raw = computed(() => String(props.price.amount))
const target = computed(() => Number(raw.value.replace(/\D/g, '')) || 0)
const grouped = computed(() => /[^\d]/.test(raw.value))
const fmt = (n) =>
  grouped.value ? n.toLocaleString('fr-CH').replace(/\D/g, "'") : String(n)

// It holds the published figure and is only zeroed once the tween that counts
// it back up is definitely in hand.
const shown = ref(raw.value)

useGsap(({ gsap }) => {
  shown.value = fmt(0)
  const box = { n: 0 }
  gsap.to(box, {
    n: target.value,
    duration: 1.6,
    ease: 'power2.out',
    snap: { n: 1 },
    onUpdate: () => (shown.value = fmt(box.n)),
    onComplete: () => (shown.value = raw.value),
    scrollTrigger: { trigger: el.value, start: 'top 82%', once: true },
  })
}, el)
</script>

<template>
  <section ref="el" class="pr">
    <div class="band-lead">
      <div class="wrap2" :class="{ solo: !aside }">
        <div class="card main" v-rv="'up'" v-tilt>
          <p class="lead">{{ price.lead }}</p>

          <p class="amount">
            <span class="fig n">{{ shown }}</span>
            <span class="unit">
              <span class="cur">{{ price.unit }}</span>
              <span v-if="price.per" class="per">{{ price.per }}</span>
            </span>
          </p>
          <p v-if="price.terms" class="terms">{{ price.terms }}</p>

          <p class="detail">{{ price.detail }}</p>

          <div class="acts">
            <NuxtLink to="/contact" class="cta cta-red" v-mag><span>{{ price.cta }}</span><Ar /></NuxtLink>
            <a :href="CONTACT.phoneHref" class="ph">{{ CONTACT.phone }}</a>
          </div>
        </div>

        <div v-if="aside === 'offer'" class="card gift" v-rv:8="'up'" v-tilt>
          <p class="gl">Offert</p>
          <h2 class="gt">{{ offer.t }}</h2>
          <p class="gd">{{ offer.d }}</p>
          <NuxtLink to="/contact" class="cta cta-light" v-mag><span>{{ offer.cta }}</span><Ar /></NuxtLink>
        </div>

        <div v-else-if="aside === 'facts'" class="card keys" v-rv:8="'up'" v-tilt>
          <h2 class="kt">{{ label }}, en bref</h2>
          <dl>
            <div v-for="f in facts" :key="f.k">
              <dt>{{ f.k }}</dt>
              <dd>{{ f.v }}</dd>
            </div>
          </dl>
          <a :href="CONTACT.booking" target="_blank" rel="noopener" class="cta cta-light" v-mag>
            <span>Prendre rendez-vous</span><Ar />
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.pr { background: var(--sand); padding-block: clamp(44px, 5vw, 88px) }
.wrap2 { display: grid; grid-template-columns: minmax(0, 1.15fr) minmax(0, .85fr);
  gap: clamp(14px, 1.6vw, 24px); align-items: stretch }
.wrap2.solo { grid-template-columns: minmax(0, 1fr); max-width: 760px }

.card { border-radius: clamp(20px, 2vw, 28px); padding: clamp(26px, 2.8vw, 46px);
  display: flex; flex-direction: column }

/* the price, on white */
.main { background: var(--white);
  box-shadow: 0 24px 52px -30px rgba(0, 25, 52, .3), 0 2px 8px -4px rgba(0, 25, 52, .08) }
.lead { margin: 0; font-size: .84rem; font-weight: 620; color: var(--muted); max-width: 34ch }
.amount { display: flex; align-items: baseline; gap: 12px; margin: clamp(14px, 1.6vw, 22px) 0 0 }
.n { font-size: clamp(3.4rem, 7vw, 6.4rem); color: var(--ink); line-height: .85;
  font-variant-numeric: tabular-nums }
.unit { display: flex; flex-direction: column; gap: 2px }
.cur { font-size: 1.05rem; font-weight: 780; color: var(--red); letter-spacing: -.02em }
.per { font-size: .86rem; color: var(--muted); white-space: nowrap }
.terms { margin: 12px 0 0; font-size: .82rem; color: var(--faint) }
.detail { margin: clamp(18px, 2vw, 26px) 0 0; font-size: .95rem; line-height: 1.55;
  color: var(--muted); max-width: 52ch; flex: 1 }
.acts { display: flex; align-items: center; flex-wrap: wrap; gap: 14px 24px;
  margin-top: clamp(20px, 2.2vw, 30px) }
.ph { font-size: 1.02rem; font-weight: 760; letter-spacing: -.03em }
.ph:hover { color: var(--red) }

/* the free offer, on red, a different register from the price */
.gift { background: var(--red); color: #fff; justify-content: space-between }
.gl { margin: 0; font-size: .74rem; font-weight: 700; letter-spacing: .12em;
  text-transform: uppercase; color: rgba(255, 255, 255, .72) }
.gt { margin: 14px 0 0; font-size: clamp(1.3rem, 1.9vw, 1.85rem); font-weight: 800;
  letter-spacing: -.03em; line-height: 1.12 }
.gd { margin: 14px 0 clamp(22px, 2.4vw, 32px); font-size: .93rem; line-height: 1.55;
  color: rgba(255, 255, 255, .84); flex: 1 }
.gift .cta { align-self: flex-start }

/* the key figures, on navy, stands in when the service has no free-offer */
.keys { background: var(--ink); color: var(--paper) }
.kt { margin: 0 0 clamp(16px, 1.8vw, 24px); font-size: clamp(1.15rem, 1.5vw, 1.4rem);
  font-weight: 760; letter-spacing: -.028em; line-height: 1.15 }
.keys dl { margin: 0 0 clamp(22px, 2.4vw, 32px); flex: 1 }
.keys dl > div { display: flex; align-items: baseline; justify-content: space-between;
  gap: 20px; padding: 13px 0; border-top: 1px solid rgba(244, 242, 238, .18) }
.keys dl > div:last-child { border-bottom: 1px solid rgba(244, 242, 238, .18) }
.keys dt { font-size: .82rem; color: rgba(244, 242, 238, .56) }
.keys dd { margin: 0; font-size: 1rem; font-weight: 700; letter-spacing: -.022em;
  text-align: right }
.keys .cta { align-self: flex-start }

@media (max-width: 940px) { .wrap2 { grid-template-columns: 1fr } }
</style>
