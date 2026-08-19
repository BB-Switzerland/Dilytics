import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import Lenis from 'lenis'
import { reactive } from 'vue'

// The site's motion engine.
//
// Lenis owns the scroll position, the GSAP ticker drives Lenis, and
// ScrollTrigger is updated from Lenis — one clock, so a scrubbed animation can
// never drift away from the page under it.
//
// Nothing here hides content for good: every entrance is a `from` tween, so an
// element whose tween never runs simply stays where the server rendered it.

gsap.registerPlugin(ScrollTrigger)

const FROM = {
  up: { y: 74, opacity: 0, scale: 0.975 },
  // body copy: a short lift, because a paragraph that travels as far as a
  // headline reads as noise inside a column of running text
  text: { y: 24, opacity: 0 },
  fade: { opacity: 0 },
  left: { x: -68, opacity: 0 },
  right: { x: 68, opacity: 0 },
  blur: { y: 48, opacity: 0, filter: 'blur(14px)' },
  zoom: { scale: 1.16, opacity: 0, clipPath: 'inset(0 0 46% 0)' },
}
const TO = {
  up: { y: 0, opacity: 1, scale: 1, duration: 1.05 },
  text: { y: 0, opacity: 1, duration: 0.85 },
  fade: { opacity: 1, duration: 0.9 },
  left: { x: 0, opacity: 1, duration: 1.05 },
  right: { x: 0, opacity: 1, duration: 1.05 },
  blur: { y: 0, opacity: 1, filter: 'blur(0px)', duration: 1.15 },
  zoom: { scale: 1, opacity: 1, clipPath: 'inset(0 0 0% 0)', duration: 1.5 },
}

const esc = (s) => s.replace(/&/g, '&amp;').replace(/</g, '&lt;')

// Wrap every visual line of a heading in its own clipping box, so the lines can
// rise out from under each other. Returns null when the element holds markup we
// would destroy — the caller then falls back to a whole-block reveal.
function splitLines(el) {
  if (el.querySelector('*') || !el.textContent.trim()) return null

  const words = el.textContent.trim().split(/\s+/)
  el.innerHTML = words.map((w) => `<span class="sw">${esc(w)}</span>`).join(' ')

  const rows = []
  let top = null
  for (const s of el.querySelectorAll('.sw')) {
    const t = Math.round(s.offsetTop)
    if (top === null || t > top + 3) {
      rows.push([])
      top = t
    }
    rows[rows.length - 1].push(s.textContent)
  }

  el.innerHTML = rows.map((r) => `<span class="sl"><i>${esc(r.join(' '))}</i></span>`).join('')
  return [...el.querySelectorAll('.sl > i')]
}

// Wrap every word in its own span while leaving the inline markup around it
// intact, so a sentence that carries a coloured phrase survives the split.
function splitWords(el) {
  const out = []
  const walk = (node) => {
    for (const child of [...node.childNodes]) {
      if (child.nodeType === 3) {
        const frag = document.createDocumentFragment()
        for (const part of child.textContent.split(/(\s+)/)) {
          if (!part) continue
          if (/^\s+$/.test(part)) {
            frag.appendChild(document.createTextNode(part))
          } else {
            const s = document.createElement('span')
            s.className = 'wd'
            s.textContent = part
            frag.appendChild(s)
            out.push(s)
          }
        }
        child.replaceWith(frag)
      } else if (child.nodeType === 1 && !child.classList.contains('wd')) {
        walk(child)
      }
    }
  }
  walk(el)
  return out
}

