<script setup>
const figures = [
  { v: '1999', l: 'Année de fondation du cabinet' },
  { v: '21', l: "Secteurs d'activité, de la restauration à la gestion de fortune" },
  { v: '6', l: 'Langues parlées au cabinet' },
  { v: '15 min', l: "Entretien de découverte, gratuit" },
]
</script>

<template>
  <div class="rail">
    <div class="band-lead in">
      <ul>
        <li v-for="(f, i) in figures" :key="f.l" v-rv:[i*5]="'up'">
          <span class="fig v">{{ f.v }}</span>
          <p class="fig-l">{{ f.l }}</p>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped>
.rail { padding-block: clamp(24px, 2.6vw, 40px) clamp(30px, 3.4vw, 54px) }
ul { list-style: none; margin: 0; padding: clamp(22px, 2.4vw, 34px) 0 0;
  border-top: 1px solid var(--line);
  display: grid; grid-template-columns: repeat(4, 1fr); gap: clamp(18px, 2.4vw, 44px) }
li { display: flex; flex-direction: column; gap: 11px }
.v { font-size: clamp(2rem, 3.1vw, 3.3rem) }
.fig-l { max-width: 19ch }
@media (max-width: 760px) { ul { grid-template-columns: repeat(2, 1fr); gap: 26px 20px } }
</style>
