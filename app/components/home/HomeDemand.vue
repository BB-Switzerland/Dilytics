<script setup>
// Business-facing prestations first, as Dilytics asked: private tax returns
// are no longer pushed from the home page. Descriptions are the cabinet's own,
// from its home page and its cross-sell lines.
const rows = [
  { t: 'Comptabilité', d: 'Notre équipe de spécialistes est disponible pour effectuer un suivi, complet ou partiel, de votre comptabilité.', to: '/comptabilite-geneve-experts-fiduciaire/' },
  { t: 'Payroll et administration RH', d: 'Déléguez-nous la gestion de vos salaires et optimisez votre temps dans la gestion de votre équipe.', to: '/payroll-et-administration-rh/' },
  { t: 'TVA', d: "Notre équipe d'experts s'occupe de vos décomptes TVA et de vos déclarations fiscales.", to: '/tva-suisse/' },
  { t: 'Audit des comptes', d: 'Respectez vos obligations fiscales grâce à un contrôle de vos comptes.', to: '/audit-des-comptes/' },
  { t: "Mandat de gérant et d'administrateur", d: "Dirigez votre société en Suisse depuis l'étranger.", to: '/mandat-de-gerant-et-administrateur-en-suisse/' },
  { t: "Création d'entreprise", d: 'Nous remplissons toutes les formalités pour ouvrir votre société à Genève.', to: '/creation-dentreprise/' },
]
</script>

<template>
  <section id="prestations" class="band">
    <div class="band-lead">
      <header class="hd">
        <h2 class="d2" v-rv="'mask'">Nos prestations<br />pour les entreprises</h2>
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
