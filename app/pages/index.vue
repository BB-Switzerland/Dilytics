<script setup>
import { SERVICES } from '~/content/services'

useHead({ title: 'Dilytics, votre fiduciaire à Genève depuis 1999' })

const ticker = SERVICES.map((s) => s.nav)
</script>

<template>
  <div>
    <HomeOpen />
    <Marquee :items="ticker" />
    <HomeDemand />
    <HomeBenefits />
    <HomeStatement />
    <HomeSplit />
    <HomeStart />
    <HomeFigures />
    <HomeReviews />
    <HomeJournal />
    <SiteCta />
  </div>
</template>
