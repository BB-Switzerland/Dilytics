<script setup>
import { STATS, TEAM } from '~/content/site'
import { img } from '~/utils/img'
</script>

<template>
  <section class="cab">
    <div class="band-lead">
      <div class="panel navy-panel" v-rv="'up'">
        <div class="left">
          <blockquote class="d2">
            J'ai très vite constaté que l'importance n'était pas accordée
            <span class="red">aux projets des clients.</span>
          </blockquote>
          <div class="who">
            <div class="shot av"><img :src="img(TEAM[0].img)" alt="" /></div>
            <div>
              <span class="t2">{{ TEAM[0].name }}</span>
              <span class="xs">{{ TEAM[0].role }}</span>
            </div>
          </div>
          <NuxtLink to="/a-propos" class="cta cta-light"><span>Découvrir le cabinet</span><Ar /></NuxtLink>
        </div>

        <ul class="nums">
          <li v-for="(s, i) in STATS" :key="i" v-rv:[i*6]="'up'">
            <Pending v-if="s.pending" dark :label="s.pending" :hint="s.hint" />
            <template v-else>
              <span v-if="s.text" class="fig n">{{ s.text }}</span>
              <span v-else class="fig n">{{ s.prefix }}<Counter :to="s.n" />{{ s.suffix }}</span>
              <p class="l">{{ s.label }}</p>
            </template>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>

<style scoped>
.cab { padding-block: clamp(20px, 2.4vw, 40px) }
.panel { display: grid; grid-template-columns: minmax(0, 1.08fr) minmax(0, .92fr);
  gap: clamp(28px, 4vw, 84px); padding: clamp(28px, 3.4vw, 62px) }
blockquote { margin: 0; max-width: 30ch }
.who { display: flex; align-items: center; gap: 14px; margin: clamp(24px, 2.6vw, 38px) 0 clamp(22px, 2.4vw, 32px) }
.av { width: 54px; height: 54px; flex: none; border-radius: 50% }
.who > div { display: flex; flex-direction: column; gap: 2px }

.nums { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(2, 1fr);
  gap: clamp(22px, 2.8vw, 44px); align-content: center }
.nums li { display: flex; flex-direction: column; gap: 12px; padding-top: 18px;
  border-top: 1px solid rgba(244, 242, 238, .22) }
/* an odd count leaves the last figure alone on its row: it takes the full width */
.nums li:nth-child(odd):last-child { grid-column: 1 / -1 }
.n { font-size: clamp(2.3rem, 3.4vw, 3.8rem); color: var(--paper) }
.l { margin: 0; font-size: .78rem; line-height: 1.35; color: rgba(244, 242, 238, .5); max-width: 20ch }

@media (max-width: 1000px) { .panel { grid-template-columns: 1fr } }
</style>
