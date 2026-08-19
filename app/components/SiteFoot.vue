<script setup>
import { MENU } from '~/content/nav'
import { CONTACT } from '~/content/site'
</script>

<template>
  <footer class="ft">
    <div class="wrap">
      <Ax />
      <div class="top">
        <div class="brand">
          <NuxtLink to="/" class="lg" aria-label="Dilytics, accueil"><Logo /></NuxtLink>
          <p class="sm">
            Fiduciaire genevoise depuis {{ CONTACT.since }}. Comptabilité, fiscalité, salaires
            et création d'entreprise, pour les PME et les particuliers.
          </p>
          <address class="xs ad">
            {{ CONTACT.street }}<br />{{ CONTACT.city }}<br />{{ CONTACT.hours }}
          </address>
        </div>

        <nav class="cols">
          <div v-for="m in MENU" :key="m.label">
            <h2 class="idx">{{ m.label }}</h2>
            <NuxtLink v-for="it in m.items" :key="it.to" :to="it.to">{{ it.label }}</NuxtLink>
          </div>
          <div>
            <h2 class="idx">Contact</h2>
            <NuxtLink to="/contact">Nous écrire</NuxtLink>
            <NuxtLink to="/contact">Prendre rendez-vous</NuxtLink>
            <a :href="CONTACT.phoneHref">{{ CONTACT.phone }}</a>
            <a :href="`mailto:${CONTACT.mail}`">{{ CONTACT.mail }}</a>
          </div>
        </nav>
      </div>

      <Ax />
      <div class="bot">
        <span class="xs">© 2026 Dilytics · Genève</span>
        <div class="lg2">
          <button class="on">FR</button><span class="xs">/</span><button>EN</button>
        </div>
        <span class="xs">Mentions légales · Protection des données</span>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.ft { padding-top: clamp(40px, 4.6vw, 76px) }
.top { display: grid; grid-template-columns: minmax(0, .82fr) 2.18fr; gap: clamp(28px, 4vw, 76px);
  padding-block: clamp(30px, 3.4vw, 52px) }
.lg { width: 122px; display: block; color: var(--ink); margin-bottom: 20px }
.brand .sm { max-width: 34ch }
.ad { font-style: normal; margin-top: 18px }

.cols { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: clamp(12px, 1.6vw, 26px) }
.cols > div { display: flex; flex-direction: column; align-items: flex-start; gap: 9px }
.cols .idx { margin-bottom: 6px }
.cols a { font-size: .855rem; color: var(--muted); transition: color .3s var(--e), transform .35s var(--e) }
.cols a:hover { color: var(--red); transform: translateX(3px) }

.bot { display: flex; align-items: center; justify-content: space-between; gap: 18px; flex-wrap: wrap;
  padding-block: 22px clamp(24px, 3vw, 40px) }
.lg2 { display: flex; align-items: center; gap: 7px }
.lg2 button { font-size: .78rem; font-weight: 640; color: var(--faint); transition: color .3s }
.lg2 button:hover, .lg2 .on { color: var(--ink) }

@media (max-width: 1000px) { .top { grid-template-columns: 1fr } .cols { grid-template-columns: repeat(3, 1fr) } }
@media (max-width: 620px) { .cols { grid-template-columns: repeat(2, 1fr) } }
</style>
