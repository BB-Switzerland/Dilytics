<script setup>
import logo from '~/assets/logo.svg?raw'
</script>

<template>
  <span class="lg" v-html="logo" />
</template>

<style scoped>
.lg :deep(svg) { width: 100%; height: auto; display: block }
</style>
