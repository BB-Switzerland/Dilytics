/* Dilytics: motion engine and component behaviours.
 *
 * A port of the Nuxt site's app/plugins/motion.client.js and of the scripts of
 * its components, driven by the same attributes the server renders:
 *   data-rv="up|text|fade|left|right|blur|zoom|mask|rule" (+ data-rvd delay)
 *   data-stagger, data-lit, data-tilt, data-px="16", data-mag
 * and by each component's own markup. Timings, eases and trigger positions are
 * the Nuxt ones, value for value.
 *
 * Lenis owns the scroll position, the GSAP ticker drives Lenis and
 * ScrollTrigger is updated from Lenis: one clock for everything.
 * Nothing hides content for good: every entrance is a `from` tween. */
(function () {
  'use strict'

  var doc = document.documentElement
  var gsap = window.gsap
  var ScrollTrigger = window.ScrollTrigger
  var Lenis = window.Lenis
  // in Beaver Builder's editor the page stays still: treated like reduced motion
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches || !!window.DLEditing
  var noHover = function () { return window.matchMedia('(hover: none)').matches }
  var hasMotion = !!(gsap && ScrollTrigger)

  var $ = function (sel, root) { return (root || document).querySelector(sel) }
  var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)) }
  var raf = function (fn) { return window.requestAnimationFrame(fn) }

  /* ------------------------------------------------------------ scroll clock */
  var scroll = { y: 0, dir: 1, velocity: 0, progress: 0 }
  var listeners = []
  var onScroll = function (fn) { listeners.push(fn); fn(scroll) }
  var emit = function () { for (var i = 0; i < listeners.length; i++) listeners[i](scroll) }
  var lenis = null

  if (hasMotion) gsap.registerPlugin(ScrollTrigger)

  if (reduce || !hasMotion || !Lenis) {
    var read = function () {
      var lim = doc.scrollHeight - window.innerHeight
      scroll.y = window.scrollY
      scroll.progress = lim > 0 ? Math.min(scroll.y / lim, 1) : 0
      emit()
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
    lenis.on('scroll', function (e) {
      scroll.y = e.scroll
      scroll.velocity = e.velocity
      scroll.progress = e.progress
      if (Math.abs(e.velocity) > 0.08) scroll.dir = e.direction
      ScrollTrigger.update()
      emit()
    })
    gsap.ticker.add(function (t) { lenis.raf(t * 1000) })
    gsap.ticker.lagSmoothing(0)
  }

  /* --------------------------------------------------------------- entrances */
  var FROM = {
    up: { y: 74, opacity: 0, scale: 0.975 },
    text: { y: 24, opacity: 0 },
    fade: { opacity: 0 },
    left: { x: -68, opacity: 0 },
    right: { x: 68, opacity: 0 },
    blur: { y: 48, opacity: 0, filter: 'blur(14px)' },
    zoom: { scale: 1.16, opacity: 0, clipPath: 'inset(0 0 46% 0)' },
  }
  var TO = {
    up: { y: 0, opacity: 1, scale: 1, duration: 1.05 },
    text: { y: 0, opacity: 1, duration: 0.85 },
    fade: { opacity: 1, duration: 0.9 },
    left: { x: 0, opacity: 1, duration: 1.05 },
    right: { x: 0, opacity: 1, duration: 1.05 },
    blur: { y: 0, opacity: 1, filter: 'blur(0px)', duration: 1.15 },
    zoom: { scale: 1, opacity: 1, clipPath: 'inset(0 0 0% 0)', duration: 1.5 },
  }
  var assign = function (a, b) { var o = {}, k; for (k in a) o[k] = a[k]; for (k in b) o[k] = b[k]; return o }
  var esc = function (s) { return s.replace(/&/g, '&amp;').replace(/</g, '&lt;') }

  // every visual line of a heading in its own clipping box
  function splitLines(el) {
    if (el.querySelector('*') || !el.textContent.trim()) return null
    var words = el.textContent.trim().split(/\s+/)
    el.innerHTML = words.map(function (w) { return '<span class="sw">' + esc(w) + '</span>' }).join(' ')
    var rows = []
    var top = null
    $$('.sw', el).forEach(function (s) {
      var t = Math.round(s.offsetTop)
      if (top === null || t > top + 3) { rows.push([]); top = t }
      rows[rows.length - 1].push(s.textContent)
    })
    el.innerHTML = rows.map(function (r) { return '<span class="sl"><i>' + esc(r.join(' ')) + '</i></span>' }).join('')
    return $$('.sl > i', el)
  }

  // every word in its own span, inline markup left intact
  function splitWords(el) {
    var out = []
    var walk = function (node) {
      Array.prototype.slice.call(node.childNodes).forEach(function (child) {
        if (child.nodeType === 3) {
          var frag = document.createDocumentFragment()
          child.textContent.split(/(\s+)/).forEach(function (part) {
            if (!part) return
            if (/^\s+$/.test(part)) {
              frag.appendChild(document.createTextNode(part))
            } else {
              var s = document.createElement('span')
              s.className = 'wd'
              s.textContent = part
              frag.appendChild(s)
              out.push(s)
            }
          })
          child.parentNode.replaceChild(frag, child)
        } else if (child.nodeType === 1 && !child.classList.contains('wd')) {
          walk(child)
        }
      })
    }
    walk(el)
    return out
  }

  function reveal(el) {
    var mode = el.dataset.rv || 'up'
    var delay = Math.min(Number(el.dataset.rvd) || 0, 40) * 0.014
    var trig = { trigger: el, start: 'top 88%', once: true }

    if (mode === 'rule') {
      return gsap.fromTo(el, { scaleX: 0 }, { scaleX: 1, duration: 1.25, ease: 'expo.out', delay: delay, scrollTrigger: trig })
    }
    if (mode === 'mask') {
      var lines = splitLines(el)
      if (lines) {
        return gsap.from(lines, { yPercent: 118, duration: 1.15, ease: 'expo.out', stagger: 0.075, delay: delay, scrollTrigger: trig })
      }
      return gsap.fromTo(el,
        { opacity: 0, y: 32, clipPath: 'inset(0 0 100% 0)' },
        { opacity: 1, y: 0, clipPath: 'inset(0 0 0% 0)', duration: 1.1, ease: 'expo.out', delay: delay, scrollTrigger: trig })
    }
    var from = FROM[mode] || FROM.up
    var to = TO[mode] || TO.up
    return gsap.fromTo(el, from, assign(to, { ease: 'expo.out', delay: delay, scrollTrigger: trig }))
  }

  function group(el) {
    var kids = Array.prototype.slice.call(el.children)
    if (!kids.length) return null
    return gsap.from(kids, {
      y: 58, opacity: 0, duration: 1, ease: 'expo.out',
      stagger: Math.min(0.09, 0.5 / kids.length),
      scrollTrigger: { trigger: el, start: 'top 86%', once: true },
    })
  }

  function lit(el) {
    var words = splitWords(el)
    if (!words.length) return null
    gsap.set(el, { opacity: 1 })
    gsap.set(words, { opacity: 0.13 })
    return gsap.to(words, {
      opacity: 1, ease: 'none', stagger: 0.6,
      scrollTrigger: { trigger: el, start: 'top 76%', end: 'bottom 58%', scrub: 0.35 },
    })
  }

  function tilt(el) {
    if (noHover()) return null
    var rx = gsap.quickTo(el, 'rotationX', { duration: 0.6, ease: 'power3.out' })
    var ry = gsap.quickTo(el, 'rotationY', { duration: 0.6, ease: 'power3.out' })
    gsap.set(el, { transformPerspective: 1000 })
    el.addEventListener('mousemove', function (e) {
      var r = el.getBoundingClientRect()
      rx(((e.clientY - r.top) / r.height - 0.5) * -4.5)
      ry(((e.clientX - r.left) / r.width - 0.5) * 4.5)
    })
    el.addEventListener('mouseleave', function () { rx(0); ry(0) })
    return null
  }

  function parallax(el) {
    var amp = Number(el.dataset.px) || 14
    var box = el.parentElement || el
    gsap.set(el, { scale: 1 + Math.min(amp, 26) / 100, willChange: 'transform' })
    return gsap.fromTo(el, { yPercent: -amp / 2 }, {
      yPercent: amp / 2, ease: 'none',
      scrollTrigger: { trigger: box, start: 'top bottom', end: 'bottom top', scrub: 0.55 },
    })
  }

  function magnet(el) {
    if (reduce || noHover()) return
    var pull = Number(el.dataset.mag) || 0.28
    el.addEventListener('mousemove', function (e) {
      var r = el.getBoundingClientRect()
      gsap.to(el, {
        x: (e.clientX - r.left - r.width / 2) * pull,
        y: (e.clientY - r.top - r.height / 2) * pull,
        duration: 0.55, ease: 'power3.out',
      })
    })
    // settles back without overshooting: a bounce makes a button feel fussy
    el.addEventListener('mouseleave', function () {
      gsap.to(el, { x: 0, y: 0, duration: 0.9, ease: 'power3.out' })
    })
  }

  /* ------------------------------------------------ components, on mount
     What the Nuxt components run in their own onMounted, synchronously, before
     the directives are flushed: the pre-paint guard is still up. */

  // Head3: each line of a display headline rises out of its clip
  function heads() {
    $$('[data-hd]').forEach(function (el) {
      if (el.hasAttribute('data-hold')) return
      gsap.context(function () {
        gsap.from(el.querySelectorAll('.ln > i'), {
          yPercent: 118, duration: 1.25, ease: 'expo.out', stagger: 0.085,
          delay: el.dataset.delay !== undefined ? Number(el.dataset.delay) : 0.1,
          scrollTrigger: el.dataset.mode === 'scroll' ? { trigger: el, start: 'top 86%', once: true } : undefined,
        })
      }, el)
    })
  }

  // HomeOpen: the opening timeline and the two scrubbed drifts
  function homeOpen() {
    var root = $('.hero.v-home-open')
    if (!root) return
    gsap.context(function () {
      var tl = gsap.timeline({ defaults: { ease: 'expo.out' } })
      tl.from('.bg', { clipPath: 'inset(100% 0 0 0)', duration: 1.6 }, 0)
        .from('.bg img', { scale: 1.32, duration: 2 }, 0)
        .from('.scrim', { opacity: 0, duration: 1.4 }, 0.2)
        .from('.ld', { y: 30, opacity: 0, duration: 1 }, 0.72)
        .from('.acts > *', { y: 26, opacity: 0, duration: 0.9, stagger: 0.08 }, 0.84)
        .from('.strip li', { y: 30, opacity: 0, duration: 1, stagger: 0.09 }, 1)
        .from('.rule-top', { scaleX: 0, duration: 1.2, ease: 'power3.out' }, 1)
      gsap.to('.bg img', {
        yPercent: 12, ease: 'none',
        scrollTrigger: { trigger: root, start: 'top top', end: 'bottom top', scrub: 0.6 },
      })
      gsap.to('.inner', {
        yPercent: -14, opacity: 0.25, ease: 'none',
        scrollTrigger: { trigger: root, start: 'top top', end: 'bottom top', scrub: 0.5 },
      })
    }, root)
  }

  /* ---------------------------------------------- components, one frame on
     What the Nuxt components run through useGsap: one frame after mount, so
     layout has settled, followed by a ScrollTrigger refresh. */

  // Counter: the server renders the real figure; it is zeroed only here
  function counters() {
    $$('[data-counter]').forEach(function (el) {
      var to = Number(el.dataset.counter)
      var ms = Number(el.dataset.ms) || 1500
      var box = { n: 0 }
      el.textContent = '0'
      gsap.to(box, {
        n: to, duration: ms / 1000, ease: 'power2.out', snap: { n: 1 },
        onUpdate: function () { el.textContent = String(box.n) },
        onComplete: function () { el.textContent = String(to) },
        scrollTrigger: { trigger: el, start: 'top 88%', once: true },
      })
    })
  }

  // PriceBlock: the figure counts up to itself
  function prices() {
    $$('[data-price]').forEach(function (el) {
      var section = el.closest('.pr') || el
      var raw = el.dataset.price
      var target = Number(raw.replace(/\D/g, '')) || 0
      var grouped = /[^\d]/.test(raw)
      var fmt = function (n) { return grouped ? n.toLocaleString('fr-CH').replace(/\D/g, "'") : String(n) }
      el.textContent = fmt(0)
      var box = { n: 0 }
      gsap.to(box, {
        n: target, duration: 1.6, ease: 'power2.out', snap: { n: 1 },
        onUpdate: function () { el.textContent = fmt(box.n) },
        onComplete: function () { el.textContent = raw },
        scrollTrigger: { trigger: section, start: 'top 82%', once: true },
      })
    })
  }

  // HomeStart: the red line draws through the stages
  function homeStart() {
    $$('.start.v-home-start').forEach(function (root) {
      gsap.context(function () {
        var track = { trigger: '.track', start: 'top 74%', end: 'bottom 72%', scrub: 0.5 }
        gsap.fromTo('.fill', { scaleX: 0 }, { scaleX: 1, ease: 'none', scrollTrigger: track })
        gsap.fromTo('.st', { opacity: 0.3 }, { opacity: 1, ease: 'none', stagger: 0.6, scrollTrigger: track })
      }, root)
    })
  }

  // service guide: the rail keeps your place
  function guideSpy() {
    $$('.guide').forEach(function (guide) {
      var links = $$('.rail nav a', guide)
      $$('.sec', guide).forEach(function (el, i) {
        ScrollTrigger.create({
          trigger: el, start: 'top 42%', end: 'bottom 42%',
          onToggle: function (self) {
            if (self.isActive) links.forEach(function (a, j) { a.classList.toggle('on', i === j) })
          },
        })
      })
    })
  }

  /* ------------------------------------------------- behaviours without gsap */

  function jumpLinks() {
    $$('.guide .rail nav a').forEach(function (a) {
      a.addEventListener('click', function (e) {
        e.preventDefault()
        var el = document.getElementById(a.getAttribute('href').slice(1))
        if (!el) return
        if (lenis) lenis.scrollTo(el, { offset: -110, duration: 1.1 })
        else el.scrollIntoView({ behavior: 'smooth', block: 'start' })
      })
    })
  }

  // FAQ: one answer open at a time, the first one to begin with
  function faqs() {
    $$('.faq').forEach(function (faq) {
      var qs = $$('.q', faq)
      qs.forEach(function (q) {
        var btn = $('button', q)
        btn.addEventListener('click', function () {
          var was = q.classList.contains('on')
          qs.forEach(function (o) {
            o.classList.remove('on')
            $('button', o).setAttribute('aria-expanded', 'false')
          })
          if (!was) {
            q.classList.add('on')
            btn.setAttribute('aria-expanded', 'true')
          }
        })
      })
    })
  }

  // HomeReviews: native scroll snapping moves the slides; the arrows scroll to
  // the previous or next snap point. On a phone each review is a snap point
  // (the slides are display: contents there).
  function reviewSliders() {
    $$('.v-home-reviews .track').forEach(function (track) {
      var box = track.parentElement
      var prev = $('.ctl .prev', box)
      var next = $('.ctl .next', box)
      var ct = $('.ctl .ct', box)
      var at = 0
      var raf = 0
      var stops = function () {
        var s = $$('.slide', track)
        return s.length && getComputedStyle(s[0]).display === 'contents' ? $$('.rv', track) : s
      }
      // a stop's scroll position; the last ones may sit past the end of the track
      var max = function () { return track.scrollWidth - track.clientWidth }
      var pos = function (el) { return Math.min(el.offsetLeft, max()) }
      var sync = function () {
        // an arrow's glide holds the target, so a second click goes one further
        if (raf) return
        var s = stops()
        var best = 0
        s.forEach(function (el, i) {
          if (Math.abs(pos(el) - track.scrollLeft) < Math.abs(pos(s[best]) - track.scrollLeft)) best = i
        })
        at = track.scrollLeft >= max() - 2 ? s.length - 1 : best
        paint(s.length)
      }
      var paint = function (n) {
        ct.textContent = (at + 1) + ' / ' + n
        prev.disabled = at === 0
        next.disabled = at >= n - 1
      }
      // The arrows glide on their own clock, snapping off for the ride: a
      // snapping track catches every frame of a scripted scroll, and the
      // browsers' own smooth scroll stutters or jumps there.
      var halt = function () {
        if (!raf) return
        cancelAnimationFrame(raf)
        raf = 0
        track.style.scrollSnapType = ''
      }
      var glide = function (to) {
        halt()
        var from = track.scrollLeft
        if (reduce) { track.scrollLeft = to; return }
        var t0 = performance.now()
        track.style.scrollSnapType = 'none'
        var step = function (now) {
          var k = Math.min(1, (now - t0) / 800)
          track.scrollLeft = from + (to - from) * (1 - Math.pow(1 - k, 4))
          if (k < 1) raf = requestAnimationFrame(step)
          else { halt(); sync() }
        }
        raf = requestAnimationFrame(step)
      }
      var go = function (d) {
        var s = stops()
        at = Math.min(s.length - 1, Math.max(0, at + d))
        paint(s.length)
        glide(pos(s[at]))
      }
      // a hand on the track takes over from a glide
      var grab = function (e) {
        if (e.type === 'touchstart' || Math.abs(e.deltaX) > Math.abs(e.deltaY)) { halt(); sync() }
      }
      prev.addEventListener('click', function () { go(-1) })
      next.addEventListener('click', function () { go(1) })
      track.addEventListener('wheel', grab, { passive: true })
      track.addEventListener('touchstart', grab, { passive: true })
      track.addEventListener('scroll', sync, { passive: true })
      window.addEventListener('resize', sync)
      sync()
    })
  }

  // ServiceList: the row under the pointer fills, the others dim
  function serviceLists() {
    $$('.stage.v-service-list').forEach(function (stage) {
      var rows = $('.rows', stage)
      var items = $$('.rows > li', stage)
      var set = function (hot) {
        rows.classList.toggle('live', hot > -1)
        items.forEach(function (li, i) { li.classList.toggle('on', i === hot) })
      }
      stage.addEventListener('pointerleave', function () { set(-1) })
      items.forEach(function (li, i) {
        li.addEventListener('pointerenter', function () { set(i) })
        li.addEventListener('focusin', function () { set(i) })
        li.addEventListener('focusout', function () { set(-1) })
      })
    })
  }

  // ScrollBar: on the same smoothed value as everything else
  function scrollBar() {
    var span = $('.bar.v-scroll-bar span')
    if (!span) return
    onScroll(function (s) { span.style.transform = 'scaleX(' + s.progress + ')' })
  }

  // SiteNav: frosted bar, mega panels, sliding underline, mobile drawer
  function nav() {
    var nv = $('header.nv')
    if (!nv) return
    var home = nv.hasAttribute('data-home')
    var bar = $('.mid', nv)
    var mega = $('.mega', nv)
    var mark = $('.mark', nv)
    var triggers = $$('.mid .tg[data-panel]', nv)
    var panels = $$('.mega .mg', nv)
    var drw = $('.drw')
    var burger = $('.bg', nv)
    var open = null
    var drawer = false
    var timer = null

    var paint = function () {
      var stuck = scroll.y > 10
      var gone = scroll.y > 340 && scroll.dir === 1 && !open && !drawer
      nv.classList.toggle('stuck', stuck || !!open)
      nv.classList.toggle('dr', drawer)
      nv.classList.toggle('gone', gone)
      nv.classList.toggle('over', home && !stuck && !open && !drawer)
      triggers.forEach(function (t) {
        var on = t.dataset.panel === open
        t.classList.toggle('on', on)
        t.setAttribute('aria-expanded', on ? 'true' : 'false')
      })
      mega.classList.toggle('on', !!open)
      // inline display, not `hidden`: `.mg { display: grid }` would win over it.
      // Closing empties the panel at once, as the Nuxt v-if does.
      panels.forEach(function (p) { p.style.display = p.dataset.panel === open ? '' : 'none' })
    }
    var place = function () {
      var btn = triggers.filter(function (t) { return t.dataset.panel === open })[0]
      if (!bar || !btn) { mark.classList.remove('on'); return }
      mark.style.transform = 'translateX(' + btn.offsetLeft + 'px) scaleX(' + btn.offsetWidth + ')'
      mark.classList.add('on')
    }
    var show = function (label) {
      clearTimeout(timer)
      open = label
      paint()
      place()
    }
    var hide = function () {
      timer = setTimeout(function () {
        open = null
        mark.classList.remove('on')
        paint()
      }, 140)
    }
    var shut = function () {
      clearTimeout(timer)
      open = null
      mark.classList.remove('on')
      setDrawer(false)
    }
    var setDrawer = function (v) {
      drawer = v
      if (burger) burger.setAttribute('aria-expanded', v ? 'true' : 'false')
      if (drw) drw.classList.toggle('on', v)
      document.body.style.overflow = v ? 'hidden' : ''
      paint()
    }

    triggers.forEach(function (t) {
      t.addEventListener('mouseenter', function () { show(t.dataset.panel) })
      t.addEventListener('focus', function () { show(t.dataset.panel) })
      t.addEventListener('click', shut)
    })
    $$('.mid .flat', nv).forEach(function (a) { a.addEventListener('mouseenter', hide) })
    nv.addEventListener('mouseleave', hide)
    mega.addEventListener('mouseenter', function () { if (open) show(open) })
    $$('.mega a', nv).forEach(function (a) { a.addEventListener('click', shut) })
    if (burger) burger.addEventListener('click', function () { setDrawer(!drawer) })
    window.addEventListener('keydown', function (e) { if (e.key === 'Escape') shut() })

    if (drw) {
      var acc = null
      var gts = $$('button.gt', drw)
      gts.forEach(function (b) {
        b.addEventListener('click', function () {
          acc = acc === b.dataset.acc ? null : b.dataset.acc
          gts.forEach(function (o) {
            var on = o.dataset.acc === acc
            o.setAttribute('aria-expanded', on ? 'true' : 'false')
            $('i', o).classList.toggle('on', on)
            o.nextElementSibling.classList.toggle('on', on)
          })
        })
      })
      $$('a', drw).forEach(function (a) { a.addEventListener('click', shut) })
    }

    onScroll(paint)
  }

  // Forms: posted to Contact Form 7's REST endpoint (includes/contact.php),
  // which validates, mails and files them. Tracking (track.js): form_start at
  // the first field touched, generate_lead once per message sent, form_error
  // when the server refuses it.
  var loaded = Date.now()
  var track = function (event, params) { if (window.dlTrack) window.dlTrack(event, params) }
  function forms() {
    $$('form[data-cf7]').forEach(function (form) {
      var box = form.parentElement
      var done = box.querySelector('.done')
      var err = form.querySelector('.err')
      var btn = form.querySelector('button[type="submit"]')
      var name = form.dataset.form
      var busy = false
      var started = false
      var val = function (n) { var f = form.elements[n]; return f ? f.value.trim() : '' }
      var valid = function () {
        return !!(val('your-name') && val('your-email').indexOf('@') > -1 && val('your-message').length > 8)
      }
      var sync = function () { btn.disabled = busy || !valid() }
      var fail = function (type, message) {
        track('form_error', { form_name: name, error_type: type })
        err.textContent = message || err.dataset.fallback
        err.style.display = ''
      }
      err.dataset.fallback = "L'envoi n'a pas abouti. Réessayez dans un instant, ou écrivez-nous directement."
      // the first field touched: focus, or typing when the focus event is missed
      var start = function () {
        if (started) return
        started = true
        track('form_start', { form_name: name })
      }
      form.addEventListener('focusin', start)
      form.addEventListener('input', start)
      form.addEventListener('input', sync)
      form.addEventListener('change', sync)
      sync()
      form.addEventListener('submit', function (e) {
        e.preventDefault()
        if (busy || !valid()) return
        busy = true
        sync()
        err.style.display = 'none'
        var data = new FormData(form)
        data.set('hp-t', String(Math.round((Date.now() - loaded) / 1000)))
        data.set('_wpcf7', form.dataset.cf7)
        data.set('_wpcf7_unit_tag', 'wpcf7-f' + form.dataset.cf7 + '-o1')
        data.set('_wpcf7_container_post', form.dataset.post || '0')
        data.set('_wpcf7_locale', 'fr_FR')
        fetch(form.dataset.endpoint, { method: 'POST', body: data, credentials: 'omit' })
          .then(function (r) { return r.json() })
          .then(function (res) {
            if (res.status === 'mail_sent') {
              track('generate_lead', {
                form_name: name,
                form_id: form.dataset.cf7,
                lead_id: res.posted_data_hash || '',
                subject: val('your-subject') || undefined
              })
              form.style.display = 'none'
              if (done) done.style.display = ''
            } else if (res.status === 'validation_failed' && res.invalid_fields && res.invalid_fields[0]) {
              fail('validation', res.invalid_fields[0].message)
            } else {
              fail(res.status || 'unknown')
            }
          })
          .catch(function () { fail('network') })
          .then(function () { busy = false; sync() })
      })
      if (done) {
        var again = done.querySelector('button')
        if (again) again.addEventListener('click', function () {
          form.reset()
          started = false
          sync()
          done.style.display = 'none'
          form.style.display = ''
        })
      }
    })
  }

  /* ------------------------------------------------------------------- boot */
  function boot() {
    // behaviours that do not need the engine
    scrollBar()
    nav()
    faqs()
    reviewSliders()
    serviceLists()
    jumpLinks()
    forms()

    if (!hasMotion || reduce) {
      doc.classList.remove('mo')
      return
    }

    // components' own onMounted work
    heads()
    homeOpen()

    // directives, flushed in one frame as the Nuxt engine does
    raf(function () {
      $$('[data-px]').forEach(function (el) { el.__mo = parallax(el) })
      $$('[data-stagger]').forEach(function (el) { el.__mo = group(el) })
      $$('[data-lit]').forEach(function (el) { el.__mo = lit(el) })
      $$('[data-tilt]').forEach(tilt)
      $$('[data-rv]').forEach(function (el) {
        // The Nuxt engine keeps one kind per element, the last directive
        // declared: a card with v-rv then v-tilt only tilts. Same here.
        if (el.dataset.rv === 'flag' || el.hasAttribute('data-tilt')) return
        el.__mo = reveal(el)
      })
      $$('[data-mag]').forEach(magnet)
      doc.classList.remove('mo')
      ScrollTrigger.refresh()

      // what useGsap runs, one frame after mount
      raf(function () {
        counters()
        prices()
        homeStart()
        guideSpy()
        ScrollTrigger.refresh()
      })
    })

    // fonts and images change every measurement they touch
    window.addEventListener('load', function () { ScrollTrigger.refresh() })
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { ScrollTrigger.refresh() })
    setTimeout(function () { doc.classList.remove('mo') }, 1200)
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot)
  else boot()
})()
