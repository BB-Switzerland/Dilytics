// Compares the rendered geometry of Nuxt and WordPress pages: the box of every
// element carrying a class, measured in headless Chrome at several widths.
// compare.mjs proves the HTML is the same; this proves the CSS lays it out the
// same way. Animation transforms are neutralised before measuring, so only
// layout is compared.
//
//   node wordpress/tools/geometry.mjs                 every page, 1440 and 390
//   node wordpress/tools/geometry.mjs / /contact/     some pages
//   WIDTHS=1440,1024,390 node wordpress/tools/geometry.mjs
//
// Nuxt must be running on port 3000.

import { spawn, execSync } from 'node:child_process'
import { mkdtempSync, mkdirSync, writeFileSync, readFileSync, rmSync } from 'node:fs'
import { tmpdir } from 'node:os'
import { resolve, dirname } from 'node:path'
import { fileURLToPath } from 'node:url'

const CHROME = process.env.CHROME || '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome'
const NUXT = process.env.NUXT || 'http://localhost:3000'
const WP = process.env.WP || 'https://dilytics.businessbooster.agency'
const WIDTHS = (process.env.WIDTHS || '1440,390').split(',').map(Number)
const out = resolve(process.env.OUT || '/tmp/dl-geometry')
const PORT = 9333
mkdirSync(out, { recursive: true })

const sleep = (ms) => new Promise((r) => setTimeout(r, ms))

// Runs in the page: waits for fonts, pictures and the motion engine's first
// pass, freezes every transform and transition, then lists the boxes.
const MEASURE = `(async () => {
  await document.fonts.ready
  for (const i of document.images) { i.loading = 'eager'; try { await i.decode() } catch (e) {} }
  await new Promise((r) => setTimeout(r, 1800))
  const st = document.createElement('style')
  st.textContent = '*,*::before,*::after{transition:none!important;animation:none!important;transform:none!important;translate:none!important;scale:none!important;rotate:none!important}'
  document.head.appendChild(st)
  window.scrollTo(0, 0)
  await new Promise((r) => setTimeout(r, 200))
  const skip = (c) => /^(fl-|v-|router-link|dl-shell$|lenis|sw$|sr-only$)/.test(c)
  const lines = []
  for (const e of document.body.querySelectorAll('*')) {
    if (e.closest('#wpadminbar')) continue
    const cls = [...e.classList].filter((c) => !skip(c))
    if (!cls.length || !e.getClientRects().length) continue
    const r = e.getBoundingClientRect()
    const f = (n) => Math.round(n * 10) / 10
    lines.push(e.tagName.toLowerCase() + '.' + cls.sort().join('.') + ' ' + f(r.left) + ',' + f(r.top + scrollY) + ' ' + f(r.width) + 'x' + f(r.height))
  }
  return { lines, height: document.documentElement.scrollHeight }
})()`

async function main() {
  const profile = mkdtempSync(resolve(tmpdir(), 'dl-chrome-'))
  const chrome = spawn(CHROME, ['--headless=new', `--remote-debugging-port=${PORT}`, `--user-data-dir=${profile}`,
    '--no-first-run', '--no-default-browser-check', '--hide-scrollbars', 'about:blank'], { stdio: 'ignore' })
  const json = async (path, method = 'GET') => (await fetch(`http://127.0.0.1:${PORT}${path}`, { method })).json()
  for (let i = 0; i < 50; i++) { try { await json('/json/version'); break } catch { await sleep(200) } }
  const tab = await json('/json/new?about:blank', 'PUT')
  const ws = new WebSocket(tab.webSocketDebuggerUrl)
  await new Promise((r) => (ws.onopen = r))
  let id = 0
  const pending = new Map()
  const events = []
  ws.onmessage = (m) => {
    const d = JSON.parse(m.data)
    if (d.id && pending.has(d.id)) { pending.get(d.id)(d); pending.delete(d.id) } else events.forEach((f) => f(d))
  }
  const send = (method, params = {}) => new Promise((r) => { const i = ++id; pending.set(i, r); ws.send(JSON.stringify({ id: i, method, params })) })
  await send('Page.enable')
  await send('Runtime.enable')

  async function measure(url, width) {
    await send('Emulation.setDeviceMetricsOverride', { width, height: 900, deviceScaleFactor: 1, mobile: width < 700 })
    const loaded = new Promise((r) => {
      const f = (d) => { if (d.method === 'Page.loadEventFired') { events.splice(events.indexOf(f), 1); r() } }
      events.push(f)
    })
    await send('Page.navigate', { url })
    await Promise.race([loaded, sleep(30000)])
    const res = await send('Runtime.evaluate', { expression: MEASURE, awaitPromise: true, returnByValue: true })
    return res.result?.result?.value || { lines: [], height: 0 }
  }

  let paths = process.argv.slice(2)
  if (!paths.length) {
    const here = dirname(fileURLToPath(import.meta.url))
    const c = JSON.parse(readFileSync(resolve(here, '../chantier/data/content.json'), 'utf8'))
    paths = ['/', '/entreprises/', '/creation-dentreprise/', '/particuliers/', '/a-propos/', '/contact/', '/articles/',
      '/offres-demploi/', '/photos-a-fournir/', ...c.services.map((s) => s.slug)]
  }

  let bad = 0
  for (const p of paths) {
    for (const w of WIDTHS) {
      const n = await measure(NUXT + p, w)
      const m = await measure(WP + p, w)
      const slug = `${p.replace(/\//g, '_') || '_'}${w}`
      const a = resolve(out, `${slug}.nuxt.txt`)
      const b = resolve(out, `${slug}.wp.txt`)
      writeFileSync(a, n.lines.join('\n') + '\n')
      writeFileSync(b, m.lines.join('\n') + '\n')
      let diff = ''
      try { execSync(`diff -u "${a}" "${b}"`, { encoding: 'utf8' }) } catch (e) { diff = e.stdout }
      const changed = diff.split('\n').filter((l) => /^[+-][^+-]/.test(l)).length
      if (changed) { bad++; writeFileSync(resolve(out, `${slug}.diff`), diff) }
      console.log(`${changed ? '✗' : '✓'} ${p} @${w}  ${n.lines.length} boxes, height ${n.height} / ${m.height}${changed ? `, ${changed} differing` : ''}`)
    }
  }
  console.log(`\n${paths.length * WIDTHS.length - bad}/${paths.length * WIDTHS.length} identical. Diffs in ${out}`)
  ws.close()
  chrome.kill()
  await sleep(300)
  rmSync(profile, { recursive: true, force: true })
}

main()
