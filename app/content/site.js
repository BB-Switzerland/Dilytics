export const CONTACT = {
  phone: '+41 22 525 40 80',
  phoneHref: 'tel:+41225254080',
  mail: 'contact@dilytics.ch',
  street: 'Chemin Louis-Hubert 2, 6e étage',
  city: '1213 Petit-Lancy, Genève',
  building: 'Lancy Small City, aile 1',
  map: 'https://www.google.com/maps/place//data=!4m2!3m1!1s0x478c6ffddc2a1a31:0x788c84a4fdfefdce',
  hours: 'Lundi au vendredi, 9h – 12h et 13h – 18h',
  // the Microsoft Bookings page of the free fifteen-minute call, as linked from
  // the cabinet's current home page
  booking: 'https://outlook.office365.com/owa/calendar/ExpertDilytics@dilytics.ch/bookings/s/mKN6P3dcd06611BNeWF7nA2',
  since: 1999,
}

export const SOCIAL = [
  { label: 'LinkedIn', href: 'https://www.linkedin.com/company/dilytics-gen%C3%A8ve/' },
  { label: 'Instagram', href: 'https://www.instagram.com/dilytics.ch/' },
  { label: 'Facebook', href: 'https://www.facebook.com/people/Dilytics-Fiduciaire-%C3%A0-Gen%C3%A8ve/100086762722430/' },
]

export const LEGAL = [
  { label: 'Conditions générales de vente', to: '/conditions-generales-de-vente/' },
  { label: 'Protection des données', to: '/declaration-sur-la-protection-des-donnees/' },
]

// Proof for the home page. Dilytics asked for satisfaction first, and for
// lasting facts rather than service volumes, which date quickly: the number of
// tax returns is gone. An entry with `pending` is a figure the cabinet still has
// to send, shown as a marked slot until then; `text` is a figure the counter
// cannot count up to, such as a decimal rating.
export const STATS = [
  { n: 100, prefix: '', suffix: ' %', label: 'de retours positifs de nos clients' },
  // Google Business Profile, as sent by Dilytics
  { text: '4,6 / 5', label: 'de note moyenne, sur 66 avis Google' },
  { n: 21, prefix: '', suffix: '', label: "secteurs d'activité, de la restauration à la gestion de fortune" },
  { n: 6, prefix: '', suffix: '', label: 'langues parlées au cabinet' },
]

// What clients say, in their words and under their name. One testimonial is
// published today; the empty slots stay on the page, marked, until Dilytics
// sends the ones it wants to show.
export const REVIEWS = [
  {
    quote:
      "Monsieur Laureano Rodrigues a démontré sa capacité à sortir des sentiers battus. Nous lui avons fait confiance pour nous aider à la création de notre société et avons particulièrement apprécié : son écoute, sa réactivité et son efficacité. C'est une personne très humaine qui saura vous accompagner avec succès !",
    name: 'Nicola Balestrini',
    role: 'Co-fondateur et associé',
    company: 'Auxanõ Team Sàrl, Genève',
  },
]
export const REVIEW_SLOTS = 2

// Third-party marks the cabinet can point to.
export const DISTINCTIONS = [
  { v: 'Platine', t: 'Partenaire du logiciel bexio', img: 'bexio_platine', alt: 'Badge bexio Partenaire Platine' },
  { v: 'Swiss Label', t: 'Obtenu en novembre 2022', img: 'swiss_label', alt: 'Logo Swiss Made du Swiss Label' },
  { v: '1+ pour tous', t: "Label de l'État de Genève en faveur de l'emploi", img: 'label_1plus', alt: 'Label 1+ pour tous, Employeur responsable 2025, République et canton de Genève' },
]

