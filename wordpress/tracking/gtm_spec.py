# The GTM container GTM-NQ96WBF2 ("Dilytics 2026"), described as data: every
# variable, trigger and tag with its exact API body. Running it writes
# gtm-spec.json, from which the container is (re)built through the GTM API
# (the GTM MCP): wipe the workspace, create folders, variables, triggers,
# then tags, resolving the "@" keys (folder, trigger and template names).
import json
T=lambda k,v: {"type":"template","key":k,"value":v}
B=lambda k,v: {"type":"boolean","key":k,"value":"true" if v else "false"}
def M(**kw): return {"type":"map","map":[T(k,v) for k,v in kw.items()]}
def L(k,maps): return {"type":"list","key":k,"list":maps}
def eq(a,b,neg=False):
    p=[T("arg0",a),T("arg1",b)]
    if neg: p.append(B("negate",True))
    return {"type":"equals","parameter":p}
def rx(a,b): return {"type":"matchRegex","parameter":[T("arg0",a),T("arg1",b)]}

folders=["GA4","Google Ads","Meta","LinkedIn","Utilities"]

V=[]
def var(name,type_,params,notes=None,folder="Utilities"):
    d={"name":name,"type":type_,"parameter":params,"@folder":folder}
    if notes: d["notes"]=notes
    V.append(d)
def dlv(key,notes=None): var(f"DLV - {key}","v",[{"type":"integer","key":"dataLayerVersion","value":"2"},B("setDefaultValue",False),T("name",key)],notes)

var("Const - GA4 Measurement ID","c",[T("value","G-436C2QWD5K")],"GA4 property « Dilytics.ch » (330693779, stream « Mon site web »): the one the old site's data goes to (through its server container), in CHF and Zurich time. Not « dilytics.ch - GA4 » (371110963, G-LD77B0HR8Z), which has received nothing since January 2025.")
var("Const - GAds Conversion ID","c",[T("value","10930930121")],"Google Ads account Dilytics Sàrl (507-524-3982).")
var("Const - Meta Pixel ID","c",[T("value","206194998936004")],"The old site's Meta pixel.")
var("Const - LinkedIn Partner ID","c",[T("value","4978218")],"The old site's LinkedIn Insight Tag partner ID.")
var("CJS - Send mode","jsm",[T("javascript","function () {\n  if (/(^|\\.)dilytics\\.ch$/.test({{Page Hostname}})) return 'prod';\n  return {{Debug Mode}} ? 'preview' : 'off';\n}")],
    "prod on dilytics.ch; preview in GTM preview mode; off anywhere else (the staging outside preview). GA4 sends in prod and preview; Google Ads, Meta, LinkedIn in prod only (blocking triggers).")
var("GTES - Page context","gtes",[L("eventSettingsTable",[{"type":"map","map":[T("parameter",p),T("parameterValue","{{DLV - %s}}"%p)]} for p in ["page_type","service_id","service_name","service_category","landing_page","pages_viewed","services_viewed"]])],
    "Shared GA4 event parameters, on every event (page_view included): the page type; the service (the page's, or elsewhere the last one seen in the visit); the visit so far (entry page, pages viewed, services viewed). Pushed in the head before GTM (includes/assets.php).",folder="GA4")
var("CJS - Content group","jsm",[T("javascript","function () {\n  var t = {{DLV - page_type}};\n  if (t === 'service') return 'Services - ' + {{DLV - service_category}};\n  return {home: 'Accueil', category: 'Catégories', contact: 'Contact', about: 'À propos', articles: 'Articles', jobs: 'Emploi', payment: 'Paiement', legal: 'Pages légales', not_found: 'Page introuvable'}[t] || 'Autres pages';\n}")],
    "GA4 content group: services by category, the other pages by type.",folder="GA4")
for k in ["page_type","service_id","service_name","service_category","landing_page","pages_viewed","services_viewed","form_id","form_name","lead_source","lead_id","subject","error_type","link_url","link_location","booking_provider","social_network","ecommerce","ecommerce.value","ecommerce.currency","ecommerce.transaction_id","user_data.email","user_data.phone_number","consent_marketing"]:
    dlv(k)
