<script setup>
import { REVIEWS, REVIEW_SLOTS, DISTINCTIONS } from '~/content/site'
import { img } from '~/utils/img'
</script>

<template>
  <section class="band">
    <div class="band-lead">
      <h2 class="d2 hd" v-rv="'mask'">Ce que disent nos clients.</h2>

      <div class="g">
        <figure v-for="r in REVIEWS" :key="r.name" class="rv surf" v-rv="'up'">
          <blockquote>{{ r.quote }}</blockquote>
          <figcaption>
            <span class="t2">{{ r.name }}</span>
            <span class="sm">{{ r.role }}, {{ r.company }}</span>
          </figcaption>
        </figure>

        <div class="slots">
          <Pending
            v-for="n in REVIEW_SLOTS"
            :key="n"
            v-rv:[n*6]="'up'"
            label="Avis client à fournir"
            hint="Une citation courte, avec le nom, la fonction et l'entreprise du client, et son accord pour la publier."
          />
        </div>
      </div>

      <ul class="marks" v-stagger>
        <li v-for="d in DISTINCTIONS" :key="d.v">
          <span class="top">
            <img v-if="d.img" :src="img(d.img)" :alt="d.alt" class="lg" />
            <span v-else class="fig mv">{{ d.v }}</span>
          </span>
          <span class="sm">{{ d.t }}</span>
        </li>
      </ul>
    </div>
  </section>
</template>

<style scoped>
.hd { margin-bottom: clamp(26px, 3vw, 46px) }
.g { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(0, .65fr);
  gap: clamp(14px, 1.6vw, 24px); align-items: stretch }

.rv { margin: 0; padding: clamp(26px, 3vw, 52px); display: flex; flex-direction: column;
  justify-content: space-between; gap: 28px }
blockquote { margin: 0; font-size: clamp(1.2rem, 1.9vw, 1.7rem); font-weight: 600; line-height: 1.38;
  letter-spacing: -.024em; text-wrap: pretty }
blockquote::before { content: '«\00a0'; color: var(--red) }
blockquote::after { content: '\00a0»'; color: var(--red) }
figcaption { display: flex; flex-direction: column; gap: 3px; padding-top: 18px; border-top: 1px solid var(--line) }

.slots { display: grid; gap: clamp(14px, 1.6vw, 24px) }

.marks { list-style: none; margin: clamp(30px, 3.4vw, 52px) 0 0; padding: clamp(22px, 2.4vw, 32px) 0 0;
  border-top: 1px solid var(--line);
  display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: clamp(18px, 2.4vw, 40px) }
.marks li { display: flex; flex-direction: column; gap: 10px }
/* one height for every mark, so a badge and a figure share the same baseline */
.top { display: flex; align-items: flex-end; height: clamp(62px, 5.6vw, 84px) }
.lg { width: auto; height: 100% }
.mv { font-size: clamp(1.6rem, 2.4vw, 2.4rem) }

@media (max-width: 1000px) { .g { grid-template-columns: 1fr } }
@media (max-width: 620px) { .marks { grid-template-columns: 1fr } }
</style>
