/* Dilytics: conversion tracking, the one place the site talks to the dataLayer.
 *
 * Google Tag Manager (GTM4WP) reads window.dataLayer; every tag lives in GTM
 * (container "Dilytics 2026"). Each event is pushed from a single place, so
 * nothing is counted twice. Names are GA4's where GA4 has one (generate_lead,
 * view_item, begin_checkout, purchase), verb_object snake_case otherwise;
 * form_start and form_submit are GA4-reserved, hence lead_form_*.
 *
 *   lead_form_view   half of a form on screen, once          form_id, form_name
 *   lead_form_start  first field touched in a form           form_id, form_name
 *   lead_form_submit a send attempt                          form_id, form_name
 *   lead_form_error  a form the server refused               form_id, form_name, error_type
 *   generate_lead    a message sent (site.js, once each)     form_id, form_name, lead_source, lead_id,
 *                                                            subject, user_data (Ads and Meta matching)
 *   click_phone      a tel: link                             link_url, link_location
 *   click_email      a mailto: link                          link_url, link_location
 *   click_booking    a link to the booking page              link_url, link_location, booking_provider
 *   click_contact    a link to the contact page              link_url, link_location
 *   click_social     a link to a social network              link_url, link_location, social_network
 *   select_booking_time  a date and time picked in a Calendly embed, once per page  booking_provider
 *   book_appointment an appointment booked in a Calendly embed, once per booking   booking_provider, booking_id (Ads order id)
 *   view_item        a service page                          ecommerce
 *   begin_checkout   a "Payer en ligne" button (Stripe)      ecommerce
 *   purchase         the page Stripe sends back to, once per payment   ecommerce (+ transaction_id)
 *
 * Every event also carries the page's context, pushed in the head before GTM
 * (includes/assets.php): page_type, and service_id, service_name,
 * service_category, those of the page or, on any other page, of the last
 * service seen in the visit (on /contact/: the service the visitor writes
 * about). The form events (lead_form_*, generate_lead) come from site.js.
 *
 * link_location is the section the link sits in (its scope class: site-nav
 * for the header, site-foot for the footer…). lead_id (random, one per message
 * sent) is Google Ads' transaction id; transaction_id (Stripe's Checkout
 * session) is GA4's purchase id. The services (window.DLItems: id = page
 * slug, price and payment link for those paid online) come from
 * includes/assets.php. */