export default defineNuxtPlugin((nuxtApp) => {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  const scroll = reactive({ y: 0, dir: 1, velocity: 0, progress: 0 })
  let lenis = null

  /* ---------------------------------------------------------- scroll clock */
  if (reduce) {
    const read = () => {
      const lim = document.documentElement.scrollHeight - window.innerHeight
      scroll.y = window.scrollY
      scroll.progress = lim > 0 ? Math.min(scroll.y / lim, 1) : 0
    }
    window.addEventListener('scroll', read, { passive: true })
    read()
  } else {
    lenis = new Lenis({
      lerp: 0.085,
      wheelMultiplier: 1,
      smoothWheel: true,
      syncTouch: false, // phones keep their native, momentum-perfect scroll
    })

    lenis.on('scroll', (e) => {
      scroll.y = e.scroll
      scroll.velocity = e.velocity
      scroll.progress = e.progress
      if (Math.abs(e.velocity) > 0.08) scroll.dir = e.direction
      ScrollTrigger.update()
    })

    gsap.ticker.add((t) => lenis.raf(t * 1000))
    gsap.ticker.lagSmoothing(0)
  }

  /* ------------------------------------------------------------- entrances */
  function reveal(el) {
    const mode = el.dataset.rv || 'up'
    const delay = Math.min(Number(el.dataset.rvd) || 0, 40) * 0.014
    const trig = { trigger: el, start: 'top 88%', once: true }

    if (mode === 'rule') {
      return gsap.fromTo(el, { scaleX: 0 }, {
        scaleX: 1, duration: 1.25, ease: 'expo.out', delay, scrollTrigger: trig,
      })
    }

    if (mode === 'mask') {
      const lines = splitLines(el)
      if (lines) {
        return gsap.from(lines, {
          yPercent: 118,
          duration: 1.15,
          ease: 'expo.out',
          stagger: 0.075,
          delay,
          scrollTrigger: trig,
        })
      }
      return gsap.fromTo(
        el,
        { opacity: 0, y: 32, clipPath: 'inset(0 0 100% 0)' },
        {
          opacity: 1, y: 0, clipPath: 'inset(0 0 0% 0)',
          duration: 1.1, ease: 'expo.out', delay, scrollTrigger: trig,
        },
      )
    }

    const from = FROM[mode] || FROM.up
    const to = TO[mode] || TO.up
    return gsap.fromTo(el, from, { ...to, ease: 'expo.out', delay, scrollTrigger: trig })
  }

  // A stagger group: the container animates its own children in sequence, which
  // reads far better than each child firing on its own trigger.
  function group(el) {
    const kids = [...el.children]
    if (!kids.length) return null
    return gsap.from(kids, {
      y: 58,
      opacity: 0,
      duration: 1,
      ease: 'expo.out',
      stagger: Math.min(0.09, 0.5 / kids.length),
      scrollTrigger: { trigger: el, start: 'top 86%', once: true },
    })
  }

  // A statement that lights up word by word as the reader goes through it. The
  // scrub ties it to the scroll itself, so the reading pace is theirs.
  function lit(el) {
    const words = splitWords(el)
    if (!words.length) return null
    gsap.set(el, { opacity: 1 })
    gsap.set(words, { opacity: 0.13 })
    return gsap.to(words, {
      opacity: 1,
      ease: 'none',
      stagger: 0.6,
      scrollTrigger: { trigger: el, start: 'top 76%', end: 'bottom 58%', scrub: 0.35 },
    })
  }

  // A card that leans under the cursor. Small angles only — past about three
  // degrees it stops reading as depth and starts reading as a gimmick.
  function tilt(el) {
    if (window.matchMedia('(hover: none)').matches) return null
    // rotation only: the reveal tweens own `y` on these same elements
    const rx = gsap.quickTo(el, 'rotationX', { duration: 0.6, ease: 'power3.out' })
    const ry = gsap.quickTo(el, 'rotationY', { duration: 0.6, ease: 'power3.out' })
    gsap.set(el, { transformPerspective: 1000 })

    const move = (e) => {
      const r = el.getBoundingClientRect()
      rx(((e.clientY - r.top) / r.height - 0.5) * -4.5)
      ry(((e.clientX - r.left) / r.width - 0.5) * 4.5)
    }
    const off = () => {
      rx(0)
      ry(0)
    }
    el.addEventListener('mousemove', move)
    el.addEventListener('mouseleave', off)
    el.__tiltOff = () => {
      el.removeEventListener('mousemove', move)
      el.removeEventListener('mouseleave', off)
    }
    return null
  }

  /* -------------------------------------------------------------- parallax */
  function parallax(el) {
    const amp = Number(el.dataset.px) || 14
    const box = el.parentElement || el
    gsap.set(el, { scale: 1 + Math.min(amp, 26) / 100, willChange: 'transform' })
    return gsap.fromTo(
      el,
      { yPercent: -amp / 2 },
      {
        yPercent: amp / 2,
        ease: 'none',
        scrollTrigger: { trigger: box, start: 'top bottom', end: 'bottom top', scrub: 0.55 },
      },
    )
  }

  /* ------------------------------------------------- batched registration */
  const queue = new Set()
  let pending = false
  let armed = false

  function build(el) {
    if (el.__mo || !el.isConnected) return
    const kind = el.__moKind
    const make =
      kind === 'px' ? parallax : kind === 'group' ? group : kind === 'lit' ? lit : kind === 'tilt' ? tilt : reveal
    const tween = make(el)
    if (tween) el.__mo = tween
  }

  function flush() {
    pending = false
    for (const el of queue) build(el)
    queue.clear()
    // The pre-paint guard exists only so the first screen never flashes its
    // content before the tweens take hold. Past the first pass, elements mount
    // inside a frame we own, so it is no longer needed.
    if (!armed) {
      armed = true
      document.documentElement.classList.remove('mo')
    }
    ScrollTrigger.refresh()
  }

  function enlist(el, kind) {
    if (reduce) return
    el.__moKind = kind
    queue.add(el)
    if (pending) return
    pending = true
    requestAnimationFrame(flush)
  }

  function retire(el) {
    queue.delete(el)
    el.__tiltOff?.()
    if (!el.__mo) return
    el.__mo.scrollTrigger?.kill()
    el.__mo.kill()
    el.__mo = null
  }

  /* ------------------------------------------------------------ directives */
  const app = nuxtApp.vueApp

  // v-rv="'up'|'fade'|'left'|'right'|'blur'|'zoom'|'mask'", v-rv:12 to delay
  app.directive('rv', {
    mounted(el, binding) {
      const mode = binding.value || 'up'
      if (mode === 'flag') return
      if (!el.dataset.rv) el.dataset.rv = mode
      if (binding.arg && !el.dataset.rvd) el.dataset.rvd = String(binding.arg)
      enlist(el, 'rv')
    },
    unmounted: retire,
  })

  // v-stagger on a container: its direct children come in one after the other
  app.directive('stagger', {
    mounted(el) {
      enlist(el, 'group')
    },
    unmounted: retire,
  })

  // v-lit on a statement: its words brighten one by one, tied to the scroll
  app.directive('lit', {
    mounted(el) {
      enlist(el, 'lit')
    },
    unmounted: retire,
  })

  // v-tilt on a card: it leans under the cursor
  app.directive('tilt', {
    mounted(el) {
      enlist(el, 'tilt')
    },
    unmounted: retire,
  })

  // v-px="16" scroll-linked drift, scaled just enough to keep the frame covered
  app.directive('px', {
    mounted(el, binding) {
      el.dataset.px = String(binding.value ?? 14)
      enlist(el, 'px')
    },
    unmounted: retire,
  })

  // v-mag: the button leans towards the cursor, then springs back
  app.directive('mag', {
    mounted(el, binding) {
      if (reduce || window.matchMedia('(hover: none)').matches) return
      const pull = Number(binding.value) || 0.28
      const move = (e) => {
        const r = el.getBoundingClientRect()
        gsap.to(el, {
          x: (e.clientX - r.left - r.width / 2) * pull,
          y: (e.clientY - r.top - r.height / 2) * pull,
          duration: 0.55,
          ease: 'power3.out',
        })
      }
      const off = () => gsap.to(el, { x: 0, y: 0, duration: 0.9, ease: 'elastic.out(1, .45)' })
      el.addEventListener('mousemove', move)
      el.addEventListener('mouseleave', off)
      el.__magOff = () => {
        el.removeEventListener('mousemove', move)
        el.removeEventListener('mouseleave', off)
      }
    },
    unmounted(el) {
      el.__magOff?.()
      gsap.killTweensOf(el)
    },
  })

  /* ----------------------------------------------------------- page cycles */
  nuxtApp.hook('page:finish', () => {
    lenis?.scrollTo(0, { immediate: true, force: true })
    requestAnimationFrame(() => ScrollTrigger.refresh())
  })

  nuxtApp.hook('app:mounted', () => {
    // Fonts and images change every measurement they touch.
    window.addEventListener('load', () => ScrollTrigger.refresh())
    document.fonts?.ready.then(() => ScrollTrigger.refresh())
    setTimeout(() => document.documentElement.classList.remove('mo'), 1200)
  })

  return {
    provide: {
      motion: {
        gsap,
        ScrollTrigger,
        lenis,
        scroll,
        reduce,
        // Components register their own timelines through this, so they are
        // measured on the same clock and cleaned up the same way.
        ctx: (fn, scope) => gsap.context(fn, scope),
      },
    },
  }
})
