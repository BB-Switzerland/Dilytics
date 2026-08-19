<script setup>
import { CONTACT } from '~/content/site'

const blank = () => ({ name: '', mail: '', phone: '', msg: '' })
const form = ref(blank())
const sent = ref(false)
const valid = computed(
  () => form.value.name.trim() && form.value.mail.includes('@') && form.value.msg.trim().length > 8,
)

function submit() {
  if (valid.value) sent.value = true
}
</script>

<template>
  <section class="ask">
    <div class="band-lead g">
      <div class="txt">
        <h2 class="d2" v-rv="'mask'">Des questions ?</h2>
        <p class="body" v-rv:6="'up'">
          Écrivez-nous pour nous communiquer vos besoins ou vos questions.
          Notre équipe répond à tous les messages.
        </p>
        <p class="sm hrs" v-rv:10="'up'">
          Nous sommes aussi joignables au téléphone du lundi au vendredi,
          de 9h à 12h et de 13h à 18h.
        </p>
        <div class="acts" v-rv:14="'up'">
          <a :href="CONTACT.phoneHref" class="cta cta-ink"><span>{{ CONTACT.phone }}</span></a>
          <a :href="`mailto:${CONTACT.mail}`" class="lnk">{{ CONTACT.mail }}<Ar /></a>
        </div>
      </div>

      <div class="fw surf" v-rv:8="'up'">
        <form v-if="!sent" @submit.prevent="submit">
          <div class="row">
            <div class="fld">
              <input id="ab-n" v-model="form.name" type="text" placeholder=" " required />
              <label for="ab-n">Nom et prénom</label>
            </div>
            <div class="fld">
              <input id="ab-e" v-model="form.mail" type="email" placeholder=" " required />
              <label for="ab-e">E-mail</label>
            </div>
          </div>
          <div class="fld">
            <input id="ab-p" v-model="form.phone" type="tel" placeholder=" " />
            <label for="ab-p">Téléphone</label>
          </div>
          <div class="fld">
            <textarea id="ab-m" v-model="form.msg" rows="4" placeholder=" " required />
            <label for="ab-m">Message</label>
          </div>
          <button type="submit" class="cta cta-red" :disabled="!valid">
            <span>Envoyer</span><Ar />
          </button>
          <p class="xs mini">
            Vos données restent au cabinet. Nous ne les transmettons à personne et ne vous
            inscrivons à aucune liste sans votre accord.
          </p>
        </form>

        <div v-else class="done">
          <p class="fig ok">Merci</p>
          <p class="body">
            Message reçu, {{ form.name.split(' ')[0] }}. Nous revenons vers vous à
            {{ form.mail }} dans les vingt-quatre heures ouvrables.
          </p>
          <button class="lnk" @click="sent = false; form = blank()">
            Écrire un autre message<Ar />
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.ask { padding-block: clamp(44px, 5vw, 84px); border-top: 1px solid var(--line) }
.g { display: grid; grid-template-columns: minmax(0, .85fr) minmax(0, 1.15fr);
  gap: clamp(26px, 4vw, 76px); align-items: start }
.txt .body { margin-top: 18px; max-width: 40ch }
.hrs { margin-top: 14px; max-width: 40ch }
.acts { display: flex; align-items: center; flex-wrap: wrap; gap: 14px 24px; margin-top: 26px }

.fw { padding: clamp(22px, 2.6vw, 38px) }
.row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px }
.fld { position: relative; margin-bottom: 14px }
.fld input, .fld textarea {
  width: 100%; background: var(--paper); border: 1px solid var(--line); border-radius: 10px;
  padding: 23px 15px 9px; font: inherit; font-size: .95rem; color: var(--ink); resize: vertical;
  transition: border-color .3s var(--e);
}
.fld input:focus, .fld textarea:focus { outline: none; border-color: var(--ink) }
.fld label { position: absolute; left: 16px; top: 16px; font-size: .93rem; color: var(--faint);
  pointer-events: none; transition: .26s var(--e) }
.fld input:focus + label, .fld input:not(:placeholder-shown) + label,
.fld textarea:focus + label, .fld textarea:not(:placeholder-shown) + label {
  top: 7px; font-size: .7rem; color: var(--red); font-weight: 640 }
button[disabled] { opacity: .38; pointer-events: none }
.mini { margin-top: 14px; max-width: 52ch }

.done { padding: 8px 0 }
.ok { font-size: clamp(1.8rem, 2.4vw, 2.4rem); color: var(--red) }
.done .body { margin: 12px 0 20px; max-width: 40ch }

@media (max-width: 960px) { .g, .row { grid-template-columns: 1fr } }
</style>
