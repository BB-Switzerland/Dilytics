// One entry per service page. Everything the templates render comes from here,
// so a new page is a new object rather than a new file.
//
// Every lede, fact, question and answer below is taken from the cabinet's own
// published pages. Where the site gives no figure, none is invented. A fact
// that cannot be sourced simply does not appear.

export const GROUPS = {
  crea: { label: "Création d'entreprise", short: 'Création', img: 'crea' },
  entreprises: { label: 'Entreprises', short: 'Entreprises', img: 'entr' },
  particuliers: { label: 'Particuliers', short: 'Particuliers', img: 'part' },
}

export const SERVICES = [
  /* ------------------------------------------------------ création */
  {
    slug: '/creation-de-raison-individuelle/',
    group: 'crea',
    nav: 'Création de RI',
    title: 'Raison individuelle',
    lede: "Une raison individuelle est une entreprise exploitée par une seule personne, qui obtient le statut d'indépendant à l'égard des entités publiques et privées. C'est la façon la plus simple et la moins coûteuse d'être son propre patron.",
    img: 'ri',
    facts: [
      { k: 'Capital minimum', v: 'Aucun' },
      { k: 'Responsabilité', v: 'Illimitée' },
      { k: 'Comptabilité complète', v: "Dès 500'000.– de CA" },
    ],
    faq: [
      {
        q: "Dois-je m'inscrire au registre du commerce ?",
        a: "L'inscription est obligatoire pour toute entreprise individuelle qui dépasse un certain chiffre d'affaires. Dilytics peut s'en occuper, en ligne ou en personne, auprès du registre du commerce du canton de votre choix.",
      },
      {
        q: 'Quelle est la différence de responsabilité avec une Sàrl ?',
        a: "En raison individuelle, votre responsabilité est illimitée : vous pouvez être tenu personnellement responsable des dettes de l'entreprise en cas de faillite ou de difficultés financières. Une Sàrl ou une SA est une entité juridique distincte de ses propriétaires, qui ne répondent des dettes qu'à hauteur de leur investissement initial.",
      },
      {
        q: 'Le nom de mon entreprise est-il libre ?',
        a: "Il doit être unique, ne pas être déjà utilisé par une entreprise inscrite en Suisse, et contenir obligatoirement votre nom de famille, par exemple « Consulting NOM ».",
      },
    ],
    related: [
      '/creer-une-sarl-en-suisse-facile/',
      '/creation-de-societe-anonyme/',
      '/conseil-fiscal/',
    ],
  },
  {
    slug: '/creer-une-sarl-en-suisse-facile/',
    group: 'crea',
    nav: 'Création de Sàrl',
    title: 'Société à responsabilité limitée',
    lede: "La société à responsabilité limitée vous permet de développer vos activités, d'embaucher du personnel et d'obtenir des financements. En Suisse, elle reste meilleur marché que la société anonyme.",
    img: 'sarl',
    facts: [
      { k: 'Responsabilité', v: 'Limitée aux apports' },
      { k: 'Frais de notaire', v: 'Inclus dans le prix' },
      { k: 'Registre du commerce', v: 'Inclus dans le prix' },
    ],
    faq: [
      {
        q: 'Pourquoi une Sàrl plutôt qu’une raison individuelle ?',
        a: "Les associés d'une Sàrl ont une responsabilité limitée au montant de leurs apports respectifs. En cas de faillite, ils ne sont pas personnellement responsables des dettes de la société : l'entrepreneur peut rebondir sans que son patrimoine personnel soit directement touché.",
      },
      {
        q: 'Y a-t-il des frais en plus du tarif annoncé ?',
        a: "Non. Dilytics propose un tarif toutes charges comprises et s'occupe de toute la procédure de création sans facturer de prestation supplémentaire. Nous n'avons pas d'intermédiaires et fonctionnons avec nos propres conseillers.",
      },
      {
        q: 'Est-il facile de revendre une Sàrl ?',
        a: "Plus facile qu'une entreprise individuelle : les parts sociales peuvent être cédées à un tiers, alors que la transmission d'une raison individuelle suppose un contrat de vente portant sur l'ensemble des actifs et passifs.",
      },
    ],
    related: [
      '/creation-de-raison-individuelle/',
      '/creation-de-societe-anonyme/',
      '/mandat-de-gerant-et-administrateur-en-suisse/',
      '/domiciliation-a-geneve/',
    ],
  },
  {
    slug: '/creation-de-societe-anonyme/',
    group: 'crea',
    nav: 'Création de SA',
    title: 'Société anonyme',
    lede: "La société anonyme vous permet d'obtenir des financements et de développer une entreprise avec des objectifs de croissance ambitieux.",
    img: 'sa',
    facts: [
      { k: 'Financement', v: 'Actions et obligations' },
      { k: 'Transfert de propriété', v: 'Sans publication au RC' },
      { k: 'Frais de notaire', v: 'Inclus dans le prix' },
    ],
    faq: [
      {
        q: 'Quel est l’avantage de la SA sur la Sàrl ?',
        a: "La SA lève des fonds plus facilement : elle peut émettre des actions et des obligations, ce qui est particulièrement utile pour financer des projets à grande échelle ou procéder à des acquisitions. La Sàrl ne peut lever des fonds que par emprunt ou par contribution en capital de ses associés.",
      },
      {
        q: 'Comment se transmettent les actions ?',
        a: "Les actions peuvent être vendues ou transférées sans l'accord des autres actionnaires et sans publication officielle au registre du commerce. Dans une Sàrl, il faut souvent l'accord des autres associés et le passage chez un notaire.",
      },
      {
        q: 'Faut-il commencer directement par une SA ?',
        a: "La SA demande un investissement initial plus important. En cas de budget restreint, il peut être pertinent de démarrer avec une Sàrl : la forme la plus appropriée dépend des besoins de l'entreprise et de ses objectifs à long terme.",
      },
    ],
    related: [
      '/creation-de-raison-individuelle/',
      '/creer-une-sarl-en-suisse-facile/',
      '/mandat-de-gerant-et-administrateur-en-suisse/',
      '/domiciliation-a-geneve/',
    ],
  },

  /* --------------------------------------------------- entreprises */
  {
    slug: '/comptabilite-geneve-experts-fiduciaire/',
    group: 'entreprises',
    nav: 'Comptabilité',
    title: 'Comptabilité',
    lede: "Notre équipe prend en charge la comptabilité de votre entreprise ou de votre activité d'indépendant. La comptabilité est notre cœur de métier depuis 1999.",
    img: 'compta',
    facts: [
      { k: 'Norme appliquée', v: 'Code des obligations' },
      { k: 'Délégation', v: 'Totale ou partielle' },
      { k: 'Analyse de vos comptes', v: 'Offerte' },
    ],
    faq: [
      {
        q: 'Puis-je ne déléguer qu’une partie de ma comptabilité ?',
        a: "Oui. Vous avez la possibilité de déléguer complètement ou partiellement vos tâches comptables : nos conseillers s'adaptent à vos besoins.",
      },
      {
        q: 'Puis-je suivre mes écritures moi-même ?',
        a: "Oui. Vous avez l'opportunité de suivre en temps réel les écritures comptables de votre entreprise.",
      },
      {
        q: 'Le montant du devis peut-il évoluer en cours de mandat ?',
        a: "Nous respectons le montant des devis que nous vous envoyons.",
      },
    ],
    related: [
      '/tva-suisse/',
      '/payroll-et-administration-rh/',
      '/audit-des-comptes/',
      '/mandat-de-gerant-et-administrateur-en-suisse/',
    ],
  },
  {
    slug: '/domiciliation-a-geneve/',
    group: 'entreprises',
    nav: 'Domiciliation',
    title: 'Domiciliation à Genève',
    lede: "Grâce à une adresse fiscale de confiance dans le canton de Genève, vous pourrez rapidement démarrer vos activités en Suisse. C'est l'alternative au paiement d'un loyer.",
    img: 'domicil',
    facts: [
      { k: 'Adresse', v: 'Petit-Lancy, Genève' },
      { k: 'Courrier scanné', v: 'Sans frais' },
      { k: 'Inscription au RC', v: 'Domiciliation obligatoire' },
    ],
    faq: [
      {
        q: 'Pourquoi une domiciliation est-elle nécessaire ?',
        a: "Pour s'inscrire au registre du commerce, votre société doit disposer d'une adresse professionnelle en Suisse. La domiciliation est donc obligatoire.",
      },
      {
        q: 'Comment vais-je recevoir mon courrier ?',
        a: "Par courriel, ou vous venez le chercher à notre bureau, sans frais supplémentaires. Nous scannons votre courrier gratuitement.",
      },
      {
        q: 'Pourquoi Lancy plutôt qu’ailleurs ?',
        a: "La commune est située à proximité immédiate de Genève et bien desservie par les transports publics. Elle offre un environnement favorable aux entreprises et une fiscalité avantageuse, avec des taux d'imposition compétitifs.",
      },
    ],
    related: [
      '/comptabilite-geneve-experts-fiduciaire/',
      '/payroll-et-administration-rh/',
      '/tva-suisse/',
      '/mandat-de-gerant-et-administrateur-en-suisse/',
    ],
  },
  {
    slug: '/payroll-et-administration-rh/',
    group: 'entreprises',
    nav: 'Payroll et administration RH',
    title: 'Payroll et administration RH',
    lede: "Gérer des salaires peut vous faire perdre du temps et de l'argent. Nos spécialistes s'adaptent aux exigences de vos caisses, au droit du travail et aux conventions collectives de votre secteur.",
    img: 'payroll',
    facts: [
      { k: 'Facturation', v: 'Par employé et par mois' },
      { k: 'Périmètre', v: 'Les tâches de votre choix' },
      { k: 'Cadre appliqué', v: 'Droit du travail et CCT' },
    ],
    faq: [
      {
        q: 'Quelles tâches puis-je vous déléguer ?',
        a: "La déclaration annuelle des salaires, la rédaction des contrats de travail, l'élaboration des fiches de paie, l'inscription aux assurances sociales, la déclaration des accidents et des maladies, ainsi que les démarches obligatoires en cas d'embauche ou de licenciement.",
      },
      {
        q: 'Est-ce que je garde la main sur ma politique salariale ?',
        a: "Oui. Vous gardez la main sur votre politique salariale, vos recrutements et vos licenciements.",
      },
      {
        q: 'Pourquoi ne pas gérer les salaires en interne ?',
        a: "Le domaine demande de la rigueur et des connaissances solides en comptabilité et en droit du travail. Toute erreur dans la déclaration annuelle des salaires peut jouer en votre défaveur et mettre en péril la santé financière de votre société.",
      },
    ],
    related: [
      '/comptabilite-geneve-experts-fiduciaire/',
      '/tva-suisse/',
      '/conseil-fiscal/',
      '/audit-des-comptes/',
    ],
  },
  {
    slug: '/tva-suisse/',
    group: 'entreprises',
    nav: 'TVA',
    title: 'TVA',
    lede: "Notre équipe d'experts établit vos décomptes TVA et vous inscrit auprès des autorités de taxation. Une omission ou une erreur peut ouvrir la porte à des risques financiers.",
    img: 'tva',
    facts: [
      { k: 'Taux normal', v: '8,1 %' },
      { k: 'Taux réduit', v: '2,6 %' },
      { k: 'Assujettissement', v: "Dès 100'000.– de CA" },
    ],
    faq: [
      {
        q: 'À partir de quand suis-je assujetti ?',
        a: "Toute société qui dépasse un chiffre d'affaires annuel de 100 000 francs est assujettie, entreprises individuelles comprises. Le seuil est de 150 000 francs pour les associations à but non lucratif.",
      },
      {
        q: 'Quel est le délai pour m’annoncer ?',
        a: "L'annonce est obligatoire dès que vos projections indiquent que vous atteindrez 100 000 francs de chiffre d'affaires dans l'année fiscale en cours. Une fois ce chiffre atteint, vous avez 30 jours pour obtenir votre numéro d'immatriculation auprès de l'Administration fédérale des contributions.",
      },
      {
        q: 'L’assujettissement volontaire a-t-il un intérêt ?',
        a: "Si vous venez de commencer votre activité et n'avez pas encore atteint le seuil, il peut constituer une bonne stratégie fiscale : cette démarche proactive vous permet de récupérer la taxe sur les produits et services achetés lors du lancement de vos activités.",
      },
    ],
    related: [
      '/comptabilite-geneve-experts-fiduciaire/',
      '/payroll-et-administration-rh/',
      '/audit-des-comptes/',
      '/mandat-de-gerant-et-administrateur-en-suisse/',
    ],
  },
  {
    slug: '/mandat-de-gerant-et-administrateur-en-suisse/',
    group: 'entreprises',
    nav: "Mandat de gérant",
    title: "Mandat de gérant et d'administrateur",
    lede: "Une personne de notre direction peut être nommée gérant ou administrateur de votre société en Suisse, que vous habitiez ici ou ailleurs.",
    img: 'mandat',
    facts: [
      { k: 'Rôle', v: 'Gérant ou administrateur' },
      { k: 'Exigence légale', v: 'Un résident suisse au RC' },
      { k: 'Formes concernées', v: 'Sàrl et SA' },
    ],
    faq: [
      {
        q: 'Pourquoi nommer un gérant résidant en Suisse ?',
        a: "Au moins un administrateur ou un directeur vivant en Suisse doit être mentionné au registre du commerce. Son rôle est de représenter la société auprès des autorités du pays.",
      },
      {
        q: 'Que fait le gérant au-delà de la représentation ?',
        a: "Nos experts vous font profiter de leur expérience d'administrateurs de sociétés : problématiques fiscales, communication avec les instituts bancaires et les administrations, élaboration de budgets et de business plans, mise en place de logiciels de gestion et de comptabilité analytique, conseil ou direction financière.",
      },
      {
        q: 'Est-ce réservé aux dirigeants établis à l’étranger ?',
        a: "Non. Le service est également utile aux membres de la direction soucieux d'écouter les conseils d'un expert avant de prendre des décisions financières et juridiques pour l'entreprise.",
      },
    ],
    related: [
      '/comptabilite-geneve-experts-fiduciaire/',
      '/tva-suisse/',
      '/payroll-et-administration-rh/',
      '/audit-des-comptes/',
    ],
  },
  {
    slug: '/audit-des-comptes/',
    group: 'entreprises',
    nav: 'Audit des comptes',
    title: 'Audit des comptes',
    lede: "Dilytics propose un service d'audit des comptes adapté aux besoins des PME et des jeunes entreprises en phase de croissance.",
    img: 'audit',
    facts: [
      { k: 'Contrôle restreint', v: 'Dès 10 employés' },
      { k: 'Contrôle ordinaire', v: '2 critères sur 3' },
      { k: 'Organe de révision', v: 'Réviseurs agréés externes' },
    ],
    faq: [
      {
        q: 'Mon entreprise doit-elle passer un audit ?',
        a: "Le contrôle restreint s'applique à toutes les entreprises qui comptent au minimum 10 employés. Il peut également être mis en place si un ou plusieurs associés en font la demande.",
      },
      {
        q: 'Quand le contrôle ordinaire est-il obligatoire ?',
        a: "Si deux des trois critères suivants sont remplis : un effectif de plus de 250 employés, un bilan d'au moins 20 millions de francs, ou un chiffre d'affaires annuel d'au moins 40 millions.",
      },
      {
        q: 'Que couvre votre mission ?',
        a: "Révision et contrôle des comptes, vérification des procédures de contrôle interne, conseils et propositions d'amélioration, et sur demande d'autres prestations comme la comptabilité analytique ou l'analyse de rentabilité.",
      },
    ],
    related: [
      '/controle-restreint/',
      '/tva-suisse/',
      '/comptabilite-geneve-experts-fiduciaire/',
      '/conseil-fiscal/',
    ],
  },
  {
    slug: '/controle-restreint/',
    group: 'entreprises',
    nav: 'Contrôle restreint',
    title: 'Contrôle restreint',
    lede: "Votre entreprise doit effectuer un contrôle restreint ? Il s'agit d'une mission d'examen limitée, effectuée par un réviseur agréé, qui donne une opinion sur vos comptes annuels.",
    img: 'revision',
    facts: [
      { k: 'Réviseur', v: 'Agréé ASR' },
      { k: 'Portée', v: 'Examen limité' },
      { k: 'Obligation', v: 'Dès 10 employés à plein temps' },
    ],
    faq: [
      {
        q: 'En quoi diffère-t-il du contrôle ordinaire ?',
        a: "Le contrôle ordinaire implique une évaluation approfondie des systèmes et des processus de l'entreprise, des tests substantifs et des procédures de vérification étendues. Le contrôle restreint se limite à la vérification des états financiers et à une attestation de garantie destinée aux parties prenantes.",
      },
      {
        q: 'Qui peut l’effectuer ?',
        a: "Un réviseur agréé ASR. Il analyse les comptes annuels de manière limitée et fournit une opinion sur la conformité des états financiers aux principes comptables suisses.",
      },
      {
        q: 'Quand devient-il obligatoire ?',
        a: "En cas de difficulté financière, ou dès l'engagement de plus de 10 employés à plein temps. Il est par ailleurs exigé en cas d'opting-in.",
      },
    ],
    related: [
      '/audit-des-comptes/',
      '/comptabilite-geneve-experts-fiduciaire/',
      '/tva-suisse/',
      '/conseil-fiscal/',
    ],
  },
  {
    slug: '/gestion-de-ppe/',
    group: 'entreprises',
    nav: 'Gestion de PPE',
    title: 'Gestion de PPE',
    lede: "Notre équipe réalise toutes les démarches administratives et fiscales nécessaires à la bonne gestion de votre propriété par étage.",
    img: 'ppe',
    facts: [
      { k: 'Gestion financière', v: 'Charges, budget, états financiers' },
      { k: 'Analyse et devis', v: 'Gratuits' },
      { k: 'Dossiers copropriétaires', v: 'Confidentiels' },
    ],
    faq: [
      {
        q: 'Que couvre la gestion financière ?',
        a: "La collecte des frais de copropriété, la gestion des dépenses, la budgétisation et la préparation des états financiers.",
      },
      {
        q: 'L’analyse est-elle payante ?',
        a: "Non. Si vous souhaitez nous transmettre la gestion financière de votre PPE, nous procédons à l'analyse et au devis gratuitement avec vous.",
      },
      {
        q: 'Intervenez-vous en cas de conflit ?',
        a: "Notre gamme de services comprend la gestion financière, la maintenance de la propriété et la résolution des conflits en cas de besoin, avec un regard impartial.",
      },
    ],
    related: [
      '/fiscalite-immobiliere/',
      '/conseil-fiscal/',
      '/comptabilite-geneve-experts-fiduciaire/',
      '/declaration-dimpots/',
    ],
  },

  /* -------------------------------------------------- particuliers */
  {
    slug: '/declaration-dimpots/',
    group: 'particuliers',
    nav: "Déclaration d'impôts",
    title: "Déclaration d'impôts",
    lede: "Notre équipe réalise votre déclaration de revenus auprès de l'Administration fiscale cantonale, quelle que soit votre situation professionnelle et personnelle.",
    img: 'impots',
    facts: [
      { k: 'Échéance ordinaire', v: 'Fin mars' },
      { k: 'Vérification', v: 'Deux comptables-fiscalistes' },
      { k: 'Prolongation', v: 'Demandée par nos soins' },
    ],
    faq: [
      {
        q: 'Quel est le délai pour déclarer ?',
        a: "L'échéance est habituellement fixée au dernier jour du mois de mars de l'année qui suit la période fiscale. Une prolongation peut être demandée, et notre équipe peut s'en charger pour vous.",
      },
      {
        q: 'Quels documents dois-je vous transmettre ?',
        a: "Les documents liés aux revenus et vos extraits bancaires, vos frais d'assurance maladie et accidents, ainsi que vos justificatifs liés à une pension ou à des enfants à charge.",
      },
      {
        q: 'Qui relit ma déclaration ?',
        a: "Chaque déclaration est vérifiée par deux comptables-fiscalistes, et votre dossier est traité en toute confidentialité.",
      },
    ],
    related: [
      '/particuliers-impot-a-la-source/',
      '/conseil-fiscal/',
      '/comptabilite-geneve-experts-fiduciaire/',
      '/gestion-administrative/',
    ],
  },
  {
    slug: '/particuliers-impot-a-la-source/',
    group: 'particuliers',
    nav: 'Impôt à la source',
    title: 'Impôt à la source',
    lede: "Vous êtes frontalier ou titulaire d'un permis B ? Le montant prélevé à la source ne tient pas compte de certaines déductions auxquelles vous avez droit. Nous effectuons la demande de rectification.",
    img: 'source',
    facts: [
      { k: 'Concernés', v: 'Frontaliers et permis B' },
      { k: 'Démarche', v: 'Demande de rectification' },
      { k: 'Vérification', v: 'Deux comptables-fiscalistes' },
    ],
    faq: [
      {
        q: 'Qui est soumis à l’impôt à la source ?',
        a: "Les résidents temporaires et les travailleurs frontaliers, notamment les titulaires d'un permis B.",
      },
      {
        q: 'Pourquoi demander une rectification ?',
        a: "Le montant prélevé ne prend pas en compte certaines déductions auxquelles vous avez droit. Grâce à cette démarche, il est probable que vous récupériez l'argent payé en trop.",
      },
      {
        q: 'Que dois-je fournir ?',
        a: "Vos documents justificatifs, tels que vos certificats de salaire et vos attestations d'assurance maladie. Nous nous occupons du reste.",
      },
    ],
    related: [
      '/declaration-dimpots/',
      '/conseil-fiscal/',
      '/comptabilite-geneve-experts-fiduciaire/',
      '/gestion-administrative/',
    ],
  },
  {
    slug: '/conseil-fiscal/',
    group: 'particuliers',
    nav: 'Conseil fiscal',
    title: 'Conseil fiscal',
    lede: "Nos comptables-fiscalistes étudient votre situation et vous proposent des actions d'optimisation fiscale. Experts depuis 1999, notre cabinet est spécialisé dans l'imposition des personnes physiques et des entreprises.",
    img: 'conseilfisc',
    facts: [
      { k: 'Expertise depuis', v: '1999' },
      { k: 'Périmètre', v: 'Personnes physiques et entreprises' },
      { k: "Niveaux d'imposition", v: 'Fédéral, cantonal, communal' },
    ],
    faq: [
      {
        q: 'Sur quoi porte le conseil ?',
        a: "Sur l'imposition des personnes physiques et des entreprises. Nos fiscalistes évaluent les impacts que certains éléments peuvent avoir sur vos impôts et vous proposent les meilleurs plans d'action pour préserver vos finances.",
      },
      {
        q: 'Pouvez-vous répondre à l’administration à ma place ?',
        a: "Oui. Nos fiscalistes se chargent de répondre aux demandes à votre place, afin d'éviter la taxation d'office.",
      },
      {
        q: 'Pourquoi la fiscalité suisse est-elle si complexe ?',
        a: "Le système fiscal se subdivise en trois niveaux (fédéral, cantonal et communal) et les impôts cantonaux et communaux peuvent grandement varier d'un lieu à l'autre.",
      },
    ],
    related: [
      '/declaration-dimpots/',
      '/particuliers-impot-a-la-source/',
      '/comptabilite-geneve-experts-fiduciaire/',
      '/prevoyance-3eme-pilier-geneve/',
    ],
  },
  {
    slug: '/declaration-de-succession/',
    group: 'particuliers',
    nav: 'Déclaration de succession',
    title: 'Déclaration de succession',
    lede: "La gestion d'une succession est une obligation qui doit s'effectuer dans un contexte délicat pour la famille. Notre équipe vous accompagne dans toutes les étapes administratives et fiscales.",
    img: 'succession',
    facts: [
      { k: 'Conjoint et enfants', v: '50 % au conjoint' },
      { k: 'Sans descendants directs', v: '75 % au conjoint' },
      { k: 'Interlocuteur', v: 'Administration fiscale cantonale' },
    ],
    faq: [
      {
        q: 'Que se passe-t-il en l’absence de testament ?',
        a: "Le droit suisse des successions s'applique : le conjoint survivant a droit à 50 % de la succession en concurrence avec les descendants directs, à 75 % s'il n'y a pas de descendants directs mais qu'un parent ou un frère ou une sœur est encore en vie, et à 100 % des actifs et des passifs dans les autres situations.",
      },
      {
        q: 'Quels sont mes droits en tant qu’héritier ?',
        a: "Vous pouvez accepter la succession avec ou sans bénéfice d'inventaire, la faire liquider officiellement en mandatant une fiduciaire, ou en demander la répudiation.",
      },
      {
        q: 'Quels documents faut-il réunir ?',
        a: "Le certificat de décès, le certificat d'héritier, l'inventaire des biens à transmettre et le code pour la déclaration fiscale feue. Avec ces pièces, nous établissons la déclaration auprès de l'Administration fiscale cantonale et clôturons les obligations fiscales de la personne décédée.",
      },
    ],
    related: [
      '/conseil-fiscal/',
      '/declaration-dimpots/',
      '/gestion-administrative/',
      '/comptabilite-geneve-experts-fiduciaire/',
    ],
  },
  {
    slug: '/prevoyance-3eme-pilier-geneve/',
    group: 'particuliers',
    nav: 'Prévoyance 3e pilier',
    title: 'Prévoyance et 3e pilier',
    lede: "Nos experts vous aident à choisir le meilleur plan d'épargne pour votre retraite et vos projets d'investissement, et à faire baisser votre pression fiscale.",
    img: 'pilier3',
    facts: [
      { k: 'Déduction pilier 3a', v: "Jusqu'à 6 883.– par an" },
      { k: 'Indépendant sans caisse', v: "Jusqu'à 34 416.–" },
      { k: 'Notre accompagnement', v: 'Gratuit' },
    ],
    faq: [
      {
        q: 'Combien puis-je déduire avec un pilier 3a ?',
        a: "Jusqu'à 6 883 francs par an. Ce montant peut aller jusqu'à 34 416 francs si vous êtes indépendant et non affilié à une caisse de pension.",
      },
      {
        q: 'Quelle différence entre le 3a et le 3b ?',
        a: "Le pilier 3a permet d'épargner un montant déductible des impôts, retirable au départ à la retraite ou lors de certains événements comme l'achat d'une résidence principale. Le pilier 3b n'a pas de limite de versement et peut être retiré à tout moment, mais il n'est pas déductible.",
      },
      {
        q: 'Pourquoi passer par une fiduciaire indépendante ?',
        a: "Pour comparer toutes les options qui existent en Suisse, trouver le plan d'épargne le mieux adapté à votre situation, bénéficier de conseils fiscaux personnalisés et accéder à des simulations fiscales avant de décider.",
      },
    ],
    related: [
      '/declaration-dimpots/',
      '/particuliers-impot-a-la-source/',
      '/conseil-fiscal/',
      '/gestion-administrative/',
    ],
  },
  {
    slug: '/gestion-administrative/',
    group: 'particuliers',
    nav: 'Gestion administrative',
    title: 'Gestion administrative',
    lede: "Nos experts vous aident dans toutes vos tâches administratives, sur une base ponctuelle ou régulière : assurances, paiements de factures, gestion du courrier.",
    img: 'admin',
    facts: [
      { k: 'Formule', v: 'Ponctuelle ou régulière' },
      { k: 'Suivi régulier', v: 'Abonnement mensuel' },
      { k: 'Réactivité', v: 'Moins de 24 h ouvrables' },
    ],
    faq: [
      {
        q: 'Quelles démarches prenez-vous en charge ?',
        a: "Rédaction de courriers, démarches auprès des assurances, demande de remboursement de frais médicaux, changement et demande de statut de résidence, contestation et renégociation de poursuites, état des lieux de votre résidence, ouverture de comptes bancaires, gestion des factures et résiliation de contrats.",
      },
      {
        q: 'Puis-je vous confier une seule démarche ?',
        a: "Oui. Pour une aide ponctuelle, il suffit de nous soumettre votre demande et nous la réglons dans les plus brefs délais. Un suivi régulier est aussi possible, sous forme d'abonnement mensuel.",
      },
      {
        q: 'Sous quel délai répondez-vous ?',
        a: "Nous répondons à vos demandes en moins de 24 heures les jours ouvrables. Chaque document est vérifié par deux experts de notre équipe.",
      },
    ],
    related: [
      '/conseil-fiscal/',
      '/declaration-dimpots/',
      '/particuliers-impot-a-la-source/',
      '/prevoyance-3eme-pilier-geneve/',
    ],
  },
  {
    slug: '/fiscalite-immobiliere/',
    group: 'particuliers',
    nav: 'Fiscalité immobilière',
    title: 'Fiscalité immobilière',
    lede: "Les réglementations fiscales suisses pèsent sur les investissements immobiliers, les ventes de biens et les revenus locatifs. Notre équipe vous accompagne dans vos obligations fiscales.",
    img: 'immo',
    facts: [
      { k: 'Gains en capital', v: 'Exonérés après 5 ans' },
      { k: 'Impôts fonciers', v: 'Assis sur la valeur locative' },
      { k: 'Revenus locatifs', v: 'Frais déductibles' },
    ],
    faq: [
      {
        q: 'Comment sont calculés les impôts fonciers ?',
        a: "Ce sont des impôts locaux prélevés sur la propriété immobilière, basés sur la valeur locative du bien, calculée par les autorités fiscales selon sa taille et sa situation géographique. Les taux varient selon les cantons et les communes.",
      },
      {
        q: 'Quand les gains en capital sont-ils exonérés ?',
        a: "Les gains en capital sur les biens immobiliers détenus depuis plus de cinq ans sont exempts d'impôt en Suisse. Les frais de courtage, d'avocat et de notaire liés à la vente peuvent par ailleurs être déduits de la base d'imposition.",
      },
      {
        q: 'Que puis-je déduire de mes revenus locatifs ?',
        a: "Les frais de location (gestion, maintenance, assurance) se déduisent du revenu locatif brut pour déterminer le revenu locatif net imposable.",
      },
    ],
    related: [
      '/gestion-de-ppe/',
      '/comptabilite-geneve-experts-fiduciaire/',
      '/conseil-fiscal/',
      '/declaration-dimpots/',
    ],
  },
]

export const BY_SLUG = Object.fromEntries(SERVICES.map((s) => [s.slug, s]))
export const byGroup = (key) => SERVICES.filter((s) => s.group === key)
