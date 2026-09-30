// /llms.txt (format llmstxt.org): what the cabinet is and where each service
// lives, for the AI assistants that answer questions about Dilytics. Built
// from the same content as the pages, word for word, so it never drifts from
// the site. `site` is the origin the links are written against: the request's
// origin on Nuxt, '{site}' for WordPress, which puts its home URL there.
// Full file names: the server route loads these modules with Node's own
// resolver, which does not guess extensions.
import { byGroup } from './services.js'
import { CAT_BY_KEY } from './categories.js'
import { MENU } from './nav.js'
import { CONTACT, SOCIAL, LEGAL, STATS, DISTINCTIONS, TEAM } from './site.js'

const blurb = (to) => MENU.find((m) => m.to === to)?.blurb

export function llmsTxt(site) {
  const url = (path) => site + path
  const link = (label, path, text) => `- [${label}](${url(path)})${text ? ': ' + text : ''}`

  const family = (key) => {
    const cat = CAT_BY_KEY[key]
    return [
      `## ${cat.nav}`,
      '',
      link(cat.title, cat.slug, cat.lede),
      ...byGroup(key).map((s) => link(s.title, s.slug, s.lede)),
    ]
  }

  return [
    '# Dilytics',
    '',
    `> Fiduciaire genevoise depuis ${CONTACT.since}. Comptabilité, fiscalité, salaires et création d'entreprise, pour les PME et les particuliers.`,
    '',
    `Depuis ${CONTACT.since}, notre fiduciaire à Genève vous libère de vos obligations fiscales, juridiques et administratives, à travers un accompagnement personnalisé ou une aide ponctuelle. Notre équipe intervient dans toute la Suisse romande et à l'étranger.`,
    '',
    `- Adresse : ${CONTACT.street}, ${CONTACT.city} (${CONTACT.building})`,
    `- Téléphone : ${CONTACT.phone}`,
    `- E-mail : ${CONTACT.mail}`,
    `- Horaires : ${CONTACT.hours}`,
    `- Rendez-vous : un entretien de quinze minutes, gratuit, par téléphone ou en visioconférence, à réserver sur ${CONTACT.booking}`,
    ...STATS.map((s) => `- ${s.text ?? s.n} ${s.label}`),
    ...DISTINCTIONS.map((d) => (d.t.includes(d.v) ? `- ${d.t}` : `- ${d.t} : ${d.v}`)),
    '',
    'Équipe :',
    '',
    ...TEAM.map((p) => `- ${p.name}, ${p.role}`),
    '',
    ...family('entreprises'),
    '',
    ...family('crea'),
    '',
    ...family('particuliers'),
    '',
    '## Le cabinet',
    '',
    link('À propos de Dilytics', '/a-propos/', blurb('/a-propos/')),
    link('Contact', '/contact/', 'Écrivez-nous pour nous communiquer vos besoins ou vos questions. Notre équipe répond à tous les messages.'),
    link("Offres d'emploi", '/offres-demploi/', blurb('/offres-demploi/')),
    link('Articles', '/articles/', "Dilytics propose une série d'articles en lien avec la création d'entreprise et la fiscalité en Suisse."),
    '',
    '## Optional',
    '',
    ...SOCIAL.map((s) => `- [${s.label}](${s.href})`),
    ...LEGAL.map((l) => link(l.label, l.href)),
    '',
  ].join('\n')
}
