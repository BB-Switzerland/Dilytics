// Compares a page of the Nuxt site with the same page on WordPress, element by
// element: tag, classes, the attributes that change rendering, and text.
//
//   node wordpress/tools/compare.mjs /contact/ [/articles/ …]
//   node wordpress/tools/compare.mjs --all
//
// Nuxt runs locally (npm run dev, port 3000), WordPress is fetched live with a
// query string so the page cache never answers. What each platform adds for
// its own mechanics is ignored: Vue's data-v-*, Beaver Builder's fl-* classes
// and node attributes, the plugin's scope classes (v-*) and motion hooks.
// Elements the plugin keeps in the page but hides (closed panels, a form's
// "sent" state) are skipped: Nuxt does not render them at all.

import { parse, walkSync, ELEMENT_NODE, TEXT_NODE } from 'ultrahtml'
import { writeFileSync, mkdirSync, readFileSync } from 'node:fs'
import { execSync } from 'node:child_process'
import { resolve, dirname } from 'node:path'
import { fileURLToPath } from 'node:url'

const NUXT = process.env.NUXT || 'http://localhost:3000'
const WP = process.env.WP || 'https://dilytics.businessbooster.agency'
const out = resolve(process.env.OUT || '/tmp/dl-compare')
mkdirSync(out, { recursive: true })

const KEEP_ATTR = ['href', 'src', 'alt', 'aria-label', 'aria-hidden', 'aria-expanded', 'target', 'rel', 'type', 'id',
  'for', 'placeholder', 'rows', 'required', 'disabled', 'selected', 'value', 'loading', 'role', 'data-rv', 'data-rvd',
  'data-px', 'data-hd', 'viewbox', 'width', 'height', 'd', 'style', 'colspan']
const DROP_CLASS = (c) => /^(fl-|v-|router-link|dl-shell$)/.test(c)

const norm = {
  href(v) {
    if (!v) return v
    v = v.replace(WP, '').replace(/^https?:\/\/dilytics\.businessbooster\.agency/, '')
    if (v.startsWith('/') && !v.includes('#') && !v.includes('?') && !/\.[a-z0-9]+$/i.test(v) && !v.endsWith('/')) v += '/'
    return v
  },
  src(v) {
    if (!v) return v
    const base = v.split('?')[0].split('/').pop()
    return base.replace(/^dl-/, '').replace(/\.[A-Za-z0-9_-]{8}\.webp$/, '.webp')
  },
  style(v) {
    return v.replace(/\s+/g, '').replace(/;$/, '')
  },
}

async function get(url) {
  const r = await fetch(url, { headers: { 'user-agent': 'dl-compare' } })
  if (!r.ok) throw new Error(`${url}: ${r.status}`)
  return r.text()
}

// Nuxt: everything inside #__nuxt. WordPress: header, main content, footer.
function roots(doc, which) {
  const found = []
  walkSync(doc, (n) => {
    if (n.type !== ELEMENT_NODE) return
    const a = n.attributes || {}
    if (which === 'nuxt' && a.id === '__nuxt') found.push(n)
    if (which === 'wp' && typeof a.class === 'string' && /\bfl-builder-content\b/.test(a.class)) found.push(n)
  })
  return found
}