(function () {
  'use strict'

  var dl = (window.dataLayer = window.dataLayer || [])
  var push = (window.dlTrack = function (event, params) {
    var o = { event: event }
    for (var k in params) if (params[k] !== undefined && params[k] !== '') o[k] = params[k]
    dl.push(o)
  })
  // an ecommerce event: the previous ecommerce object is cleared first
  var shop = function (event, ecommerce) {
    dl.push({ ecommerce: null })
    push(event, { ecommerce: ecommerce })
  }

  // once per id in this browser: a reload or a back button does not count again
  var once = function (key) {
    try {
      if (window.localStorage.getItem(key)) return false
      window.localStorage.setItem(key, '1')
    } catch (e) {}
    return true
  }

  // where on the page a link sits: the section's scope class (v-price-block, v-site-foot…)
  var zone = function (el) {
    for (var n = el; n && n !== document.body; n = n.parentElement) {
      var c = (n.className && n.className.baseVal === undefined ? n.className : '').split(/\s+/)
      for (var i = 0; i < c.length; i++) if (c[i].indexOf('v-') === 0) return c[i].slice(2)
    }
    return 'page'
  }

  // GA4's client id (_ga) and session id (_ga_<stream>), as a Stripe
  // client_reference_id (letters, digits, - and _ only): ga_<cid>_<sid>
  var gaRef = function () {
    var c = document.cookie
    var cid = (c.match(/(?:^|; )_ga=GA\d\.\d\.(\d+\.\d+)/) || [])[1]
    if (!cid) return ''
    var s = (c.match(/(?:^|; )_ga_[A-Z0-9]+=([^;]+)/) || [])[1] || ''
    // GS1.1.<sid>.… (older) or GS2.1.s<sid>$o…$g… (current)
    var sid = (s.match(/^GS1\.\d\.(\d+)/) || s.match(/[.$]s(\d+)/) || [])[1]
    return 'ga_' + cid.replace('.', '-') + (sid ? '_' + sid : '')
  }

  var items = window.DLItems || []
  var itemFor = function (key) {
    for (var i = 0; i < items.length; i++) if (items[i].id === key || (items[i].url && items[i].url === key)) return items[i]
    return null
  }
  // GA4's ecommerce object for one service; value and currency only when it has a price
  var ecommerce = function (it, extra) {
    var line = { item_id: it.id, item_name: it.name, item_category: it.category, quantity: 1 }
    var e = { items: [line] }
    if (it.price) {
      line.price = it.price
      e.currency = 'CHF'
      e.value = it.price
      e.tax = Math.round(it.price * 8.1) / 100
    }
    for (var k in extra) e[k] = extra[k]
    return e
  }

  document.addEventListener('click', function (e) {
    var a = e.target && e.target.closest ? e.target.closest('a[href]') : null
    if (!a) return
    var href = a.getAttribute('href') || ''
    var link = { link_url: a.href, link_location: zone(a) }
    if (href.indexOf('tel:') === 0) {
      push('click_phone', link)
    } else if (href.indexOf('mailto:') === 0) {
      push('click_email', link)
    } else if (/outlook\.office365\.com\/owa\/calendar|calendly\.com/.test(href)) {
      link.booking_provider = /calendly/.test(href) ? 'calendly' : 'microsoft_bookings'
      push('click_booking', link)
    } else if (a.host === window.location.host && /^\/contact\/?$/.test(a.pathname)) {
      push('click_contact', link)
    } else if (/(linkedin|instagram|facebook)\.com$/.test(a.hostname)) {
      link.social_network = a.hostname.match(/(linkedin|instagram|facebook)\.com$/)[1]
      push('click_social', link)
    } else if (/buy\.stripe\.com/.test(href)) {
      var it = itemFor(href.split('?')[0])
      if (it) shop('begin_checkout', ecommerce(it))
      // Stripe carries the visitor's GA4 ids to the webhook, which sends the
      // purchase from the server too (includes/stripe.php): only when GA's
      // cookies exist, i.e. the visitor accepted statistics
      var ref = gaRef()
      if (ref) a.href = href.split('?')[0] + '?client_reference_id=' + ref
    }
  }, true)

  // Calendly's embeds post their steps to the page: the booking itself counts,
  // and the slot picked before it shows where visitors give up (GA4 only)
  var picked = false
  window.addEventListener('message', function (e) {
    if (!/\.calendly\.com$/.test(String(e.origin).replace(/^https?:\/\//, '.')) || !e.data) return
    if (e.data.event === 'calendly.date_and_time_selected' && !picked) {
      picked = true
      push('select_booking_time', { booking_provider: 'calendly' })
      return
    }
    if (e.data.event !== 'calendly.event_scheduled') return
    var uri = e.data.payload && e.data.payload.invitee && e.data.payload.invitee.uri
    if (uri && !once('dl_booked_' + uri)) return
    // booking_id: the invitee's id, the order id Google Ads deduplicates on
    push('book_appointment', { booking_provider: 'calendly', booking_id: uri ? uri.split('/').pop() : undefined })
  })

  // a service page: the service seen
  var here = itemFor(window.location.pathname.replace(/^\/+|\/+$/g, ''))
  if (here) shop('view_item', ecommerce(here))

  // the page Stripe sends back to after a payment: ?item=…&session_id=cs_…
  var q = new URLSearchParams(window.location.search)
  var session = q.get('session_id')
  var bought = itemFor(q.get('item') || '')
  if (session && /^cs_/.test(session) && bought && bought.price && once('dl_tx_' + session)) {
    shop('purchase', ecommerce(bought, { transaction_id: session }))
  }
})()
