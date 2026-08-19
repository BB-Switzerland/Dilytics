<script setup>
import { BY_SLUG } from '~/content/services'
import { PITCH } from '~/content/offers'
import { img } from '~/utils/img'

const props = defineProps({
  slugs: { type: Array, required: true },
  title: { type: String, default: "Avez-vous besoin d'un autre service ?" },
})

const items = computed(() =>
  props.slugs
    .map((s) => BY_SLUG[s])
    .filter(Boolean)
    .map((s) => ({ ...s, pitch: PITCH[s.slug] || s.lede })),
)
</script>

<template>
  <section class="xs-sec">
    <div class="band-lead">
      <h2 class="d3 hd" v-rv="'mask'">{{ title }}</h2>

      <div class="grid">
        <NuxtLink
          v-for="(s, i) in items"
          :key="s.slug"
          :to="s.slug"
          class="card surf surf-h"
          v-rv:[i*5]="'up'"
        >
          <div class="shot pic"><img :src="img(s.img)" :alt="s.title" /></div>
          <div class="in">
            <h3 class="t1">{{ s.title }}</h3>
            <p class="sm">{{ s.pitch }}</p>
            <span class="visit">Visiter la page<Ar /></span>
          </div>
        </NuxtLink>
      </div>
    </div>
  </section>
</template>

<style scoped>
.xs-sec { padding-block: clamp(40px, 4.6vw, 78px); border-top: 1px solid var(--line) }
.hd { margin-bottom: clamp(22px, 2.6vw, 38px) }
.grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: clamp(14px, 1.6vw, 24px) }
.card { display: flex; flex-direction: column; overflow: hidden }
.pic { border-radius: 0; aspect-ratio: 16 / 10 }
.in { padding: clamp(18px, 1.7vw, 26px); display: flex; flex-direction: column; flex: 1 }
.in .sm { margin-top: 9px; flex: 1 }
.visit { display: inline-flex; align-items: center; gap: 8px; margin-top: 18px;
  font-size: .85rem; font-weight: 640; color: var(--red) }
.visit :deep(.ar) { transition: transform .4s var(--e) }
.card:hover .visit :deep(.ar) { transform: translateX(5px) }
.card:hover .t1 { color: var(--red) }
.t1 { transition: color .3s var(--e) }

@media (max-width: 1080px) { .grid { grid-template-columns: repeat(2, minmax(0, 1fr)) } }
@media (max-width: 560px) { .grid { grid-template-columns: 1fr } }
</style>
