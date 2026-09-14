<script setup>
import { CONTACT } from '~/content/site'
import { img } from '~/utils/img'
import { mailDraft } from '~/utils/mailto'

useHead({ title: 'Contact · Dilytics, fiduciaire à Genève' })

const blank = () => ({ name: '', mail: '', phone: '', subject: '', msg: '' })
const form = ref(blank())
const sent = ref(false)
const valid = computed(() => form.value.name && form.value.mail.includes('@') && form.value.msg.length > 8)
const subjects = ['Comptabilité', 'Fiscalité des entreprises', 'Salaires et RH', "Création d'entreprise", 'Impôts des particuliers', 'Autre sujet']

function submit() {
  if (!valid.value) return
  const f = form.value
  window.location.href = mailDraft({ ...f, subject: `${f.subject || 'Demande de contact'} · ${f.name}` })
  sent.value = true
}
</script>

<template>
  <article>
    <section class="op wrap">
      <nav class="crumb"><NuxtLink to="/">Accueil</NuxtLink><span>·</span><span class="cur">Contact</span></nav>
      <div class="og">
        <div>
          <Head3 :lines="['Prenez contact.', 'Nous répondons', 'à tous les messages.']" :accent="2" />
          <p class="body ld" v-rv:22="'up'">
            Remplissez le formulaire pour nous poser vos questions ou demander un devis.
            Vous pouvez également nous joindre par téléphone, du lundi au vendredi.
          </p>
        </div>
        <div class="shot opic" v-rv:6="'zoom'"><img :src="img('geneve')" alt="Vue aérienne de Genève et du Jet d'eau" /></div>
      </div>
    </section>

    <section class="bay">
      <div class="wrap cg">
        <div class="fw" v-rv="'up'">
          <form v-if="!sent" class="form" @submit.prevent="submit">
            <div class="row">
              <div class="fld">
                <input id="n" v-model="form.name" type="text" placeholder=" " required />
                <label for="n">Votre nom</label>
              </div>
              <div class="fld">
                <input id="e" v-model="form.mail" type="email" placeholder=" " required />
                <label for="e">Adresse e-mail</label>
              </div>
            </div>
            <div class="row">
              <div class="fld">
                <input id="p" v-model="form.phone" type="tel" placeholder=" " />
                <label for="p">Téléphone (facultatif)</label>
              </div>
              <div class="fld">
                <select id="s" v-model="form.subject">
                  <option value="" disabled>Choisir un sujet</option>
                  <option v-for="s in subjects" :key="s" :value="s">{{ s }}</option>
                </select>
                <label for="s" class="up">Sujet</label>
              </div>
            </div>
            <div class="fld">
              <textarea id="m" v-model="form.msg" rows="5" placeholder=" " required />
              <label for="m">Votre message</label>
            </div>
            <div class="sub">
              <button type="submit" class="cta cta-ink" :disabled="!valid"><span>Envoyer le message</span><Ar /></button>
              <p class="xs">Vous pouvez aussi nous joindre par téléphone, du lundi au vendredi.</p>
            </div>
          </form>

          <div v-else class="done">
            <h2 class="d3">Votre message est prêt.</h2>
            <p class="body">
              Votre messagerie s'est ouverte avec le message adressé à {{ CONTACT.mail }} : il ne
              reste qu'à l'envoyer. Si rien ne s'est ouvert, écrivez-nous directement à cette adresse.
            </p>
            <button class="lnk" @click="sent = false; form = blank()">Écrire un autre message<Ar /></button>
          </div>
        </div>

        <aside class="side" v-rv:8="'up'">
          <div class="blk">
            <h2 class="t2">Nous appeler</h2>
            <a :href="CONTACT.phoneHref" class="big">{{ CONTACT.phone }}</a>
            <p class="sm">{{ CONTACT.hours }}</p>
          </div>
          <div class="blk">
            <h2 class="t2">Nous écrire</h2>
            <a :href="`mailto:${CONTACT.mail}`" class="lnk">{{ CONTACT.mail }}<Ar /></a>
          </div>
          <div class="blk">
            <h2 class="t2">Nous rendre visite</h2>
            <p class="sm">{{ CONTACT.street }}<br />{{ CONTACT.city }}</p>
            <p class="xs">À moins de dix minutes du centre-ville, accessible par le Léman Express et de nombreux bus.</p>
          </div>
        </aside>
      </div>
    </section>
  </article>
</template>

<style scoped>
.op { padding-top: calc(var(--nav-h) + clamp(26px, 4vw, 56px)) }
.crumb { display: flex; gap: 10px; align-items: center; font-size: .8rem; color: var(--faint); margin-bottom: clamp(20px, 2.6vw, 34px) }
.crumb a:hover { color: var(--red) }
.cur { color: var(--ink); font-weight: 560 }
.og { display: grid; grid-template-columns: minmax(0, 1.12fr) minmax(0, .88fr); gap: clamp(24px, 3.6vw, 64px); align-items: end }
.ld { margin-top: 22px; max-width: 44ch }
.opic { aspect-ratio: 4 / 3 }

.cg { display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(0, .6fr); gap: clamp(24px, 3.4vw, 60px); align-items: start }
.fw { background: var(--sand); border-radius: var(--r); padding: clamp(22px, 3vw, 44px) }
.row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px }
.fld { position: relative; margin-bottom: 14px }
.fld input, .fld textarea, .fld select {
  width: 100%; background: var(--white); border: 1px solid var(--line); border-radius: 8px;
  padding: 23px 15px 9px; font: inherit; font-size: .95rem; color: var(--ink); resize: vertical;
  transition: border-color .3s var(--e);
}
.fld select { appearance: none; cursor: pointer }
.fld input:focus, .fld textarea:focus, .fld select:focus { outline: none; border-color: var(--ink) }
.fld label { position: absolute; left: 16px; top: 16px; font-size: .93rem; color: var(--faint);
  pointer-events: none; transition: .26s var(--e) }
.fld input:focus + label, .fld input:not(:placeholder-shown) + label,
.fld textarea:focus + label, .fld textarea:not(:placeholder-shown) + label,
.fld label.up { top: 7px; font-size: .7rem; color: var(--red); font-weight: 640 }
.sub { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; margin-top: 8px }
.sub .xs { max-width: 28ch }
button[disabled] { opacity: .38; pointer-events: none }
.done .body { margin: 12px 0 22px; max-width: 42ch }

.side { display: flex; flex-direction: column; gap: 12px }
.blk { background: var(--sand); border-radius: var(--r); padding: 22px }
.blk .t2 { margin-bottom: 10px }
.blk p { margin-top: 8px }
.big { font-size: clamp(1.25rem, 1.7vw, 1.5rem); font-weight: 790; letter-spacing: -.035em; color: var(--red) }


@media (max-width: 960px) {
  .og, .cg, .row { grid-template-columns: 1fr }
}
</style>
