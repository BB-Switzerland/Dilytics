<script setup>
import { TEAM, CONTACT } from '~/content/site'
import { EXPECTED } from '~/content/photos'
import { img } from '~/utils/img'

useHead({ title: 'À propos · Dilytics, fiduciaire à Genève' })

// This page is a story, not a catalogue. It deliberately drops the layout the
// rest of the site uses (headline left, photograph right, then a grid) for a
// wide opening, two eras side by side, and the team in their own words.

// The identity figures, with the cabinet's own explanations.
const marks = [
  { v: '1999', t: 'Année de fondation', d: 'Au service des particuliers et des entreprises depuis lors.' },
  { v: '21', t: "Secteurs d'activité", d: 'Nos clients vont de la restauration à la gestion de fortune.' },
  { v: '6', t: 'Langues maîtrisées', d: 'Allemand, anglais, arabe, espagnol, français et portugais.' },
]

// "Une histoire qui s'est construite en deux étapes."
const eras = [
  {
    y: '1999',
    t: 'La fondation',
    p: [
      "Denis Perret fonde la société fiduciaire à Genève, après avoir exercé pendant quinze ans en tant qu'indépendant à Neuchâtel. Dilytics est le fruit de sa longue expérience dans les chiffres.",
      "Au fil du temps, l'entreprise se bâtit une réputation de partenaire fiable auprès des particuliers, des indépendants et des entreprises de la région. En 2002, le cabinet s'installe à Chêne-Bougeries, sur la rive gauche du canton.",
    ],
  },
  {
    y: '2022',
    t: 'La reprise',
    p: [
      "Laureano Rodrigues, économiste d'entreprise HES et spécialiste en fiscalité, reprend Dilytics avec l'intention de moderniser la fiduciaire tout en maintenant l'esprit d'excellence des premières années.",
      "La société s'installe au Petit-Lancy pour être plus proche de ses clients. Le passage au numérique lui permet de mieux les accompagner et de leur proposer des outils de comptabilité analytique et de contrôle des coûts.",
    ],
  },
]

// "Notre philosophie", verbatim.
const values = [
  { t: 'Anticipation', d: 'Nos conseillers anticipent toujours vos défis à venir.' },
  { t: 'Individualisation', d: 'Chaque dossier est unique. Nous nous adaptons à votre situation.' },
  { t: 'Excellence', d: 'Notre équipe est minutieuse et fera tout pour exceller dans son travail.' },
  { t: 'Simplification', d: 'Nous mettons en place des outils qui simplifient votre quotidien.' },
]
</script>

