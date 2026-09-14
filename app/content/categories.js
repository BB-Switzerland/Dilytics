// Parent pages, one per service family. Each gathers the detail pages below it
// and answers the question a visitor has before they can pick one.
//
// Same rule as services.js: every figure below appears on the cabinet's own
// pages. Nothing is estimated or rounded from memory.
export const CATEGORIES = [
  {
    key: 'crea',
    slug: '/creation-dentreprise/',
    nav: "Création d'entreprise",
    title: "Création d'entreprise",
    pitch: 'Donnons vie à votre projet.',
    lede: "En Suisse, les trois formes juridiques les plus utilisées sont la raison individuelle, la Sàrl et la société anonyme. Nos conseillers vous aident à choisir celle qui est la mieux adaptée à votre projet, puis effectuent toutes les démarches administratives.",
    img: 'crea',
    promise: 'Ce que comprend un accompagnement',
    bullets: [
      "S'entretenir avec un spécialiste pour définir la structure adéquate",
      'Démarches administratives et auprès des banques',
      'Ouverture du compte de consignation, sur demande',
      'Signature des statuts par notre notaire partenaire',
      'Inscription au registre du commerce du canton correspondant',
    ],
    facts: [
      { v: 'Inclus', k: 'Frais de notaire, aux tarifs que nous avons négociés' },
      { v: 'Zéro', k: "Frais avant la création : nous ne facturons qu'à la réussite" },
      { v: 'Aucun', k: 'Frais caché : nous respectons les devis envoyés' },
    ],
    aside: {
      t: 'Pas de prestataire externe',
      d: "Vous n'aurez pas à contacter de notaire ni de prestataire externe. Nous offrons un service complet qui va du conseil juridique à l'inscription de votre société au registre du commerce.",
    },
  },
  {
    key: 'entreprises',
    slug: '/entreprises/',
    nav: 'Entreprises',
    title: 'Services pour entreprises',
    pitch: 'Un seul cabinet pour la compta, les salaires, la TVA et la révision.',
    lede: "Nos services pour entreprises vous libèrent de vos obligations fiscales et administratives. Nous vous aidons également à obtenir une adresse fiscale si vous souhaitez démarrer vos activités à Genève et en Suisse.",
    img: 'entr',
    promise: 'Ce que nous tenons pour vous',
    bullets: [
      "Suivi comptable sur mesure, complet ou partiel",
      "Décomptes TVA et déclarations fiscales",
      'Salaires, assurances sociales et administration RH',
      'Contrôle restreint ou contrôle ordinaire de vos comptes',
      'Adresse fiscale dans le canton de Genève',
    ],
    facts: [
      { v: '1999', k: 'La comptabilité est notre cœur de métier depuis' },
      { v: 'Platine', k: 'Partenaire du logiciel bexio' },
      { v: '21', k: "Secteurs d'activité, de la restauration à la gestion de fortune" },
    ],
    aside: {
      t: 'Des prestations personnalisables',
      d: "Nous sommes une fiduciaire 360 : si vous avez des demandes particulières, nos prestations sont entièrement personnalisables. Pourquoi ne pas en discuter avec l'un de nos conseillers ?",
    },
  },
  {
    key: 'particuliers',
    slug: '/particuliers/',
    nav: 'Particuliers',
    title: 'Services pour particuliers',
    pitch: 'Vos impôts et votre patrimoine, expliqués en français clair.',
    lede: "Notre équipe vous aide à déclarer vos impôts et à améliorer votre situation fiscale. Nos services s'adressent aux personnes qui résident en Suisse comme à celles qui habitent en France et à l'étranger.",
    img: 'part',
    promise: 'Ce que nous prenons en charge',
    bullets: [
      "Déclaration de revenus auprès de l'Administration fiscale cantonale",
      "Rectification de l'impôt à la source pour frontaliers et permis B",
      'Conseil fiscal et solutions d’optimisation',
      'Déclaration de succession et obligations liées à un décès',
      'Prévoyance, 3e pilier et fiscalité immobilière',
    ],
    facts: [
      { v: 'Fin mars', k: 'Échéance ordinaire de la déclaration, prolongation possible' },
      { v: '6 883.–', k: 'Déduction annuelle maximale du pilier 3a' },
      { v: '4 yeux', k: 'Chaque déclaration est vérifiée par deux comptables-fiscalistes' },
    ],
    aside: {
      t: 'Une approche globale',
      d: "Au-delà de la déclaration, nous proposons du conseil fiscal, de la gestion de successions et de la gestion administrative. Dit simplement : nous vous libérons de vos obligations administratives et fiscales.",
    },
  },
]

export const CAT_BY_KEY = Object.fromEntries(CATEGORIES.map((c) => [c.key, c]))