dlv("user_data","{email, phone_number (E.164)} pushed with generate_lead: Google Ads enhanced conversions and Meta advanced matching only, never sent to GA4.")
var("UPD - user_data","awec",[T("mode","CODE"),T("dataSource","{{DLV - user_data}}")],
    "User-provided data, Code mode: the dataLayer's user_data object ({email, phone_number}), hashed by the Google tag, under ad_user_data consent.",folder="Google Ads")
var("CJS - GAds label - click_booking","jsm",[T("javascript","function () {\n  if ({{DLV - link_location}} === 'site-nav') return 'v0wrCMOYkqAYEMmDo9wo';\n  if ({{Page Path}} === '/') return 'dgbPCOqYkqAYEMmDo9wo';\n  return 'kVpUCMCYkqAYEMmDo9wo';\n}")],
    "Existing Ads actions: « Clic | Prendre rendez-vous - Bouton Header » (header), « Clic | Réserver mon entretien - Home Page » (home), « Clic | Réserver mon entretien - Microsoft Bookings » (elsewhere).",folder="Google Ads")
var("CJS - GAds label - click_phone","jsm",[T("javascript","function () {\n  return {{DLV - link_location}} === 'site-nav' ? 'n0o1CMmYkqAYEMmDo9wo' : 'K-UkCPCYkqAYEMmDo9wo';\n}")],
    "Existing Ads actions: « Clic | N° de Téléphone Barre Supérieure » (header), « Clic | N° de Téléphone - Footer » (elsewhere).",folder="Google Ads")
var("CJS - GAds label - click_email","jsm",[T("javascript","function () {\n  return {{DLV - link_location}} === 'site-nav' ? 'wPWkCNWYkqAYEMmDo9wo' : 'eulVCPaYkqAYEMmDo9wo';\n}")],
    "Existing Ads actions: « Clic | Mailto - Barre Supérieure » (header), « Clic | Mailto - Footer bas » (elsewhere).",folder="Google Ads")
