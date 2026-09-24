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

## Différences voulues avec Nuxt

- Les formulaires ouvrent la messagerie du visiteur, comme sur Nuxt ; le HTML a
  en plus un attribut `name` par champ.
- Le moteur Nuxt ne garde qu'une animation par élément, la dernière déclarée :
  les cartes de prix (`v-rv` puis `v-tilt`) ne font que s'incliner. Reproduit.
- Beaver Builder 2.11 ne déclenche plus `fl_builder_loaded` : les modules se
  chargent sur `init`, priorité 5.
