<script setup>
// A small, deliberately plain stroke set. Named benefits read faster with a
// mark beside them; anything more decorative would fight the brand.
defineProps({ name: { type: String, required: true } })
</script>

<template>
  <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <template v-if="name === 'tag'">
      <path d="M3 12.5V4a1 1 0 0 1 1-1h8.5L21 11.5 12.5 20 3 12.5Z" />
      <circle cx="7.5" cy="7.5" r="1.4" />
    </template>
    <template v-else-if="name === 'screen'">
      <rect x="2.5" y="4" width="19" height="13" rx="1.8" />
      <path d="M8.5 21h7M12 17v4M6.5 12.5l3-3 2.5 2.5 4-4.5" />
    </template>
    <template v-else-if="name === 'talk'">
      <path d="M20.5 12.5a7.5 7.5 0 0 1-10.9 6.7L4 20.5l1.4-5A7.5 7.5 0 1 1 20.5 12.5Z" />
      <path d="M9 11h6M9 14.5h3.5" />
    </template>
    <template v-else-if="name === 'coin'">
      <ellipse cx="12" cy="6.5" rx="7.5" ry="3" />
      <path d="M4.5 6.5v11c0 1.7 3.4 3 7.5 3s7.5-1.3 7.5-3v-11M4.5 12c0 1.7 3.4 3 7.5 3s7.5-1.3 7.5-3" />
    </template>
    <template v-else-if="name === 'clock'">
      <circle cx="12" cy="12" r="8.5" />
      <path d="M12 7v5.2l3.2 2" />
    </template>
    <template v-else-if="name === 'shield'">
      <path d="M12 3 4.5 6v6c0 4.4 3.1 7.9 7.5 9 4.4-1.1 7.5-4.6 7.5-9V6L12 3Z" />
      <path d="M9 12l2.2 2.2L15.5 10" />
    </template>
    <template v-else-if="name === 'pin'">
      <path d="M12 21s7-5.4 7-11a7 7 0 1 0-14 0c0 5.6 7 11 7 11Z" />
      <circle cx="12" cy="10" r="2.6" />
    </template>
    <template v-else-if="name === 'doc'">
      <path d="M14 3H7a1.5 1.5 0 0 0-1.5 1.5v15A1.5 1.5 0 0 0 7 21h10a1.5 1.5 0 0 0 1.5-1.5V7.5L14 3Z" />
      <path d="M13.5 3.2V8h4.8M9 12.5h6M9 16h4" />
    </template>
    <template v-else-if="name === 'users'">
      <circle cx="9.5" cy="8.5" r="3.2" />
      <path d="M3.5 20a6 6 0 0 1 12 0M16.5 5.6a3.2 3.2 0 0 1 0 5.9M18 20a6 6 0 0 0-2.2-4.6" />
    </template>
    <template v-else-if="name === 'chart'">
      <path d="M4 20V9.5M10 20V4.5M16 20v-7M22 20H2" />
    </template>
    <template v-else>
      <circle cx="12" cy="12" r="8.5" />
      <path d="M8.5 12.2l2.4 2.4 4.6-5" />
    </template>
  </svg>
</template>

<style scoped>
.ico { width: 100%; height: 100%; display: block }
</style>