<template>
  <article>
    <!-- opening: the headline runs the full measure, the photograph runs edge
         to edge underneath it, the inverse of every other page -->
    <section class="op">
      <div class="band-lead">
        <nav class="crumb">
          <NuxtLink to="/">Accueil</NuxtLink><span aria-hidden="true">·</span><span class="cur">À propos</span>
        </nav>
        <h1 class="huge" v-rv="'mask'">Bien plus qu’une fiduciaire</h1>
        <div class="intro">
          <p class="body" v-rv:10="'up'">
            Notre équipe résout vos défis quotidiens, qui peuvent prendre plusieurs dimensions.
            Notre philosophie est de penser à votre projet et à vos besoins.
          </p>
          <p class="body" v-rv:16="'up'">
            Notre entreprise a pour ambition de devenir le partenaire qui vous aide à concrétiser
            vos objectifs entrepreneuriaux et financiers. Nous partageons vos responsabilités et
            comprenons vos défis.
          </p>
        </div>
      </div>

      <figure class="bleed" v-rv="'zoom'">
        <img :src="img('apropos')" alt="La réception du cabinet Dilytics au Petit-Lancy" />
      </figure>
    </section>

    <!-- the identity figures, as rows rather than a four-up grid -->
    <section class="marks">
      <div class="band-lead">
        <ul v-stagger>
          <li v-for="m in marks" :key="m.t">
            <span class="mv fig">{{ m.v }}</span>
            <div class="mt">
              <h2 class="t1">{{ m.t }}</h2>
              <p class="sm">{{ m.d }}</p>
            </div>
          </li>
        </ul>
      </div>
    </section>

    <!-- two eras, side by side, because that is how the cabinet tells it -->
    <section class="hist">
      <div class="band-lead">
        <header class="hhd">
          <h2 class="d2" v-rv="'mask'">Notre histoire</h2>
          <p class="body" v-rv:8="'up'">Une histoire qui s’est construite en deux étapes.</p>
        </header>

        <div class="eras" v-stagger>
          <article v-for="e in eras" :key="e.y">
            <span class="ey">{{ e.y }}</span>
            <h3 class="d3">{{ e.t }}</h3>
            <p v-for="(par, j) in e.p" :key="j" class="prose">{{ par }}</p>
          </article>
        </div>
      </div>
    </section>

    <!-- philosophy: the heading holds while the four principles go past -->
    <section class="phi">
      <div class="band-lead pwrap">
        <div class="pstick">
          <h2 class="d2" v-rv="'mask'">Notre philosophie</h2>
          <p class="sm" v-rv:8="'text'">
            Quatre principes, et des interlocuteurs humains qui vous accompagnent réellement.
          </p>
        </div>

        <ol class="vals" v-stagger>
          <li v-for="v in values" :key="v.t">
            <h3 class="vt">{{ v.t }}</h3>
            <p class="body">{{ v.d }}</p>
          </li>
        </ol>
      </div>
    </section>

    <!-- the team, in their own words: the one thing no other page can show -->
    <section class="team">
      <div class="band-lead">
        <header class="thd">
          <h2 class="d2" v-rv="'mask'">Découvrez notre équipe</h2>
          <p class="body" v-rv:8="'up'">
            Notre politique de recrutement accorde une grande importance à l’expertise. Nous tenons
            à réunir des experts capables de proposer des solutions innovantes.
          </p>
        </header>

        <ul class="people">
          <li v-for="p in TEAM" :key="p.name" v-rv="'up'">
            <div class="shot por"><img :src="img(p.img)" :alt="p.name" v-px="12" /></div>
            <div class="say">
              <blockquote class="q">{{ p.quote }}</blockquote>
              <div class="who">
                <span class="t2 nm">{{ p.name }}</span>
                <span class="xs rl">{{ p.role }}</span>
                <span class="xs cr">{{ p.diploma }}</span>
                <span class="xs cr">{{ p.langs }}</span>
                <a :href="p.linkedin" target="_blank" rel="noopener" class="lnk li">LinkedIn<Ar /></a>
              </div>
            </div>
          </li>
        </ul>

        <NuxtLink to="/offres-demploi" class="lnk jobs" v-rv="'up'">Nous recrutons<Ar /></NuxtLink>
      </div>
    </section>

    <!-- the offices: Dilytics wants them shown for real, and until the pictures
         exist each slot says exactly what it should show -->
    <section class="loc">
      <div class="band-lead">
        <header class="lhd">
          <h2 class="d2" v-rv="'mask'">Nos locaux</h2>
          <p class="body" v-rv:8="'up'">{{ CONTACT.building }}, {{ CONTACT.street }}, {{ CONTACT.city }}.</p>
        </header>
        <ul class="lgrid" v-stagger>
          <li v-for="e in EXPECTED" :key="e.id">
            <Pending photo label="Photo réelle à fournir" :hint="e.brief" />
          </li>
        </ul>
      </div>
    </section>

    <!-- the partnership, on its own band, carried by bexio's own badge -->
    <section class="bex">
      <div class="band-lead bwrap">
        <img :src="img('bexio_platine')" alt="Badge bexio Partenaire Platine" class="bxb" v-rv="'up'" />
        <div>
          <h2 class="d3 bt" v-rv:6="'up'">Partenaire Platine bexio</h2>
          <p class="body bd" v-rv:12="'up'">
            Dilytics est partenaire Platine du logiciel bexio. Nos spécialistes sont
            habilités à intégrer cette solution et à former votre personnel à son utilisation.
          </p>
        </div>
      </div>
    </section>

    <SiteCta
      :title="['Venez', 'nous voir.']"
      :text="`Notre cabinet se situe à Lancy, à moins de dix minutes du centre-ville de Genève. ${CONTACT.hours}.`"
    />
  </article>
</template>

<style scoped>
/* ------------------------------------------------------------- opening */
.op { padding-top: calc(var(--nav-h) + clamp(26px, 4vw, 56px)) }
.crumb { display: flex; gap: 10px; align-items: center; font-size: .8rem;
  color: var(--faint); margin-bottom: clamp(24px, 3.4vw, 46px) }
.crumb a:hover { color: var(--red) }
.cur { color: var(--ink); font-weight: 560 }

.huge { margin: 0; font-size: clamp(2.7rem, 7.6vw, 7.2rem); font-weight: 830;
  letter-spacing: -.045em; line-height: .93; text-wrap: balance; max-width: 16ch }
.intro { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: clamp(20px, 3vw, 60px); margin-top: clamp(28px, 3.4vw, 52px);
  padding-bottom: clamp(34px, 4vw, 66px) }

/* the photograph runs the full width of the window. 2:1, not 21:8: the
   reception shot needs its height to keep the armchairs whole. */
.bleed { margin: 0; width: 100vw; margin-left: calc(50% - 50vw);
  aspect-ratio: 2 / 1; overflow: hidden; background: var(--sand) }
.bleed img { width: 100%; height: 100%; object-fit: cover }

/* ------------------------------------------------------------- figures */
.marks { padding-block: clamp(40px, 5vw, 88px) }
.marks ul { list-style: none; margin: 0; padding: 0 }
.marks li { display: grid; grid-template-columns: minmax(0, 3.6fr) minmax(0, 6.4fr);
  gap: clamp(20px, 4vw, 80px); align-items: baseline;
  padding: clamp(20px, 2.4vw, 34px) 0; border-top: 1px solid var(--line) }
