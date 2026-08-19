// Commercial layer, kept apart from the editorial content. The pitches are the
// cabinet's own cross-sell one-liners and the prices are the figures it
// publishes. A service with no published price simply has no entry here.

export const PITCH = {
  '/creation-de-raison-individuelle/': "Obtenez votre statut d'indépendant en Suisse.",
  '/creer-une-sarl-en-suisse-facile/': 'Entreprenez avec sérénité grâce à votre Sàrl.',
  '/creation-de-societe-anonyme/': 'Concrétisez un projet ambitieux avec votre SA.',
  '/comptabilite-geneve-experts-fiduciaire/':
    'Nous traitons la comptabilité de votre entreprise ou de votre activité indépendante.',
  '/domiciliation-a-geneve/':
    'Obtenez une adresse fiscale à Genève pour vous inscrire au registre du commerce.',
  '/payroll-et-administration-rh/': 'Nous administrons les salaires de votre équipe.',
  '/tva-suisse/': "Nos fiscalistes s'occupent de vos décomptes TVA et de vos déclarations.",
  '/mandat-de-gerant-et-administrateur-en-suisse/':
    "Dirigez votre société en Suisse depuis l'étranger.",
  '/audit-des-comptes/':
    'Respectez vos obligations fiscales grâce à un contrôle de vos comptes.',
  '/controle-restreint/': 'Confiez votre contrôle restreint à une équipe rigoureuse.',
  '/gestion-de-ppe/': 'Confiez la gestion de votre PPE à notre équipe.',
  '/declaration-dimpots/': 'Faites baisser le montant de vos impôts grâce à nos experts.',
  '/particuliers-impot-a-la-source/': "Bénéficiez d'une rectification de votre impôt à la source.",
  '/conseil-fiscal/': 'Obtenez des conseils personnalisés pour réduire votre charge fiscale.',
  '/declaration-de-succession/':
    "Notre équipe s'occupe de toutes les étapes vis-à-vis de la déclaration de succession en Suisse.",
  '/prevoyance-3eme-pilier-geneve/': "Obtenez le meilleur plan d'épargne pour votre retraite.",
  '/gestion-administrative/':
    'Nous vous libérons de vos tâches administratives, sur une base ponctuelle ou régulière.',
  '/fiscalite-immobiliere/': 'Un accompagnement fiscal dans vos projets immobiliers.',
}

// The full, unambiguous page heading where the short editorial title is not
// explicit enough for someone arriving from a search.
export const H1 = {
  '/creation-de-raison-individuelle/': 'Création de raison individuelle',
  '/creer-une-sarl-en-suisse-facile/': 'Création de Sàrl',
  '/creation-de-societe-anonyme/': 'Création de société anonyme',
  '/payroll-et-administration-rh/': 'Payroll et administration RH',
  '/particuliers-impot-a-la-source/': 'Impôt à la source',
  '/comptabilite-geneve-experts-fiduciaire/': 'Comptabilité',
  '/domiciliation-a-geneve/': 'Domiciliation à Genève',
  '/mandat-de-gerant-et-administrateur-en-suisse/': "Mandat de gérant et d'administrateur",
  '/prevoyance-3eme-pilier-geneve/': 'Prévoyance et 3e pilier',
}

// Published prices only.
export const PRICE = {
  '/creation-de-raison-individuelle/': {
    lead: 'Création de RI à partir de',
    amount: '990',
    unit: 'CHF',
    terms: 'Toutes taxes comprises',
    detail:
      "N'hésitez pas à nous contacter si vous avez pour projet de créer votre raison individuelle. Dilytics s'adapte à votre situation professionnelle et personnelle.",
    cta: 'Créer ma RI',
  },
  '/creer-une-sarl-en-suisse-facile/': {
    lead: 'Créer une Sàrl en Suisse, au meilleur prix, en ligne ou sur place',
    amount: "2'600",
    unit: 'CHF',
    terms: 'Frais de notaire et registre du commerce inclus, hors TVA',
    detail:
      "N'hésitez pas à nous contacter si vous avez pour projet de créer votre Sàrl. Dilytics s'adapte à votre situation professionnelle et personnelle.",
    cta: 'Créer ma Sàrl',
  },
  '/creation-de-societe-anonyme/': {
    lead: 'Création de SA, frais de notaire et de registre inclus',
    amount: "3'000",
    unit: 'CHF',
    terms: 'Frais de notaire et registre du commerce inclus, hors TVA',
    detail:
      "N'hésitez pas à nous contacter si vous avez pour projet de créer votre société anonyme. Dilytics s'adapte à votre situation professionnelle et personnelle.",
    cta: 'Créer ma société anonyme',
  },
  '/comptabilite-geneve-experts-fiduciaire/': {
    lead: 'Service de comptabilité à partir de',
    amount: '100',
    unit: 'CHF',
    per: 'par mois',
    terms: 'Toutes taxes comprises',
    detail:
      "N'hésitez pas à demander un devis si vous êtes intéressé par un service de comptabilité. Dilytics s'adapte à votre domaine d'activité et à vos exigences.",
    cta: 'Me faire accompagner',
  },
  '/domiciliation-a-geneve/': {
    lead: 'Domiciliation à Genève à partir de',
    amount: '100',
    unit: 'CHF',
    per: 'par mois',
    terms: 'Courrier scanné sans frais supplémentaires',
    detail:
      "N'hésitez pas à demander un devis si vous avez pour projet de domicilier votre entreprise à Genève. Dilytics s'adapte à votre situation et à vos activités.",
    cta: 'Domicilier ma société',
  },
  '/payroll-et-administration-rh/': {
    lead: "Payroll et administration RH d'un employé à partir de",
    amount: '35',
    unit: 'CHF',
    per: 'par employé et par mois',
    detail:
      "N'hésitez pas à demander un devis si vous êtes intéressé par un service de payroll et d'administration RH. Nos spécialistes s'adaptent à la taille et aux activités de votre équipe.",
    cta: 'Obtenir un devis',
  },
  '/mandat-de-gerant-et-administrateur-en-suisse/': {
    lead: "Mandat de gérant ou d'administrateur à partir de",
    amount: '400',
    unit: 'CHF',
    per: 'par mois',
    terms: 'Selon les exigences de votre société',
    detail:
      "N'hésitez pas à demander un devis si vous souhaitez mandater un gérant ou un administrateur en Suisse. Dilytics s'adapte aux exigences de votre société.",
    cta: 'Obtenir un devis',
  },
}
