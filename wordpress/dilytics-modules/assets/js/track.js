/* Dilytics: conversion tracking, the one place the site talks to the dataLayer.
 *
 * Google Tag Manager (GTM4WP) reads window.dataLayer; every tag lives in GTM.
 * The site pushes GA4-style events, each from a single place, so nothing is
 * counted twice:
 *
 *   form_start       first field touched in a form           form_name
 *   form_error       a form the server refused               form_name, error_type
 *   generate_lead    a message sent (site.js, once each)     form_name, form_id, lead_id, subject
 *   click_phone      a tel: link                             link_location
 *   click_email      a mailto: link                          link_location
 *   booking_click    a link to the booking page              booking_provider, link_location
 *   book_appointment an appointment booked in a Calendly embed, once per booking
 *   begin_checkout   a "Payer en ligne" button (Stripe)      ecommerce
 *   purchase         the page Stripe sends back to, once per payment   ecommerce
 *
 * lead_id (CF7's hash of the message) and transaction_id (Stripe's Checkout
 * session) are the ids GA4 and Google Ads deduplicate on. The pay items
 * (window.DLPay) come from includes/assets.php. */
(function () {
  'use strict'

  var dl = (window.dataLayer = window.dataLayer || [])
  var push = (window.dlTrack = function (event, params) {
    var o = { event: event }
    for (var k in params) if (params[k] !== undefined && params[k] !== '') o[k] = params[k]
    dl.push(o)
  })

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

  var pay = window.DLPay || []
  var itemFor = function (key) {
    for (var i = 0; i < pay.length; i++) if (pay[i].url === key || pay[i].id === key) return pay[i]
    return null
  }
  var ecommerce = function (it, extra) {
    var e = {
      currency: 'CHF',
      value: it.price,
      tax: Math.round(it.price * 8.1) / 100,
      items: [{ item_id: it.id, item_name: it.name, item_category: "Création d'entreprise", price: it.price, quantity: 1 }]
    }
    for (var k in extra) e[k] = extra[k]
    return e
  }

  document.addEventListener('click', function (e) {
    var a = e.target && e.target.closest ? e.target.closest('a[href]') : null
    if (!a) return
    var href = a.getAttribute('href') || ''
    if (href.indexOf('tel:') === 0) {
      push('click_phone', { link_location: zone(a) })
    } else if (href.indexOf('mailto:') === 0) {
      push('click_email', { link_location: zone(a) })
    } else if (/outlook\.office365\.com\/owa\/calendar|calendly\.com/.test(href)) {
      push('booking_click', { booking_provider: /calendly/.test(href) ? 'calendly' : 'microsoft_bookings', link_location: zone(a) })
    } else if (/buy\.stripe\.com/.test(href)) {
      var it = itemFor(href.split('?')[0])
      if (it) {
        dl.push({ ecommerce: null })
        push('begin_checkout', { ecommerce: ecommerce(it) })
      }
    }
  }, true)

  // Calendly's embeds post their steps to the page: the booking itself counts
  window.addEventListener('message', function (e) {
    if (!/\.calendly\.com$/.test(String(e.origin).replace(/^https?:\/\//, '.')) || !e.data || e.data.event !== 'calendly.event_scheduled') return
    var uri = e.data.payload && e.data.payload.invitee && e.data.payload.invitee.uri
    if (uri && !once('dl_booked_' + uri)) return
    push('book_appointment', { booking_provider: 'calendly' })
  })

  // the page Stripe sends back to after a payment: ?item=…&session_id=cs_…
  var q = new URLSearchParams(window.location.search)
  var session = q.get('session_id')
  var bought = itemFor(q.get('item') || '')
  if (session && /^cs_/.test(session) && bought && once('dl_tx_' + session)) {
    dl.push({ ecommerce: null })
    push('purchase', { ecommerce: ecommerce(bought, { transaction_id: session }) })
  }
})()
