# Dilytics

Site de Dilytics, société fiduciaire à Genève.

## Stack

- [Nuxt 4](https://nuxt.com) en rendu serveur, routage par fichiers
- [GSAP](https://gsap.com) + ScrollTrigger et [Lenis](https://lenis.darkroom.engineering) pour le défilement et les animations
- Police variable Archivo, CSS scopé, aucun framework de style

## Démarrer

```bash
npm install
npm run dev
```

Le site tourne sur http://localhost:3000.

```bash
npm run build     # build de production
npm run preview   # servir le build localement
npm run generate  # export statique
```

## Organisation

| Dossier | Contenu |
|---|---|
| `app/pages` | Les routes. `[slug].vue` rend les 18 pages de prestation. |
| `app/content` | Tout le contenu éditorial : prestations, textes, tarifs, coordonnées. |
| `app/components` | Composants partagés, `home/` pour les sections d'accueil. |
| `app/plugins` | `motion.client.js`, le moteur d'animation (Lenis, GSAP, directives). |
| `app/assets/img` | Images en WebP, indexées par nom de fichier. |

Une nouvelle prestation est un objet dans `app/content/services.js`, pas un
nouveau fichier : la page, le menu, le maillage interne et le pied de page en
découlent.

## Animations

Le plugin `motion.client.js` expose des directives utilisables partout :

| Directive | Effet |
|---|---|
| `v-rv` | Entrée au défilement : `up`, `fade`, `mask`, `zoom`, `text`, `rule` |
| `v-stagger` | Le conteneur fait entrer ses enfants en cascade |
| `v-lit` | Le texte s'allume mot à mot, lié au défilement |
| `v-tilt` | La carte s'incline sous le curseur |
| `v-mag` | Le bouton est magnétique |
| `v-px` | Parallaxe au défilement |

Rien n'est masqué durablement : chaque entrée est un tween `from`, donc un
élément dont l'animation ne se déclenche pas reste visible tel que le serveur
l'a rendu.
