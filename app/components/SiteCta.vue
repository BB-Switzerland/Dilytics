<script setup>
import { CONTACT } from '~/content/site'
import { img } from '~/utils/img'

defineProps({
  title: { type: Array, default: () => ['Parlons de', 'votre situation.'] },
  text: { type: String, default: "Réservez un entretien de quinze minutes, gratuit, par téléphone ou en visioconférence. Vous saurez si notre fiduciaire peut vous aider." },
  // the red button opens the booking calendar, unless a page needs another
  // action: { label, to }
  action: { type: Object, default: null },
})
</script>

<template>
  <section class="cn">
    <div class="wrap grid">
      <div class="left">
        <Head3 :lines="title" cls="d2" as="h2" :accent="1" mode="scroll" />
        <p class="body" v-rv:14="'up'">{{ text }}</p>

        <a :href="CONTACT.phoneHref" class="phone d2" v-rv:20="'up'">{{ CONTACT.phone }}</a>

        <div class="acts" v-rv:26="'up'">
          <NuxtLink v-if="action" :to="action.to" class="cta cta-red"><span>{{ action.label }}</span><Ar /></NuxtLink>
          <a v-else :href="CONTACT.booking" target="_blank" rel="noopener" class="cta cta-red">
            <span>Réserver un entretien</span><Ar />
          </a>
          <a :href="`mailto:${CONTACT.mail}`" class="cta cta-line"><span>{{ CONTACT.mail }}</span></a>
        </div>

        <dl class="meta" v-rv:32="'up'">
          <div><dt class="xs">Adresse</dt><dd class="sm">{{ CONTACT.street }}, {{ CONTACT.city }}</dd></div>
          <div><dt class="xs">Horaires</dt><dd class="sm">{{ CONTACT.hours }}</dd></div>
        </dl>
      </div>

      <div class="right" v-rv:6="'zoom'">
        <div class="shot pic"><img :src="img('cta')" v-px="18" alt="" /><PhotoNote id="cta" /></div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.cn { padding-block: clamp(54px, 6.5vw, 116px); background: var(--ink); color: var(--paper) }
.cn :deep(.body), .cn .sm { color: rgba(244, 242, 238, .62) }
.cn .xs { color: rgba(244, 242, 238, .4) }
/* minmax(0, …): without it a grid item's automatic minimum is its content's
   min-content width, and the image column can squeeze the text column down to
   one word per line. */
.grid { display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(0, .95fr);
  gap: clamp(28px, 4vw, 80px); align-items: center }
.left .body { margin-top: 22px; max-width: 40ch }
.phone { display: block; margin: clamp(26px, 3vw, 44px) 0 0; color: var(--paper); transition: color .35s var(--e) }
.phone:hover { color: var(--red) }
.acts { display: flex; flex-wrap: wrap; gap: 10px; margin-top: clamp(24px, 2.8vw, 38px) }
.meta { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin: clamp(30px, 3.4vw, 46px) 0 0;
  padding-top: 22px; border-top: 1px solid rgba(244, 242, 238, .16) }
.meta dd { margin: 6px 0 0 }
.pic { height: clamp(280px, 38vw, 540px) }
@media (max-width: 900px) { .grid { grid-template-columns: 1fr } .right { order: -1 } .meta { grid-template-columns: 1fr } }
</style>
