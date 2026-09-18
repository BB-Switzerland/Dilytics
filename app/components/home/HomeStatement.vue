<template>
  <section class="say">
    <div class="hold">
      <p class="s" v-lit>
        Nos conseillers <span class="red">anticipent toujours vos défis à venir</span>
        et proposent des solutions concrètes, adaptées aux entreprises d'aujourd'hui.
      </p>
    </div>
  </section>
</template>

<style scoped>
.say { padding-block: clamp(66px, 8.4vw, 156px) }
/* wider than the reading measure: at this size 700px would break it into
   too many short lines */
.hold { max-width: 1080px; margin-inline: auto; padding-inline: var(--pad) }
.s { margin: 0; text-align: center; text-wrap: pretty;
  font-size: clamp(1.85rem, 4.1vw, 3.6rem); font-weight: 800;
  letter-spacing: -.036em; line-height: 1.09 }
</style>
