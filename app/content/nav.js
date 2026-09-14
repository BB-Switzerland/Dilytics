import { byGroup } from './services'
import { CAT_BY_KEY } from './categories'

const cols = (g) => byGroup(g).map((s) => ({ to: s.slug, label: s.nav }))

const family = (key) => ({
  label: CAT_BY_KEY[key].nav,
  to: CAT_BY_KEY[key].slug,
  img: CAT_BY_KEY[key].img,
  items: cols(key),
})

// Businesses first: the order Dilytics asked for, see services.js.
export const MENU = [
  {
    ...family('entreprises'),
    blurb: 'Nos services pour entreprises vous libèrent de vos obligations fiscales et administratives.',
  },
  {
    ...family('crea'),
    blurb: "Dilytics effectue toutes les démarches administratives pour concrétiser votre projet d'entreprise.",
  },
  {
    ...family('particuliers'),
    blurb: 'Notre équipe vous aide à déclarer vos impôts et à améliorer votre situation fiscale.',
  },
  {
    label: 'Carrière',
    to: '/offres-demploi/',
    img: 'duo',
    blurb: 'Une équipe passionnée, innovante et résolument tournée vers l’avenir.',
    items: [
      { to: '/offres-demploi/', label: "Offres d'emploi" },
      { to: '/offres-demploi/', label: 'Candidature spontanée' },
    ],
  },
  {
    label: 'À propos',
    to: '/a-propos/',
    img: 'apropos',
    blurb: 'Bien plus qu’une fiduciaire : un partenaire qui comprend vos défis.',
    items: [
      { to: '/a-propos/', label: 'À propos de Dilytics' },
      { to: '/articles/', label: 'Articles' },
    ],
  },
]
