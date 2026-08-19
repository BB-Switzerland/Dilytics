<script setup>
// The cabinet's own descriptions, taken from its home and family pages.
const rows = [
  { t: 'Comptabilité', d: 'Notre équipe de spécialistes est disponible pour effectuer un suivi, complet ou partiel, de votre comptabilité.', to: '/comptabilite-geneve-experts-fiduciaire/' },
  { t: "Déclaration d'impôts", d: 'Nous réalisons votre déclaration fiscale en prenant en compte toutes les déductions auxquelles vous avez droit.', to: '/declaration-dimpots/' },
  { t: 'Domiciliation fiscale', d: "Notre fiduciaire à Genève vous loue une adresse fiscale pour vos activités d'entreprise ou d'indépendant.", to: '/domiciliation-a-geneve/' },
  { t: 'Payroll et administration RH', d: 'Déléguez-nous la gestion de vos salaires et optimisez votre temps dans la gestion de votre équipe.', to: '/payroll-et-administration-rh/' },
  { t: "Création d'entreprise", d: 'Nous remplissons toutes les formalités pour ouvrir votre société à Genève.', to: '/creation-dentreprise/' },
  { t: 'TVA', d: "Notre équipe d'experts s'occupe de vos décomptes TVA et de vos déclarations fiscales.", to: '/tva-suisse/' },
]
</script>

<template>
  <section id="prestations" class="band">
    <div class="band-lead">
      <header class="hd">
        <h2 class="d2" v-rv="'mask'">Nos services les<br />plus demandés</h2>
        <NuxtLink to="/entreprises" class="lnk all" v-rv:10="'up'">
          Toutes nos prestations<Ar />
        </NuxtLink>
      </header>

      <ServiceList :items="rows" />
    </div>
  </section>
</template>

<style scoped>
.hd { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px;
  flex-wrap: wrap; margin-bottom: clamp(26px, 3vw, 46px) }
.all { color: var(--red) }
</style>
