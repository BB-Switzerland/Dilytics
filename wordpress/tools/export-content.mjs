// Exports every piece of content the Nuxt site renders into one JSON file the
// WordPress build scripts read, so the two sites carry exactly the same text.
//
//   node wordpress/tools/export-content.mjs
//
// Two sources: the content modules in app/content, imported as they are, and
// the constants declared in the <script setup> of a few components and pages,
// evaluated from their own source rather than copied by hand.

import { readFileSync, writeFileSync, mkdirSync } from 'node:fs'
import { dirname, resolve } from 'node:path'
import { fileURLToPath } from 'node:url'
import { createJiti } from 'jiti'
import * as acorn from 'acorn'
import { parse } from '@vue/compiler-sfc'

const root = resolve(dirname(fileURLToPath(import.meta.url)), '../..')
const app = resolve(root, 'app')
const out = resolve(root, 'wordpress/chantier/data/content.json')

const jiti = createJiti(import.meta.url, { alias: { '~': app } })
const load = (f) => jiti.import(resolve(app, 'content', f))

const site = await load('site.js')
const services = await load('services.js')
const offers = await load('offers.js')
const bodies = await load('bodies.js')
const categories = await load('categories.js')
const nav = await load('nav.js')
const photos = await load('photos.js')

// Top-level `const NAME = …` of a component, evaluated with the content in scope.
function grab(file, names) {
  const { descriptor } = parse(readFileSync(resolve(app, file), 'utf8'))
  const src = (descriptor.scriptSetup || descriptor.script).content
  const ast = acorn.parse(src, { ecmaVersion: 'latest', sourceType: 'module' })
  const found = {}
  for (const node of ast.body) {
    if (node.type !== 'VariableDeclaration') continue
    for (const d of node.declarations) {
      if (d.id.type === 'Identifier' && names.includes(d.id.name) && d.init) {
        const code = src.slice(d.init.start, d.init.end)
        found[d.id.name] = new Function('CONTACT', `return (${code})`)(site.CONTACT)
      }
    }
  }
  for (const n of names) if (!(n in found)) throw new Error(`${file}: const ${n} not found`)
  return found
}

const data = {
  site: {
    CONTACT: site.CONTACT,
    SOCIAL: site.SOCIAL,
    LEGAL: site.LEGAL,
    STATS: site.STATS,
    REVIEWS: site.REVIEWS,
    REVIEW_SLOTS: site.REVIEW_SLOTS,
    DISTINCTIONS: site.DISTINCTIONS,
    TEAM: site.TEAM,
    ARTICLES: site.ARTICLES,
  },
  groups: services.GROUPS,
  services: services.SERVICES,
  pitch: offers.PITCH,
  h1: offers.H1,
  price: offers.PRICE,
  bodies: bodies.BODY,
  categories: categories.CATEGORIES,
  menu: nav.MENU,
  photos: { NOTES: photos.NOTES, PHOTOS: photos.PHOTOS, EXPECTED: photos.EXPECTED },
  components: {
    homeOpen: grab('components/home/HomeOpen.vue', ['strip']),
    homeDemand: grab('components/home/HomeDemand.vue', ['rows']),
    homeBenefits: grab('components/home/HomeBenefits.vue', ['items']),
    homeSplit: grab('components/home/HomeSplit.vue', ['points']),
    homeStart: grab('components/home/HomeStart.vue', ['steps']),
    about: grab('pages/a-propos.vue', ['marks', 'eras', 'values']),
    jobs: grab('pages/offres-demploi.vue', ['offers', 'perks']),
    contact: grab('pages/contact.vue', ['subjects']),
  },
}

mkdirSync(dirname(out), { recursive: true })
writeFileSync(out, JSON.stringify(data, null, 1))
console.log(`content.json: ${data.services.length} services, ${Object.keys(data.bodies).length} bodies, ${data.menu.length} menu families`)

// /llms.txt, the same file as on Nuxt; the plugin puts the site's URL in {site}.
const { llmsTxt } = await load('llms.js')
writeFileSync(resolve(root, 'wordpress/dilytics-modules/assets/llms.txt'), llmsTxt('{site}'))
console.log('llms.txt: written')