pv={"/creation-dentreprise/":"r2Y3CIOXkqAYEMmDo9wo","/creation-de-raison-individuelle/":"hIcyCIaXkqAYEMmDo9wo","/creer-une-sarl-en-suisse-facile/":"mtOnCImXkqAYEMmDo9wo","/creation-de-societe-anonyme/":"NMdCCIyXkqAYEMmDo9wo","/entreprises/":"g-9NCI-XkqAYEMmDo9wo","/comptabilite-geneve-experts-fiduciaire/":"apf_CIqYkqAYEMmDo9wo","/domiciliation-a-geneve/":"B-juCI2YkqAYEMmDo9wo","/payroll-et-administration-rh/":"-sOPCJCYkqAYEMmDo9wo","/tva-suisse/":"kyfMCJOYkqAYEMmDo9wo","/mandat-de-gerant-et-administrateur-en-suisse/":"mB4nCJaYkqAYEMmDo9wo","/audit-des-comptes/":"rqeGCJmYkqAYEMmDo9wo","/gestion-de-ppe/":"FZX7CJyYkqAYEMmDo9wo","/particuliers/":"WEq6CJ-YkqAYEMmDo9wo","/declaration-dimpots/":"nx3vCKKYkqAYEMmDo9wo","/particuliers-impot-a-la-source/":"m7JaCKWYkqAYEMmDo9wo","/conseil-fiscal/":"suYfCKiYkqAYEMmDo9wo","/declaration-de-succession/":"2jF3CKuYkqAYEMmDo9wo","/prevoyance-3eme-pilier-geneve/":"dWpyCK6YkqAYEMmDo9wo","/gestion-administrative/":"0VoOCLGYkqAYEMmDo9wo","/fiscalite-immobiliere/":"XxkSCLSYkqAYEMmDo9wo","/a-propos/":"k83ACLeYkqAYEMmDo9wo","/articles/":"Icl_CLqYkqAYEMmDo9wo","/contact/":"RipgCL2YkqAYEMmDo9wo","/controle-restreint/":"2jNoCL_shKYYEMmDo9wo"}
ct={"/":"bLfSCOeYkqAYEMmDo9wo","/controle-restreint/":"bYxYCJS0gKgYEMmDo9wo","/gestion-de-ppe/":"Ak0eCJuakqAYEMmDo9wo","/creation-dentreprise/":"N3QlCIXD7qYYEMmDo9wo","/creation-de-raison-individuelle/":"kB3vCPqZkqAYEMmDo9wo","/creer-une-sarl-en-suisse-facile/":"-S6ECP2ZkqAYEMmDo9wo","/creation-de-societe-anonyme/":"wXDMCIOakqAYEMmDo9wo","/comptabilite-geneve-experts-fiduciaire/":"Zyd7CIaakqAYEMmDo9wo","/domiciliation-a-geneve/":"wUWKCIyakqAYEMmDo9wo","/payroll-et-administration-rh/":"NbV6CI-akqAYEMmDo9wo","/tva-suisse/":"GxcUCJKakqAYEMmDo9wo","/mandat-de-gerant-et-administrateur-en-suisse/":"EkS2CJWakqAYEMmDo9wo","/audit-des-comptes/":"F01mCJiakqAYEMmDo9wo","/declaration-dimpots/":"A-8GCJ6akqAYEMmDo9wo","/particuliers-impot-a-la-source/":"FgfCCKGakqAYEMmDo9wo","/conseil-fiscal/":"rBDJCKeakqAYEMmDo9wo","/declaration-de-succession/":"PjUhCKqakqAYEMmDo9wo","/prevoyance-3eme-pilier-geneve/":"kngxCK2akqAYEMmDo9wo","/gestion-administrative/":"-mlHCLCakqAYEMmDo9wo","/fiscalite-immobiliere/":"GhEuCLOakqAYEMmDo9wo"}
so={"linkedin":"_YgZCPyYkqAYEMmDo9wo","instagram":"90r0CPmYkqAYEMmDo9wo","facebook":"keelCP-YkqAYEMmDo9wo"}
def lt(name,inp,m,notes):
    var(name,"smm",[T("input",inp),L("map",[{"type":"map","map":[T("key",k),T("value",v)]} for k,v in m.items()]),B("setDefaultValue",True),T("defaultValue","")],notes,folder="Google Ads")
lt("LT - GAds label - page_view","{{Page Path}}",pv,"Existing secondary Ads actions « Page Vue | … », one per page; empty elsewhere (no conversion).")
lt("LT - GAds label - click_contact","{{Page Path}}",ct,"Existing Ads actions « Clic | Nous contacter - Page … » and « Clic | Prendre contact - Home Page »; empty elsewhere (no conversion).")
lt("LT - GAds label - click_social","{{DLV - social_network}}",so,"Existing Ads actions « Clic | Linkedin footer », « Clic | Instagram - Footer », « Clic | Facebook - Footer ».")
var("CJS - Meta properties - ecommerce","jsm",[T("javascript","function () {\n  var e = {{DLV - ecommerce}} || {};\n  var items = e.items || [];\n  var o = {\n    content_type: 'product',\n    content_ids: items.map(function (i) { return i.item_id; }),\n    contents: items.map(function (i) { return { id: i.item_id, quantity: i.quantity || 1 }; }),\n    num_items: items.length\n  };\n  if (items[0]) { o.content_name = items[0].item_name; o.content_category = items[0].item_category; }\n  if (e.value !== undefined) { o.value = e.value; o.currency = e.currency; }\n  return o;\n}")],
    "Meta object properties from the GA4 ecommerce object (view_item, begin_checkout, purchase): content_ids, contents, content_type, content_name, content_category, num_items, value, currency.",folder="Meta")
var("CJS - Meta ph - user_data.phone_number","jsm",[T("javascript","function () {\n  var p = {{DLV - user_data.phone_number}};\n  return p ? String(p).replace(/\\D/g, '') : undefined;\n}")],
    "Meta advanced matching wants the phone as digits only, country code included.",folder="Meta")