function lines(node, acc = [], depth = 0) {
  for (const c of node.children || []) {
    if (c.type === TEXT_NODE) {
      const t = c.value.replace(/\s+/g, ' ').trim()
      if (t) acc.push(`${'  '.repeat(depth)}"${decode(t)}"`)
      continue
    }
    if (c.type !== ELEMENT_NODE) continue
    // attribute names compared without case: the HTML parser turns Vue's
    // `viewbox` into `viewBox` itself
    const a = {}
    for (const [k, v] of Object.entries(c.attributes || {})) a[k.toLowerCase()] = v
    // Nuxt's <main> and the page's own unclassed root carry nothing of the design
    if (c.name === 'main' || (node.name === 'main' && !a.class)) {
      lines(c, acc, depth)
      continue
    }
    // an empty value on a field is Vue's v-model, not something drawn
    if ((c.name === 'input' || c.name === 'textarea') && a.value === '') delete a.value
    const cls = typeof a.class === 'string' ? a.class.split(/\s+/).filter((x) => x && !DROP_CLASS(x)) : []
    const isBB = typeof a.class === 'string' && /\bfl-(row|col|module-content|col-group|row-content|col-content)\b/.test(a.class) && !cls.length
    if (a.style && /display:\s*none/.test(a.style)) continue
    if (c.name === 'script' || c.name === 'style' || c.name === 'noscript' || c.name === 'link') continue
    // Beaver Builder's row and column wrappers carry nothing of the design: flattened
    if (isBB || (c.name === 'div' && a['data-node'] && !cls.length && !a['data-rv'])) {
      lines(c, acc, depth)
      continue
    }
    const attrs = KEEP_ATTR.filter((k) => a[k] !== undefined && !(k === 'style' && /^transform:\s*(scaleX\(0\)|translateX\(0px\) scaleX\(0\));?$/.test(a[k]) && false))
      .map((k) => {
        let v = a[k]
        if (norm[k]) v = norm[k](String(v))
        return v === '' || v === true ? k : `${k}=${decode(String(v))}`
      })
    acc.push(`${'  '.repeat(depth)}<${c.name}${cls.length ? '.' + cls.sort().join('.') : ''}${attrs.length ? ' ' + attrs.join(' ') : ''}>`)
    lines(c, acc, depth + 1)
  }
  return acc
}

function decode(s) {
  return s.replace(/&nbsp;| /g, ' ').replace(/&#39;|&#039;|&apos;/g, "'").replace(/&quot;/g, '"')
    .replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&#8217;/g, '’')
    .replace(/&#8211;/g, '–').replace(/&#8212;/g, '—').replace(/&#171;/g, '«').replace(/&#187;/g, '»')
    .replace(/&#(\d+);/g, (_, n) => String.fromCodePoint(+n))
}

async function page(path) {
  const [n, w] = await Promise.all([get(NUXT + path), get(`${WP}${path}?nocache=${Date.now()}`)])
  const nl = roots(parse(n), 'nuxt').flatMap((r) => lines(r))
  const wl = roots(parse(w), 'wp').flatMap((r) => lines(r))
  const slug = path.replace(/\//g, '_') || '_'
  const a = resolve(out, `${slug}.nuxt.txt`)
  const b = resolve(out, `${slug}.wp.txt`)
  writeFileSync(a, nl.join('\n') + '\n')
  writeFileSync(b, wl.join('\n') + '\n')
  let diff = ''
  try {
    execSync(`diff -u "${a}" "${b}"`, { encoding: 'utf8' })
  } catch (e) {
    diff = e.stdout
  }
  const changed = diff.split('\n').filter((l) => /^[+-][^+-]/.test(l)).length
  console.log(`${changed ? '✗' : '✓'} ${path}  ${nl.length} lines nuxt, ${wl.length} wp, ${changed} differing`)
  if (changed) writeFileSync(resolve(out, `${slug}.diff`), diff)
  return changed
}

const args = process.argv.slice(2)
let paths = args
if (args[0] === '--all') {
  const here = dirname(fileURLToPath(import.meta.url))
  const c = JSON.parse(readFileSync(resolve(here, '../chantier/data/content.json'), 'utf8'))
  paths = ['/', '/entreprises/', '/creation-dentreprise/', '/particuliers/', '/a-propos/', '/contact/', '/articles/',
    '/offres-demploi/', '/photos-a-fournir/', ...c.services.map((s) => s.slug)]
}
let bad = 0
for (const p of paths) bad += (await page(p)) ? 1 : 0
console.log(`\n${paths.length - bad}/${paths.length} identical. Diffs in ${out}`)