.marks li:last-child { border-bottom: 1px solid var(--line) }
.mv { font-size: clamp(3rem, 7vw, 6rem); line-height: .82; color: var(--ink) }
.mt h2 { margin-bottom: 8px }
.mt .sm { max-width: 44ch }

/* ------------------------------------------------------------- history */
.hist { background: var(--ink); color: var(--paper); padding-block: clamp(48px, 6vw, 104px) }
.hhd { max-width: 46ch; margin-bottom: clamp(30px, 3.6vw, 56px) }
.hhd .body { color: rgba(244, 242, 238, .68); margin-top: 14px }
.eras { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: clamp(24px, 4vw, 80px) }
.ey { display: block; font-size: .78rem; font-weight: 700; letter-spacing: .12em; color: var(--red) }
.eras h3 { margin: 14px 0 16px }
.prose { margin: 0 0 1em; font-size: 1rem; line-height: 1.68; color: rgba(244, 242, 238, .74) }
.prose:last-child { margin-bottom: 0 }

/* ---------------------------------------------------------- philosophy */
.phi { padding-block: clamp(48px, 6vw, 100px) }
.pwrap { display: grid; grid-template-columns: minmax(0, .82fr) minmax(0, 1.18fr);
  gap: clamp(30px, 5vw, 96px) }
.pstick { position: sticky; top: calc(var(--nav-h) + 40px); align-self: start }
.pstick .sm { margin-top: 16px; max-width: 26ch }
.vals { list-style: none; margin: 0; padding: 0 }
.vals li { padding: clamp(22px, 2.6vw, 36px) 0; border-top: 1px solid var(--line) }
.vals li:last-child { border-bottom: 1px solid var(--line) }
.vt { margin: 0 0 10px; font-size: clamp(1.5rem, 2.4vw, 2.15rem); font-weight: 800;
  letter-spacing: -.034em; line-height: 1.05; color: var(--red) }
.vals .body { max-width: 46ch }

/* ---------------------------------------------------------------- team */
.team { background: var(--sand); padding-block: clamp(48px, 6vw, 100px) }
.thd { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 44ch);
  gap: clamp(20px, 4vw, 72px); align-items: end; margin-bottom: clamp(30px, 3.6vw, 56px) }
.people { list-style: none; margin: 0; padding: 0 }
.people li { display: grid; grid-template-columns: clamp(180px, 21vw, 300px) minmax(0, 1fr);
  gap: clamp(22px, 3.6vw, 64px); align-items: start;
  padding: clamp(26px, 3.2vw, 48px) 0; border-top: 1px solid rgba(0, 25, 52, .13) }
.people li:last-child { border-bottom: 1px solid rgba(0, 25, 52, .13) }
.por { aspect-ratio: 3 / 3.6; border-radius: var(--r-lg) }
.q { margin: 0 0 clamp(20px, 2.4vw, 30px); font-size: clamp(1.05rem, 1.45vw, 1.34rem);
  font-weight: 500; line-height: 1.48; letter-spacing: -.018em; max-width: 60ch;
  text-wrap: pretty }
.who { display: flex; flex-direction: column; gap: 4px }
.nm { margin-bottom: 2px }
.rl { color: var(--red); font-weight: 620 }
.li { margin-top: 12px; font-size: .85rem }
.li:hover { color: var(--red) }
.jobs { margin-top: clamp(28px, 3.4vw, 46px); color: var(--red) }

/* ------------------------------------------------------------- offices */
.loc { padding-block: clamp(48px, 6vw, 100px) }
.lhd { display: flex; align-items: baseline; justify-content: space-between; gap: 12px 32px;
  flex-wrap: wrap; margin-bottom: clamp(24px, 3vw, 44px) }
.lgrid { list-style: none; margin: 0; padding: 0; display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr)); gap: clamp(14px, 1.6vw, 24px) }

/* ------------------------------------------------------------- partner */
.bex { padding-block: clamp(40px, 5vw, 80px) }
.bwrap { display: grid; grid-template-columns: auto minmax(0, 1fr);
  gap: clamp(22px, 4vw, 72px); align-items: center;
  padding-block: clamp(26px, 3vw, 44px); border-block: 1px solid var(--line) }
.bxb { width: auto; height: clamp(120px, 11vw, 168px) }
.bt { margin: 0 0 12px }
.bd { max-width: 60ch }

@media (max-width: 1000px) {
  .intro, .eras, .pwrap, .thd, .bwrap, .lgrid { grid-template-columns: 1fr; gap: 20px }
  .bxb { height: 104px }
  .pstick { position: static }
  .bleed { aspect-ratio: 3 / 2 }
  .marks li { grid-template-columns: 1fr; gap: 12px }
  .people li { grid-template-columns: 1fr; gap: 20px }
  .por { max-width: 260px; aspect-ratio: 3 / 3.4 }
}
</style>