var("CVT - Unique Event ID","@template:Unique Event ID",[],
    "Official stape-io template: one id per dataLayer event, the same in every tag of that event. Sent as event_id to GA4 and as eventID to Meta: a browser event and its future server copy (Conversions API through the server container) deduplicate on it.")

R=[]
def trig(name,type_,custom=None,filters=None,notes=None):
    d={"name":name,"type":type_}
    if custom: d["customEventFilter"]=custom
    if filters: d["filter"]=filters
    if notes: d["notes"]=notes
    R.append(d)
EV=["lead_form_view","lead_form_start","lead_form_submit","lead_form_error","generate_lead","click_phone","click_email","click_booking","click_contact","click_social","book_appointment","view_item","begin_checkout","purchase"]
for e in EV: trig(f"CE - {e}","customEvent",[eq("{{_event}}",e)])
trig("CE - click_booking - microsoft_bookings","customEvent",[eq("{{_event}}","click_booking")],[eq("{{DLV - booking_provider}}","microsoft_bookings")],"A click to Microsoft Bookings: the booking happens there, unseen, so the click stands for it (Meta Schedule). Calendly bookings come as book_appointment.")
trig("CE - click_contact - GAds page","customEvent",[eq("{{_event}}","click_contact")],[rx("{{LT - GAds label - click_contact}}",".")])
trig("CE - click_social - site-foot","customEvent",[eq("{{_event}}","click_social")],[eq("{{DLV - link_location}}","site-foot")])
trig("CE - dl_consent - marketing granted","customEvent",[eq("{{_event}}","dl_consent")],[eq("{{DLV - consent_marketing}}","granted")],"dl_consent is pushed by the site right after each Consent Mode update (Complianz choice, and on each page when consent exists). For non-Google tags (Meta, LinkedIn); they fire once per page.")
trig("PV - GAds page_view pages","pageview",None,[rx("{{LT - GAds label - page_view}}",".")])
trig("Block - Send mode not prod","customEvent",[rx("{{_event}}",".*")],[eq("{{CJS - Send mode}}","prod",neg=True)],"Exception for Google Ads, Meta and LinkedIn: nothing leaves outside dilytics.ch.")
trig("Block - Send mode off","customEvent",[rx("{{_event}}",".*")],[eq("{{CJS - Send mode}}","off")],"Exception for GA4: nothing leaves from the staging outside GTM preview.")

INIT="2147479573"
Tg=[]
def tag(name,type_,params,fire,block,folder,notes=None,opt="oncePerEvent",consent=None,setup=None):
    d={"name":name,"type":type_,"parameter":params,"@fire":fire,"@block":block,"@folder":folder,"tagFiringOption":opt}
    if notes: d["notes"]=notes
    if consent: d["consentSettings"]={"consentStatus":"needed","consentType":{"type":"list","list":[{"type":"template","value":c} for c in consent]}}
    Tg.append(d)
GA_BLOCK=["Block - Send mode off"]; MK_BLOCK=["Block - Send mode not prod"]
tag("Google Tag - GA4 - G-436C2QWD5K","googtag",[T("tagId","{{Const - GA4 Measurement ID}}"),L("configSettingsTable",[{"type":"map","map":[T("parameter","content_group"),T("parameterValue","{{CJS - Content group}}")]}]),T("eventSettingsVariable","{{GTES - Page context}}")],["@builtin:"+INIT],GA_BLOCK,"GA4","GA4 page_view included, property « Dilytics.ch » (330693779). Consent Mode v2 from the site's head script (denied until Complianz consent): cookieless pings until then.",opt="oncePerLoad")
gp={"lead_form_view":["form_id","form_name"],"lead_form_submit":["form_id","form_name"],"lead_form_start":["form_id","form_name"],"lead_form_error":["form_id","form_name","error_type"],"generate_lead":["form_id","form_name","lead_source","lead_id","subject"],
    "click_phone":["link_url","link_location"],"click_email":["link_url","link_location"],"click_booking":["link_url","link_location","booking_provider"],
    "click_contact":["link_url","link_location"],"click_social":["link_url","link_location","social_network"],"book_appointment":["booking_provider"]}