// The four profiles, with the words each of them signs on the About page.
export const TEAM = [
  {
    img: 'p_laureano',
    name: 'Laureano Rodrigues',
    role: 'Membre de direction et partner, CEO',
    quote:
      "Avec l'expérience que j'ai développée en management et dans la gestion de sociétés fiduciaires, j'ai très vite constaté que l'importance n'était pas accordée aux projets des clients, et c'est frustrant. Avec Dilytics, je souhaite aller au-delà du simple appui comptable : avec mon équipe, je propose un service orienté sur des solutions concrètes et adaptées aux attentes des entreprises d'aujourd'hui.",
    diploma: 'BBA, Bachelor Business Administration · Conseiller IAF',
    langs: 'Français · Anglais · Allemand · Portugais · Espagnol',
    linkedin: 'https://ch.linkedin.com/in/laureano-rodrigues',
  },
  {
    img: 'p_nervan',
    name: 'Nervan Omerovic',
    role: 'Membre de direction et partner, COO et digitalisation',
    quote:
      "Avec l'expérience que j'ai développée en comptabilité dans un grand cabinet, j'ai rejoint Dilytics pour aller au-delà du simple appui comptable traditionnel. J'allie rigueur comptable et innovation, notamment grâce à l'automatisation et à l'intelligence artificielle, pour construire des solutions simples et efficaces tout en contribuant à la digitalisation des processus.",
    diploma: 'BBA, Bachelor Business Administration',
    langs: 'Français · Anglais · Bosniaque',
    linkedin: 'https://www.linkedin.com/in/nomerovic/',
  },
  {
    img: 'p_walid',
    name: 'Walid Berkaoui',
    role: 'Expert-comptable diplômé, responsable de mandats PME',
    quote:
      "J'ai accompagné de nombreux dirigeants dans la structuration, la gestion et la croissance de leur entreprise, notamment au sein d'un grand cabinet international. Chez Dilytics, mon objectif est d'être un véritable partenaire stratégique, en accompagnant chaque client avec rigueur, écoute et une vision à long terme, de la création à la transmission de son entreprise.",
    diploma: "DEC (Diplôme d'Expert-Comptable)",
    langs: 'Français · Anglais · Arabe',
    linkedin: 'https://www.linkedin.com/in/walid-berkaoui-438455110/',
  },
  {
    img: 'p_henrique',
    name: 'Henrique Santos',
    role: 'Responsable de mandats PME',
    quote:
      "Je suis comptable pour les PME que Dilytics accompagne. Je souhaite mobiliser mon pragmatisme et ma minutie pour fournir un accompagnement sur mesure qui répond à tous les défis de la gestion d'entreprise. Je m'identifie parfaitement dans la philosophie de Dilytics, qui consiste à valoriser le capital humain et la formation continue.",
    diploma: 'BBA, Bachelor Business Administration',
    langs: 'Portugais · Français · Anglais · Espagnol',
    linkedin: 'https://ch.linkedin.com/in/henriquesantos1989',
  },
]

export const ARTICLES = [
  {
    slug: 'reforme-tva-2025-en-suisse-preparez-votre-entreprise',
    kicker: 'TVA',
    title: 'Réforme TVA 2025 en Suisse : préparez votre entreprise',
    excerpt: 'Ce que la réforme de la TVA change pour les entreprises suisses, et comment s’y préparer.',
    date: '29 novembre 2024',
    img: 'crop_screen',
  },
  {
    slug: 'creer-sa-start-up-en-suisse-guide-complet-pour-les-entrepreneurs',
    kicker: 'Création',
    title: 'Créer sa start-up en Suisse : guide complet pour les entrepreneurs',
    excerpt: 'Les étapes de la création d’une start-up en Suisse, du choix de la forme juridique à l’inscription.',
    date: '1er novembre 2024',
    img: 'crop_hands',
  },
  {
    slug: 'bexio-et-dilytics-duo-gagnant-pour-une-gestion-financiere-efficace',
    kicker: 'Outils',
    title: 'Bexio et Dilytics : duo gagnant pour une gestion financière efficace',
    excerpt: 'Comment le logiciel bexio s’intègre à l’accompagnement comptable du cabinet.',
    date: '30 septembre 2024',
    img: 'desk',
  },
  {
    slug: 'paradis-fiscaux-brisons-les-mythes',
    kicker: 'Fiscalité',
    title: 'Paradis fiscaux : brisons les mythes',
    excerpt: 'Ce que recouvrent réellement les notions de paradis fiscal et d’optimisation.',
    date: '9 septembre 2024',
    img: 'geneve',
  },
  {
    slug: 'fiscalite-numerique-gagnez-en-efficacite-et-securite',
    kicker: 'Fiscalité',
    title: 'Fiscalité numérique : gagnez en efficacité et sécurité',
    excerpt: 'La dématérialisation des obligations fiscales et ce qu’elle change au quotidien.',
    date: '15 juillet 2024',
    img: 'revision',
  },
  {
    slug: 'determinez-la-rentabilite-de-votre-entreprise-guide-complet',
    kicker: 'Gestion',
    title: 'Déterminez la rentabilité de votre entreprise : guide complet',
    excerpt: 'Les indicateurs qui disent si une activité est rentable, et comment les lire.',
    date: '12 juillet 2024',
    img: 'audit',
  },
  {
    slug: 'comment-bien-choisir-sa-fiduciaire',
    kicker: 'Fiduciaire',
    title: 'Comment bien choisir sa fiduciaire ?',
    excerpt: 'Les critères à examiner avant de confier sa comptabilité à un cabinet.',
    date: '28 mars 2023',
    img: 'domicil',
  },
]
