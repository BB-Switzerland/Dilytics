# Dilytics sur WordPress + Beaver Builder

Le site Nuxt (`app/`) porté sur WordPress + Beaver Builder, au pixel près :
même HTML, même CSS, mêmes animations. Serveur : `nivw.ftp.infomaniak.com`,
site `~/sites/dilytics.businessbooster.agency`, WP-CLI `php ~/bin/wp`.

## Organisation

| Chemin | Contenu |
|---|---|
| `dilytics-modules/` | Le plugin : un module Beaver Builder par section Nuxt, le moteur d'animation, les styles. |
| `dilytics-modules/assets/css/base.css`, `components.css` | **Générés** par `tools/compile-css.mjs` depuis `app/`. Ne pas éditer. |
| `dilytics-modules/assets/css/wp.css` | Seul CSS écrit à la main : ce que WordPress ajoute et que Nuxt n'a pas. |
| `dilytics-modules/assets/js/site.js` | Port de `app/plugins/motion.client.js` et des scripts des composants. |
| `chantier/` | Scripts de construction (`wp eval-file`), relancés à volonté. `data/content.json` est **généré** par `tools/export-content.mjs`. |
| `tools/compare.mjs` | Compare une page Nuxt (localhost:3000) et la même page WordPress, élément par élément. |
| `tools/geometry.mjs` | Compare le rendu : la boîte de chaque élément, mesurée dans Chrome sans interface, à 1440 et 390 px. |
| `deploy.sh` | Exporte, compile, vérifie la syntaxe PHP, envoie, construit. |

## Commandes

```bash
wordpress/deploy.sh                        # envoi seul
wordpress/deploy.sh setup                  # réglages, images, pages, menu, en-tête, pied de page
wordpress/deploy.sh contact home           # reconstruit ces pages (chantier/pages/<nom>.php)
wordpress/deploy.sh metas                  # titres, descriptions et images de partage, sans toucher aux pages
wordpress/deploy.sh all                    # tout
node wordpress/tools/compare.mjs /contact/ # 0 ligne différente attendue
node wordpress/tools/compare.mjs --all
node wordpress/tools/geometry.mjs          # toutes les pages, 1440 et 390 px
```

Les deux comparaisons demandent le serveur Nuxt sur le port 3000.
`deploy.sh` vide à chaque fois le cache des pages **et** le cache de
minification de WP Rocket : sans le second, les visiteurs gardent d'anciennes
copies minifiées des feuilles du plugin.

## Porter une section Nuxt en module

1. **Un module par section**, dossier `dilytics-modules/modules/dl-<nom>/` :
   `dl-<nom>.php` (classe `extends DL_Module`, `FLBuilder::register_module( …, dl_form( … ) )`)
   et `includes/frontend.php`. Libellés des champs en français, défauts vides.
2. **La section est la racine du module** : `<section<?php dl_root( $module, array( 'classes', 'nuxt', 'v-<scope>' ) ); ?>>`.
   Pas d'enveloppe entre le module et la section.
3. **Classe de portée** `v-<scope>` : celle que `compile-css.mjs` donne au fichier Vue
   d'origine (`HomeOpen.vue` → `v-home-open`, `[slug].vue` → `v-slug`,
   `CategoryPage.vue` → `v-category-page`, `a-propos.vue` → `v-a-propos`).
   Elle se pose sur **la ou les racines du composant Vue**, jamais sur une
   enveloppe qui contiendrait un autre composant : le CSS scopé devient
   `:is(.v-x, .v-x *)` et atteint tout ce qui est dessous.
4. **Même balisage que le template Vue**, élément pour élément, mêmes classes,
   mêmes attributs utiles (`href`, `alt`, `aria-*`, `target`, `rel`).
   Composants partagés (`includes/partials.php`) : `dl_ar()`, `dl_ax()`,
   `dl_ico()`, `dl_head3()`, `dl_photo_note()`, `dl_pending()`, `dl_counter()`,
   `dl_service_list()`, `dl_logo()`, `dl_crumb()`.
5. **Directives** : `v-rv:12="'up'"` → `dl_rv( 'up', 12 )` ; `v-stagger` → `data-stagger` ;
   `v-lit` → `data-lit` ; `v-tilt` → `data-tilt` ; `v-px="16"` → `data-px="16"` ;
   `v-mag` → `data-mag`. Les scripts des composants sont déjà dans `site.js`.