for e in EV:
    params=[T("eventName",e),T("measurementIdOverride","{{Const - GA4 Measurement ID}}"),T("eventSettingsVariable","{{GTES - Page context}}")]
    rows=[{"type":"map","map":[T("parameter",p),T("parameterValue","{{DLV - %s}}"%p)]} for p in gp.get(e,[])]
    rows.append({"type":"map","map":[T("parameter","event_id"),T("parameterValue","{{CVT - Unique Event ID}}")]})
    params.append(L("eventSettingsTable",rows))
    if e in gp:
        params.append(B("sendEcommerceData",False))
    else:
        params+= [B("sendEcommerceData",True),T("getEcommerceDataFrom","dataLayer")]
    tag(f"GA4 - Event - {e}","gaawe",params,[f"CE - {e}"],GA_BLOCK,"GA4")
tag("Google Tag - Google Ads - AW-10930930121","googtag",[T("tagId","AW-{{Const - GAds Conversion ID}}")],["@builtin:"+INIT],MK_BLOCK,"Google Ads","Google tag for Ads on every page of dilytics.ch: remarketing audiences, and the gclid kept (so no separate conversion linker, per Google).",opt="oncePerLoad")
def ads(name,label,fire,notes,extra=()):
    p=[T("conversionId","{{Const - GAds Conversion ID}}"),T("conversionLabel",label),B("enableConversionLinker",True),T("conversionCookiePrefix","_gcl"),B("enableProductReporting",False),B("enableNewCustomerReporting",False),B("enableShippingData",False),B("rdp",False)]
    p+=list(extra) if extra else [B("enableEnhancedConversion",False)]
    tag(name,"awct",p,fire,MK_BLOCK,"Google Ads",notes)
ads("GAds - Conversion - generate_lead","ZtWqCO2YkqAYEMmDo9wo",["CE - generate_lead"],"Existing action « Formulaires_envoyés | Tout le Site Web ». Transaction ID = lead_id (random, one per message). Enhanced conversions: UPD - user_data.",
    extra=(T("orderId","{{DLV - lead_id}}"),B("enableEnhancedConversion",True),T("cssProvidedEnhancedConversionValue","{{UPD - user_data}}")))
ads("GAds - Conversion - purchase","HtZ_CKbU6osdEMmDo9wo",["CE - purchase"],"Action « Achat | Paiement en ligne » (goal Achat, primary), created 2026-09-30. Value before VAT in CHF, as GA4's; transaction ID = Stripe's Checkout session, one per payment.",
    extra=(T("conversionValue","{{DLV - ecommerce.value}}"),T("currencyCode","{{DLV - ecommerce.currency}}"),T("orderId","{{DLV - ecommerce.transaction_id}}"),B("enableEnhancedConversion",False)))
