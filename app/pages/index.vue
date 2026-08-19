<script setup>
import { SERVICES } from '~/content/services'

useHead({ title: 'Dilytics, votre fiduciaire à Genève depuis 1999' })

const ticker = SERVICES.map((s) => s.nav)
</script>

<template>
  <div>
    <HomeOpen />
    <HomeProof />
    <Marquee :items="ticker" />
    <HomeDemand />
    <HomeStatement />
    <HomeSplit />
    <HomeStart />
    <HomeFigures />
    <HomeJournal />
    <SiteCta />
  </div>
</template>
