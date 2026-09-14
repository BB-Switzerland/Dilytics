<script setup>
import { PHOTOS, EXPECTED } from '~/content/photos'
import { img } from '~/utils/img'

// The shot list for Dilytics and its photographer, generated from the same
// registry that puts the red notes on the pages. Not linked, not indexed.
useHead({
  title: 'Photos à fournir · Dilytics',
  meta: [{ name: 'robots', content: 'noindex, nofollow' }],
})

const list = Object.entries(PHOTOS).map(([id, p]) => ({ id, ...p }))
const groups = [
  {
    t: 'Pages clés',
    d: 'Vues par tous les visiteurs. À traiter en premier.',
    items: list.filter((p) => p.prio === 1),
  },
  {
    t: 'Pages prestations',
    d: "Chaque image apparaît en haut de sa page et dans les cartes « Avez-vous besoin d'un autre service ? ». Une même série de photos peut servir à plusieurs prestations.",
    items: list.filter((p) => p.prio === 2),
  },
  {
    t: 'Articles',
    d: "Pas de séance photo ici : il suffit de reprendre l'image de chaque article publié.",
    items: list.filter((p) => p.prio === 3),
  },
]
const total = list.length + EXPECTED.length
</script>

<template>
  <article>
    <section class="op band-lead">
      <h1 class="d1">Photos à fournir</h1>
      <p class="body ld">
        {{ total }} emplacements attendent une photo réelle de l'équipe, des locaux ou de
        l'environnement de travail. Sur le site, chacun porte une note rouge qui rappelle ce qu'il
        faut montrer. Cette page n'est pas référencée.
      </p>
    </section>

    <section class="grp band-lead">
      <header class="gh">
        <h2 class="d3">Nouveaux emplacements <span class="ct">{{ EXPECTED.length }}</span></h2>
        <p class="sm">Aucune image aujourd'hui : la photo est à créer.</p>
      </header>
      <ul class="rows">
        <li v-for="e in EXPECTED" :key="e.id">
          <Pending photo label="Photo attendue" />
          <div>
            <p class="t2">{{ e.brief }}</p>
            <p class="xs wh">{{ e.where.join(' · ') }}</p>
          </div>
        </li>
      </ul>
    </section>

    <section v-for="g in groups" :key="g.t" class="grp band-lead">
      <header class="gh">
        <h2 class="d3">{{ g.t }} <span class="ct">{{ g.items.length }}</span></h2>
        <p class="sm">{{ g.d }}</p>
      </header>
      <ul class="rows">
        <li v-for="p in g.items" :key="p.id">
          <div class="shot th"><img :src="img(p.id)" alt="" loading="lazy" /></div>
          <div>
            <p class="t2">{{ p.brief }}</p>
            <p class="xs wh">{{ p.where.join(' · ') }}</p>
            <p class="xs wh">Fichier actuel : {{ p.id }}.webp</p>
          </div>
        </li>
      </ul>
    </section>
  </article>
</template>

<style scoped>
.op { padding-top: calc(var(--nav-h) + clamp(26px, 4vw, 56px)); padding-bottom: clamp(20px, 2.4vw, 36px) }
.ld { margin-top: 18px; max-width: 60ch }
.grp { padding-block: clamp(28px, 3.4vw, 52px) }
.gh { margin-bottom: 20px }
.gh .sm { margin-top: 8px; max-width: 70ch }
.ct { color: var(--muted); font-weight: 600 }
.rows { list-style: none; margin: 0; padding: 0 }
.rows li { display: grid; grid-template-columns: 200px minmax(0, 1fr); gap: clamp(16px, 2.4vw, 36px);
  align-items: center; padding: 16px 0; border-top: 1px solid var(--line) }
.rows li:last-child { border-bottom: 1px solid var(--line) }
.rows :deep(.pd) { padding: 14px }
.th { aspect-ratio: 4 / 3; border-radius: 8px }
.wh { margin-top: 6px; color: var(--muted) }
@media (max-width: 620px) { .rows li { grid-template-columns: 120px minmax(0, 1fr) } }
</style>