6. **États masqués** (un `v-if`/`v-else` basculé par le script) : rendus avec
   `style="display:none;"`, jamais `hidden` (un `display` du CSS l'emporterait).
7. **Textes** : ceux de Nuxt, sans en changer un mot. Ce qui existe dans
   `content.json` se lit dans le script de page, jamais recopié à la main.
   `dl_t()` pour du texte, `dl_h()` pour un champ qui porte du balisage (`<br />`).
8. **Liens** : chemins (`/contact/`) résolus par `dl_url()`. **Images** : champ
   photo + `<clé>_src`, rempli par `dlb_photo( 'img', '<nom nuxt>' )` ; note
   rouge par `dl_photo_note( dl_img_name( $id ) )` là où Nuxt a `<PhotoNote>`.

## Scripts de page

`chantier/pages/<page>.php` : `dlb_page()`, `dlb_start()`, un
`dlb_add( 'dl-…', $settings )` par section dans l'ordre de la page,
`dlb_finish()`. Sections partagées : `dlb_cta( $overrides )`, `dlb_ask()`.

## Métas

`chantier/metas.php` (`deploy.sh metas`) est le seul endroit où se règlent le
titre, la description et l'image de partage de chaque page. Il ne touche pas
aux mises en page : une page retouchée dans Beaver Builder garde ses
retouches.

- Titre : 60 caractères au plus (`dlb_title()`), sinon suffixe court.
- Description : des phrases entières du texte de la page, 160 caractères au
  plus (`dlb_desc()`) ; les exceptions sont listées dans `$descs`.
- Image de partage : la photo d'ouverture de la page.
- Le plugin imprime `description`, Open Graph et `twitter:card`. La page
  « Photos à fournir » reste en `noindex`, sans balise de partage.
- JSON-LD (`includes/schema.php`) : le cabinet (`AccountingService`, avec
  adresse, téléphone, horaires, équipe et catalogue des prestations), le
  site, la page et son fil d'Ariane ; sur une page de prestation, le
  `Service` et ses questions (`FAQPage`), lues dans le module FAQ de la page.
  `metas.php` enregistre la partie fixe (option `dl_org`, méta `_dl_ld`), le
  plugin résout les URL à l'affichage. Jamais d'adresse e-mail, donc pas non
  plus le lien Bookings ; pas de note Google (interdit par Google quand les
  avis sont recueillis ailleurs) ; pas de `JobPosting` tant que les offres
  sont des exemples.

## Ce que WordPress ajoute, et comment c'est neutralisé

- **Classes du `<body>`** : WordPress met `page` sur chaque page, et la règle
  `.page` de Nuxt (1240 px de large) rétrécissait tout le site. Le plugin retire
  du body toute classe que le CSS Nuxt met en forme (liste générée,
  `assets/css/classes.json`).
- **Pleine page** : les pages Beaver Builder passent par `templates/page.php`
  (en-tête Themer, contenu, pied de page Themer), sans conteneur ni titre du thème.
- **Clearfix de Beaver Builder** sur chaque module : évité par `data-accepts`
  sur les racines (`dl_root()`), sinon il écrase les `::before` des sections.
- **`min-height: 1px` des colonnes** : l'en-tête Themer décalait la page d'un pixel.
- **« (opens in new tab) »** ajouté par le script de Beaver Builder : gardé pour
  les lecteurs d'écran, mais hors du flux.
- **Portée CSS** : une règle ne descend pas dans les composants enfants ni sur
  les racines des composants à plusieurs racines, comme dans Vue
  (voir `tools/compile-css.mjs`).

## llms.txt

`/llms.txt` (format llmstxt.org) est construit par `app/content/llms.js` à
partir des contenus du site. Nuxt le sert par `server/routes/llms.txt.get.js` ;
`export-content.mjs` l'écrit dans `dilytics-modules/assets/llms.txt`, que le
plugin sert avec l'URL du site dans les liens. Le plugin répond dès son
chargement, avant Squirrly SEO, dont le `/llms.txt` est au format robots.txt.

## Paiement en ligne (Stripe)

Les trois créations d'entreprise (RI, Sàrl, SA) se paient en ligne par un lien
de paiement Stripe, compte live « Dilytics Sàrl ». Le lien est le champ `pay`
de `PRICE` dans `app/content/offers.js` ; le bloc prix (Nuxt `PriceBlock.vue`,
module `dl-price`) affiche alors « Payer en ligne » à côté du bouton Contact.
Montants : le prix publié, TVA de 8,1 % comprise quand il est donné hors TVA
(RI 990.–, Sàrl 2'810.60, SA 3'243.–). Un changement de prix se fait dans
Stripe (nouveau prix, nouveau lien) puis dans `offers.js`.

Après un paiement, Stripe appelle le webhook du site
(`/wp-json/dilytics/v1/stripe`, `includes/stripe.php`), qui envoie la
confirmation au client (`templates/mail-paid.php`) et l'avis à Dilytics
(`templates/mail-notify.php`). Réglages dans `wp-config.php` du serveur, jamais
dans le dépôt :

```php
define( 'DL_STRIPE_WEBHOOK_SECRET', 'whsec_…' );   // secret de signature du webhook Stripe
define( 'DL_SMTP_HOST', 'smtp.office365.com' );    // dilytics.ch n'autorise que Microsoft 365 (SPF -all)
define( 'DL_SMTP_USER', 'contact@dilytics.ch' );
define( 'DL_SMTP_PASS', '…' );
define( 'DL_PAY_NOTIFY', 'contact@dilytics.ch' );  // facultatif : destinataire de l'avis
```

Sans SMTP, aucun e-mail ne part (le paiement est noté dans le journal PHP).
Au passage sur dilytics.ch, changer l'URL du webhook dans Stripe.

## Formulaires

Les deux formulaires (Contact, et « Des questions ? » des pages de
prestation et de catégorie) gardent leur balisage ; Contact Form 7 les reçoit
(`includes/contact.php`), les envoie à contact@dilytics.ch et Flamingo les
archive (admin > Flamingo > Messages reçus). `setup.php` crée les deux
formulaires CF7 (option `dl_forms`) ; `site.js` les poste à l'API REST de CF7.
Anti-spam sans service tiers : un champ piège invisible et un délai minimal
de trois secondes (un envoi refusé reste visible dans Flamingo, comme spam).

Expéditeur provisoire : `noreply@businessbooster.agency` (le SPF de ce
domaine autorise Infomaniak). Au lancement : FluentSMTP avec le Microsoft 365
de Dilytics, puis l'expéditeur dans `setup.php`.

## Suivi des conversions

Un seul script pousse les événements dans `window.dataLayer`
(`assets/js/track.js`, et `site.js` pour les formulaires ; jamais dans
l'éditeur) ; GTM4WP charge le conteneur Google Tag Manager, où vivent toutes
les balises. Chaque événement part d'un seul endroit. Noms : ceux de GA4 quand
GA4 en a un (événements recommandés), sinon `verbe_objet` en snake_case ;
`form_start` et `form_submit` sont réservés par la mesure améliorée de GA4.

| Événement | Quand | Paramètres |
|---|---|---|
| `lead_form_start` | premier champ touché d'un formulaire | `form_id`, `form_name` (contact, question) |
| `lead_form_error` | envoi refusé par le serveur | `form_id`, `form_name`, `error_type` |
| `generate_lead` | message envoyé, une fois | `form_id`, `form_name`, `lead_source` (contact_form, question_form), `lead_id` (aléatoire), `subject`, `user_data` (Ads et Meta seulement) |
| `click_phone` / `click_email` | lien `tel:` / `mailto:` | `link_url`, `link_location` (section) |
| `click_booking` | lien vers la prise de rendez-vous | `link_url`, `link_location`, `booking_provider` |
| `click_contact` | lien vers `/contact/` | `link_url`, `link_location` |
| `click_social` | lien LinkedIn, Instagram, Facebook | `link_url`, `link_location`, `social_network` |
| `book_appointment` | rendez-vous réservé dans un widget Calendly, une fois | `booking_provider` |
| `view_item` | page d'un service | `ecommerce` (le service ; prix HT et CHF s'il se paie en ligne) |
| `begin_checkout` | bouton « Payer en ligne » | `ecommerce` |
| `purchase` | retour de Stripe sur `/paiement-confirme/`, une fois par paiement | `ecommerce` + `transaction_id` |

Les services (option `dl_items`, `setup.php`) : identifiant = slug de la page,
catégorie = famille ; prix HT et lien de paiement pour les trois services
payables en ligne. Stripe renvoie vers
`/paiement-confirme/?item=<slug>&session_id={CHECKOUT_SESSION_ID}`.

Consentement : Complianz Premium (réglé par `setup.php`, bandeau aux couleurs
du site) affiche le bandeau et garde le choix. GTM4WP charge le conteneur
(Complianz, quand GTM4WP est actif, retire ses propres réglages GTM et Consent
Mode) ; le signal Google Consent Mode v2 vient donc du script d'en-tête de
`includes/assets.php` : tout refusé par défaut, puis mis à jour depuis les
cookies et les événements de Complianz, suivi à chaque fois d'un événement
`dl_consent` (`consent_marketing`) qu'attendent Meta et LinkedIn ; le pixel
Meta est aussi averti d'un retrait (`fbq('consent')`).

Conteneur **GTM-NQ96WBF2** (« Dilytics 2026 », compte « Dilytics Tag »),
propre au nouveau site ; l'ancien site garde GTM-TJQ35MG, non modifié.
`CJS - Send mode` vaut `prod` sur dilytics.ch, `preview` en mode Aperçu GTM,
`off` ailleurs ; deux déclencheurs d'exception bloquent GA4 hors prod et
aperçu, Google Ads, Meta et LinkedIn hors prod : le staging n'envoie rien.

- GA4 `G-LD77B0HR8Z` (propriété « dilytics.ch - GA4 », celle de l'ancien
  site) : balise Google (page vue) et une balise par événement du tableau.
- Google Ads `AW-10930930121` : balise Google (remarketing, gclid) et les
  actions de conversion existantes, un libellé par action ; demande envoyée
  avec conversions améliorées (variable UPD, mode Code) et ID de transaction
  = `lead_id`.
- Meta, pixel 206194998936004, modèle officiel « Meta Pixel » : PageView,
  Lead (« Prospect »), Contact, Schedule, ViewContent, InitiateCheckout,
  Purchase ; eventID (`lead_id`, session Stripe), correspondance avancée
  (e-mail, téléphone) sur Lead. LinkedIn Insight (4978218), modèle officiel.
  Après consentement marketing seulement.

Convention de nommage : balises `<Plateforme> - <Type> - <détail>` (`GA4 -
Event - generate_lead`, `GAds - Conversion - click_phone`, `Meta - Event -
Lead`, `Google Tag - GA4 - G-…`) ; déclencheurs `CE - <événement>`, `PV - …`,
`Block - …` ; variables `Const - …`, `DLV - <clé>`, `CJS - …`, `LT - …`,
`UPD - …` ; dossiers GA4, Google Ads, Meta, LinkedIn, Utilities. Le
conteneur entier est décrit dans `tracking/gtm_spec.py` (qui écrit
`tracking/gtm-spec.json`) : la référence pour le reconstruire à l'identique
par l'API GTM.

Reste à faire à la main (pas d'accès en écriture par API) :
- GA4 : `generate_lead` et `book_appointment` en événements clés ; flux
  web > mesure améliorée > désactiver « Interactions avec les formulaires »
  (le site envoie les siens) ; dimensions personnalisées `form_name`,
  `lead_source`, `link_location`, `booking_provider`, `error_type`,
  `social_network` ; `buy.stripe.com` et `checkout.stripe.com` en sites
  référents indésirables.
- Google Ads : une action de conversion pour les paiements en ligne (sa
  balise se branche sur `CE - purchase`) ; compter « une » conversion par
  clic pour les demandes.
- LinkedIn : créer les conversions dans Campaign Manager (source « Tag
  manager ») et une balise par ID de conversion.
- Meta : décider de l'intégration Conversions API proposée par Meta (des
  conditions à accepter par Dilytics).

## Pages légales

`chantier/pages/legal.php` : la déclaration de protection des données et les
conditions générales de vente, reprises de dilytics.ch à l'identique (mêmes
adresses, textes dans `chantier/data/legal/`), et la politique de cookies que
Complianz rédige (`/politique-de-cookies/`). Pages WordPress ordinaires,
présentées par `templates/document.php` (typographie `.dl-doc` dans `wp.css`).

## Différences voulues avec Nuxt

- Les formulaires ouvrent la messagerie du visiteur, comme sur Nuxt ; le HTML a
  en plus un attribut `name` par champ.
- Le moteur Nuxt ne garde qu'une animation par élément, la dernière déclarée :
  les cartes de prix (`v-rv` puis `v-tilt`) ne font que s'incliner. Reproduit.
- Beaver Builder 2.11 ne déclenche plus `fl_builder_loaded` : les modules se
  chargent sur `init`, priorité 5.