ads("GAds - Conversion - click_booking","{{CJS - GAds label - click_booking}}",["CE - click_booking"],"Label per location: CJS - GAds label - click_booking.")
ads("GAds - Conversion - click_phone","{{CJS - GAds label - click_phone}}",["CE - click_phone"],"Label per location: CJS - GAds label - click_phone.")
ads("GAds - Conversion - click_email","{{CJS - GAds label - click_email}}",["CE - click_email"],"Label per location: CJS - GAds label - click_email.")
ads("GAds - Conversion - click_contact","{{LT - GAds label - click_contact}}",["CE - click_contact - GAds page"],"Label per page: LT - GAds label - click_contact.")
ads("GAds - Conversion - click_social","{{LT - GAds label - click_social}}",["CE - click_social - site-foot"],"Label per network: LT - GAds label - click_social.")
ads("GAds - Conversion - page_view","{{LT - GAds label - page_view}}",["PV - GAds page_view pages"],"Secondary actions « Page Vue | … » (interest signal, not bidding). Label per page: LT - GAds label - page_view.")
MKT=["ad_storage","ad_user_data"]
def meta(name,std,fire,props=None,prop_var=None,event_id="{{CVT - Unique Event ID}}",am=None,opt="oncePerEvent",notes=None):
    p=[T("pixelId","{{Const - Meta Pixel ID}}"),T("eventName","standard"),T("standardEventName",std),B("consent",True),B("optInMetaCAPI",False),
       B("disableAutoConfig",True),B("disablePushState",False),B("enhancedEcommerce",False),B("useGA4Ecommerce",False),B("dpoLDU",False)]
    p.append(T("objectPropertiesFromVariable",prop_var) if prop_var else B("objectPropertiesFromVariable",False))
    if props: p.append(L("objectPropertyList",[{"type":"map","map":[T("name",k),T("value",v)]} for k,v in props]))
    if event_id: p.append(T("eventId",event_id))
    if am:
        p.append(B("advancedMatching",True)); p.append(L("advancedMatchingList",[{"type":"map","map":[T("name",k),T("value",v)]} for k,v in am]))
    else: p.append(B("advancedMatching",False))
    tag(name,"@template:Meta Pixel",p,fire,MK_BLOCK,"Meta",notes,opt=opt,consent=MKT)
meta("Meta - Base - PageView","PageView",["CE - dl_consent - marketing granted"],opt="oncePerLoad",notes="Official Meta Pixel template. After marketing consent only, once per page. Automatic configuration off (no automatic clicks: one event source). Meta-enabled Conversions API opt-in left off: Meta terms for Dilytics to accept themselves.")
meta("Meta - Event - Lead","Lead",["CE - generate_lead"],props=[("content_name","{{DLV - lead_source}}"),("content_category","{{DLV - service_name}}")],am=[("em","{{DLV - user_data.email}}"),("ph","{{CJS - Meta ph - user_data.phone_number}}")],notes="Lead (« Prospect ») on each message sent. Advanced matching: e-mail and phone, hashed by the pixel.")
meta("Meta - Event - Contact","Contact",["CE - click_phone","CE - click_email"],props=[("content_name","{{Event}}"),("content_category","{{DLV - service_name}}")],notes="Contact: a tel: or mailto: link clicked.")
meta("Meta - Event - Schedule","Schedule",["CE - book_appointment","CE - click_booking - microsoft_bookings"],props=[("content_name","{{DLV - booking_provider}}"),("content_category","{{DLV - service_name}}")],notes="Schedule: an appointment booked in Calendly, or a click to Microsoft Bookings (where the booking itself can't be seen).")
meta("Meta - Event - ViewContent","ViewContent",["CE - view_item"],prop_var="{{CJS - Meta properties - ecommerce}}",notes="ViewContent on each service page (view_item).")
meta("Meta - Event - InitiateCheckout","InitiateCheckout",["CE - begin_checkout"],prop_var="{{CJS - Meta properties - ecommerce}}",notes="InitiateCheckout: a « Payer en ligne » button.")
meta("Meta - Event - Purchase","Purchase",["CE - purchase"],prop_var="{{CJS - Meta properties - ecommerce}}",notes="Purchase on Stripe's return (value before VAT, CHF).")
tag("LinkedIn - Base - Insight Tag","@template:LinkedIn InsightTag 2.0",[T("partnerId","{{Const - LinkedIn Partner ID}}"),T("conversionId",""),T("customUrl","")],["CE - dl_consent - marketing granted"],MK_BLOCK,"LinkedIn",
    "Official LinkedIn template. After marketing consent only, once per page. Conversions: add a tag per LinkedIn conversion ID (Campaign Manager) with its Conversion ID.",opt="oncePerLoad",consent=MKT)

json.dump({"folders":folders,"builtins":["pageUrl","pageHostname","pagePath","referrer","event","debugMode"],"variables":V,"triggers":R,"tags":Tg},open(__file__.replace("gtm_spec.py","gtm-spec.json"),"w"),ensure_ascii=False,indent=1)
print(len(V),"variables",len(R),"triggers",len(Tg),"tags")
