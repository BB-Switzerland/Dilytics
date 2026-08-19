// Page content for each service. Three named benefits first — the cabinet's own
// recurring device — then explanatory sections with real titles. No numbering:
// these are not sequences, and a reader should know what a block is about from
// its heading alone.
//
// Everything below is drawn from the cabinet's published pages. Where the site
// prints its own trio of benefits, that trio is used verbatim; elsewhere the
// three are summarised from sentences on the same page. No commitment, delay or
// figure appears here that the site does not already make.

export const BODY = {
  /* ----------------------------------------------------------- création */
  '/creation-de-raison-individuelle/': {
    tagline: "Obtenez rapidement le statut d'indépendant en Suisse.",
    intro:
      "Une raison individuelle est une entreprise individuelle exploitée par une seule personne, qui obtient le statut d'indépendant à l'égard des entités publiques et privées. Elle est soumise à des exigences légales et fiscales, mais peut être une option attrayante pour qui souhaite travailler de manière indépendante et être son propre patron à moindre coût.",
    benefits: [
      { ico: 'coin', t: 'Une forme simple', d: "La création d'une raison individuelle est une procédure relativement simple et peu coûteuse." },
      { ico: 'shield', t: 'Des obligations personnelles', d: "Votre responsabilité est illimitée : c'est le point à peser avant toute autre considération." },
      { ico: 'talk', t: 'Un conseil avant de choisir', d: "Dilytics est là pour vous aider à faire votre choix. Prenez rendez-vous gratuitement." },
    ],
    sections: [
      {
        t: "Le nom et le lieu d'établissement",
        p: [
          "Il est d'abord nécessaire de choisir un nom pour votre entreprise. Il doit être unique, ne pas être déjà utilisé par une autre entreprise enregistrée en Suisse, et il doit absolument contenir votre nom de famille — par exemple « Consulting NOM ».",
          "Une fois le nom et le lieu d'établissement arrêtés, vous pouvez vous inscrire au registre du commerce cantonal.",
        ],
      },
      {
        t: 'Inscription au registre du commerce',
        p: [
          "Cette inscription est obligatoire pour toutes les entreprises individuelles dépassant un certain chiffre d'affaires.",
          "Dilytics peut s'occuper de votre inscription, en ligne ou en personne, auprès du registre du commerce du canton de votre choix.",
        ],
      },
      {
        t: "Déclaration d'activité et statut d'indépendant",
        p: [
          "En tant que propriétaire d'une raison individuelle, vous devez remplir une déclaration d'activité auprès de l'administration fiscale cantonale.",
          "Cette déclaration précise le type d'activité que vous souhaitez exercer, le lieu d'établissement de votre entreprise, ainsi que d'autres informations importantes.",
        ],
      },
      {
        t: 'Vos obligations fiscales',
        p: [
          "Les raisons individuelles sont soumises à des obligations fiscales en Suisse. Vous devez vous enregistrer auprès de l'administration fiscale cantonale pour obtenir un numéro d'identification fiscale.",
          "Vous serez ensuite responsable de payer des impôts sur le revenu que vous percevrez sur les bénéfices de votre entreprise, ainsi que de la TVA si vous dépassez un certain seuil de chiffre d'affaires.",
        ],
      },
      {
        t: 'La comptabilité à tenir',
        p: [
          "Vous devez tenir des registres comptables précis, d'autant plus si votre chiffre d'affaires annuel dépasse les 500 000 francs. Cela inclut la tenue d'un journal de caisse, la facturation de vos clients, la gestion de vos comptes bancaires et la tenue de registres de vos dépenses.",
          "Vous pouvez tenir ces registres vous-même ou faire appel à Dilytics pour vous aider.",
        ],
      },
      {
        t: 'Les assurances sociales',
        p: [
          "Les propriétaires de raisons individuelles doivent s'inscrire auprès de l'assurance sociale suisse. Cette inscription est obligatoire pour tous les travailleurs indépendants en Suisse.",
          "Elle vous donne accès à des prestations telles que l'assurance maladie et l'assurance accident, et permet de gérer vos cotisations de retraite.",
        ],
      },
      {
        t: 'La responsabilité personnelle',
        p: [
          "Vous êtes responsable de toutes les dettes et obligations de votre entreprise. Votre responsabilité est illimitée et vous pouvez être tenu personnellement responsable des dettes de votre entreprise en cas de faillite ou de difficultés financières.",
        ],
      },
      {
        t: 'Les différences avec la Sàrl et la SA',
        p: [
          "Une personne morale telle qu'une SA ou une Sàrl est une entité juridique distincte de ses propriétaires. Ceux-ci ne sont pas personnellement responsables des dettes et des obligations de l'entreprise au-delà de leur investissement initial.",
          "La raison individuelle est simple à créer et à gérer, mais elle offre peu de protection juridique au propriétaire. Il est important de bien comprendre ces différences avant de décider laquelle convient le mieux à votre situation.",
        ],
      },
    ],
  },

  '/creer-une-sarl-en-suisse-facile/': {
    tagline: 'Créer une Sàrl en Suisse avec des bases solides.',
    intro:
      "La société à responsabilité limitée vous permet de développer vos activités, d'embaucher du personnel et d'obtenir des financements. En Suisse, la Sàrl est la structure par excellence : elle reste meilleur marché que la société anonyme et offre plusieurs avantages par rapport à la raison individuelle.",
    benefits: [
      { ico: 'shield', t: 'Responsabilité limitée', d: "Les associés répondent des dettes à hauteur de leurs apports, pas au-delà." },
      { ico: 'tag', t: 'Tarif toutes charges comprises', d: "Aucune prestation supplémentaire n'est facturée en cours de procédure." },
      { ico: 'users', t: 'Nos propres conseillers', d: "Nous n'avons pas d'intermédiaires et fonctionnons avec nos propres conseillers." },
    ],
    sections: [
      {
        t: 'Responsabilité limitée des associés',
        p: [
          "Contrairement à la raison individuelle, les associés d'une Sàrl ont une responsabilité limitée aux montants de leurs apports respectifs. En cas de faillite, ils ne sont pas personnellement responsables des dettes de la société.",
          "En cas de situation financière difficile, l'entrepreneur a la flexibilité de rebondir sans que son porte-monnaie personnel soit impacté directement.",
        ],
      },
      {
        t: 'Crédibilité envers les parties prenantes',
        p: [
          "Créer une Sàrl peut donner une image de professionnalisme et de crédibilité aux yeux des partenaires commerciaux, des clients et des fournisseurs.",
          "La constitution d'un capital ainsi que l'exploitation d'une société avec un nom personnalisé sont attirantes et gage de confiance.",
        ],
      },
      {
        t: "Facilité de transmission de l'entreprise",
        p: [
          "En cas de vente, il est plus facile de transmettre une Sàrl qu'une entreprise individuelle, car les parts sociales peuvent être cédées à un tiers.",
          "La transmission d'une entreprise individuelle nécessite la conclusion d'un contrat de vente de l'ensemble des actifs et passifs, et peut demander des frais très élevés pour évaluer la situation avant et après la vente.",
        ],
      },
      {
        t: 'Un nom commercial protégé',
        p: [
          "Créer une Sàrl permet d'enregistrer le nom commercial de l'entreprise auprès de l'Institut fédéral de la propriété intellectuelle, ce qui offre une protection contre l'utilisation non autorisée du nom, du logo ou d'un autre support.",
          "Pensez à garder une exclusivité totale sur votre image de marque, en Suisse, en Europe ou dans le monde. Nos experts vous renseignent sur cette possibilité.",
        ],
      },
      {
        t: 'Une meilleure organisation opérationnelle',
        p: [
          "La Sàrl est gérée par un ou plusieurs associés, qui peuvent être des personnes physiques ou morales. Cette structure facilite la gestion et l'organisation de l'entreprise, et permet de mieux séparer les décisions commerciales des décisions personnelles.",
          "Elle permet également de diversifier vos profils clés au sein de l'entreprise et de viser de plus grands marchés.",
        ],
      },
      {
        t: 'Ce que coûte réellement la constitution',
        p: [
          "La création d'une Sàrl implique des coûts plus élevés que celle d'une entreprise individuelle, notamment en termes de capital social minimum et de frais de constitution. Les avantages ci-dessus peuvent justifier ces coûts, selon les objectifs de chaque entrepreneur.",
          "Dilytics vous propose un tarif toutes charges comprises et peut s'occuper de toute la procédure de création, sans vous facturer aucune prestation supplémentaire.",
        ],
      },
    ],
  },

  '/creation-de-societe-anonyme/': {
    tagline: 'Démarrez une entreprise ambitieuse.',
    intro:
      "La société anonyme vous permet d'obtenir des financements et de développer une entreprise avec des objectifs de croissance ambitieux. Bien que la SA et la Sàrl présentent des similitudes, la première offre certains avantages.",
    benefits: [
      { ico: 'chart', t: 'Capacité de financement', d: "La SA peut émettre des actions et des obligations pour lever des fonds." },
      { ico: 'doc', t: 'Transfert simplifié', d: "Les actions se transfèrent sans publication officielle au registre du commerce." },
      { ico: 'shield', t: 'Crédibilité renforcée', d: "La SA est souvent perçue comme plus établie et plus transparente." },
    ],
    sections: [
      {
        t: 'Une plus grande capacité de financement',
        p: [
          "La SA lève des fonds plus facilement que la Sàrl. Elle peut émettre des actions et des obligations, ce qui est particulièrement utile pour financer des projets à grande échelle ou procéder à des acquisitions.",
          "La Sàrl, elle, n'a pas la capacité d'émettre des actions et ne peut lever des fonds que par emprunt ou par contributions en capital de ses associés.",
        ],
      },
      {
        t: 'Un transfert de propriété facilité',
        p: [
          "Les actions peuvent être vendues ou transférées sans qu'il soit nécessaire d'obtenir l'accord des autres actionnaires, et sans publication officielle au registre du commerce.",
          "Dans une Sàrl, le transfert de propriété est plus compliqué : il faut souvent l'accord des autres associés et le recours à un notaire.",
        ],
      },
      {
        t: 'La crédibilité auprès des partenaires',
        p: [
          "La SA est souvent associée à des entreprises plus grandes et plus établies, ce qui peut inspirer confiance à ses partenaires commerciaux.",
          "Elle est également considérée comme plus transparente, car elle publie des informations financières régulières, surtout si elle procède au contrôle restreint ou ordinaire des comptes.",
        ],
      },
      {
        t: 'La rémunération des administrateurs',
        p: [
          "Les administrateurs de la SA peuvent être rémunérés pour leur travail, ce qui peut attirer des personnes hautement qualifiées aux postes de direction.",
          "Les gérants de la Sàrl, en revanche, ne peuvent pas être rémunérés, sauf s'ils sont également associés.",
        ],
      },
      {
        t: 'Faut-il commencer par une SA ?',
        p: [
          "La forme juridique la plus appropriée dépend des besoins spécifiques de l'entreprise et de ses propriétaires, ainsi que de ses objectifs à long terme.",
          "La SA demandant un plus grand investissement initial, il peut être pertinent de démarrer avec une Sàrl en cas de budget restreint.",
        ],
      },
    ],
  },

  /* -------------------------------------------------------- entreprises */
  '/comptabilite-geneve-experts-fiduciaire/': {
    tagline: 'Solutions comptables digitales, experts humains.',
    intro:
      "Notre équipe prend en charge la comptabilité de votre entreprise ou de votre activité d'indépendant, et nos conseillers s'adaptent à vos besoins. La comptabilité est notre cœur de métier depuis 1999.",
    benefits: [
      { ico: 'tag', t: 'Prix transparents', d: 'Bénéficiez de prix compétitifs. Nous respectons le montant des devis que nous vous envoyons.' },
      { ico: 'screen', t: 'Fiduciaire digitale', d: "Vous aurez l'opportunité de suivre en temps réel les écritures comptables de votre entreprise." },
      { ico: 'talk', t: 'Conseil sur mesure', d: 'Vous avez la possibilité de déléguer complètement ou partiellement vos tâches comptables.' },
    ],
    sections: [
      {
        t: "Pourquoi une bonne tenue comptable compte",
        p: [
          "Une bonne tenue comptable est essentielle pour la santé financière de votre entreprise. Elle vous permet de mieux comprendre vos revenus, vos dépenses et votre situation financière globale.",
          "Une tenue précise facilite la gestion de votre entreprise et vous permet de prendre des décisions éclairées. Elle vous aide aussi à respecter les exigences fiscales et légales, et en cas d'audit, à éviter des pénalités et des sanctions.",
        ],
      },
      {
        t: "L'analytique comme force de vente",
        p: [
          "La comptabilité analytique consiste à suivre et à analyser les coûts et les dépenses d'une entreprise de manière détaillée. Cela permet de mieux comprendre comment l'entreprise utilise ses ressources et de prendre des décisions éclairées en matière de planification et de budgétisation.",
          "Elle aide à identifier les domaines où des économies peuvent être réalisées, et à mieux comprendre la rentabilité des différents produits ou services proposés — ce qui éclaire ensuite les décisions de tarification et de marketing.",
        ],
      },
      {
        t: 'Ce que dit le Code des obligations',
        p: [
          "Les états financiers se dressent obligatoirement en suivant les dispositions du Code des obligations suisse. La démarche consiste à catégoriser les charges et les produits afin d'obtenir une comptabilité claire, composée au minimum d'un bilan et d'un compte de résultat.",
          "Dit simplement, la comptabilité vous permet de visualiser votre patrimoine avec précision. Nos comptables la tiennent selon les normes en vigueur, que votre société soit petite, moyenne ou grande, cotée en bourse ou non.",
        ],
      },
    ],
    offer: {
      t: 'Nous analysons votre comptabilité gratuitement',
      d: "Profitez d'une analyse de vos comptes, gratuite et sans engagement. Vous pourrez identifier vos charges les plus coûteuses et vérifier si vous êtes en règle avec les normes comptables en vigueur.",
      cta: "Profiter de l'offre",
    },
  },

  '/domiciliation-a-geneve/': {
    tagline: "L'alternative au paiement d'un loyer.",
    intro:
      "Grâce à une adresse fiscale de confiance dans le canton de Genève, vous pourrez rapidement démarrer vos activités en Suisse. L'adresse privilégiée de notre fiduciaire est à votre disposition sur la commune de Lancy.",
    benefits: [
      { ico: 'coin', t: 'Économies', d: "Évitez de payer un loyer de plusieurs milliers de francs par mois." },
      { ico: 'doc', t: 'Simplicité', d: 'Recevez vos courriers par courriel ou venez les chercher à notre bureau, sans frais supplémentaires.' },
      { ico: 'shield', t: 'Crédibilité', d: 'Une adresse professionnelle physique qui vous valorise auprès de vos potentiels partenaires.' },
    ],
    sections: [
      {
        t: 'Pourquoi Lancy',
        p: [
          "Lancy est située à proximité immédiate de Genève, offrant un accès facile aux principaux centres économiques de la région. La commune est bien desservie par les transports en commun, ce qui facilite les déplacements professionnels.",
          "Elle propose une fiscalité avantageuse pour les entreprises, avec des taux d'imposition compétitifs, et connaît une forte dynamique économique portée par de nombreuses entreprises et start-ups implantées sur place.",
        ],
      },
      {
        t: "Une obligation avant d'être un confort",
        p: [
          "Pour s'inscrire au registre du commerce, une domiciliation est obligatoire : votre société doit avoir une adresse professionnelle en Suisse.",
          "Vous n'avez pas de local fixe en Suisse pour vos activités commerciales ? Dans l'attente de trouver le bureau de vos rêves, démarrez vos activités chez nous.",
        ],
      },
      {
        t: 'Une équipe comptable sur place',
        p: [
          "En optant pour ce service, vous évitez les coûts liés à l'installation et à l'entretien d'un bureau physique, ainsi que ceux liés au recrutement d'une équipe pour gérer l'administratif et la correspondance de votre siège social.",
          "Notre équipe est composée de professionnels expérimentés ayant une connaissance approfondie de la fiscalité suisse et internationale. Concentrez-vous sur votre cœur de métier et laissez-nous scanner votre courrier gratuitement.",
        ],
      },
    ],
    list: {
      t: 'Pourquoi une domiciliation chez Dilytics',
      items: [
        "Économie sur les coûts liés à la location d'un local commercial",
        'Facilité d’accès avec les transports publics',
        'Gain de temps dans la gestion du courrier',
        "Mise à disposition d'une adresse professionnelle physique qui vous valorise auprès de vos partenaires",
        'Domiciliation obligatoire pour s’inscrire au registre du commerce',
      ],
    },
  },

  '/payroll-et-administration-rh/': {
    tagline: 'Optimisez votre temps dans la gestion des salaires de votre équipe.',
    intro:
      "Gérer des salaires peut vous faire perdre du temps et de l'argent. Nos prestations incluent, entre autres, le décompte annuel des salaires, les démarches d'affiliation aux caisses de compensation et l'élaboration des fiches de paie.",
    benefits: [
      { ico: 'shield', t: 'Salaires en règle', d: "Vous n'aurez plus à vous soucier de la conformité des salaires de vos employés." },
      { ico: 'clock', t: 'Gain de temps', d: 'Concentrez-vous sur les activités amenant de la croissance à votre société.' },
      { ico: 'users', t: 'Liberté', d: 'Gardez la main sur votre politique salariale, vos recrutements et vos licenciements.' },
    ],
    sections: [
      {
        t: 'Un domaine qui demande de la rigueur',
        p: [
          "Il est indispensable d'avoir de la rigueur et des connaissances solides en comptabilité et en droit du travail pour gérer les salaires d'une entreprise.",
          "Toute erreur dans la déclaration annuelle des salaires peut jouer en votre défaveur et mettre en péril la santé financière de votre société.",
        ],
      },
      {
        t: 'Un service que vous délimitez',
        p: [
          "En souscrivant à un service chez Dilytics, vous choisissez les tâches que vous souhaitez déléguer à nos spécialistes.",
          "Nos spécialistes s'adaptent aux exigences de vos caisses, au droit du travail et aux conventions collectives de votre secteur.",
        ],
      },
    ],
    list: {
      t: 'Les prestations comprises',
      items: [
        'La déclaration annuelle des salaires',
        'La rédaction des contrats de travail pour votre personnel',
        "L'élaboration des fiches de paie",
        "L'inscription aux assurances sociales",
        'La déclaration des accidents et des maladies',
        "Les démarches obligatoires dans le cas d'une embauche ou d'un licenciement",
      ],
    },
  },

  '/tva-suisse/': {
    tagline: 'Une gestion fiscale saine.',
    intro:
      "Faites confiance à nos experts pour établir vos décomptes TVA ou vous inscrire auprès des autorités de taxation. L'assujettissement à la taxe sur la valeur ajoutée et son décompte ne sont pas des actions simples à effectuer.",
    benefits: [
      { ico: 'chart', t: 'Trois taux à distinguer', d: "8,1 % en taux normal, 2,6 % en taux réduit, 3,8 % pour l'hôtellerie." },
      { ico: 'clock', t: 'Trente jours pour s’annoncer', d: "Une fois le seuil atteint, l'immatriculation auprès de l'AFC doit suivre." },
      { ico: 'shield', t: 'Un risque financier réel', d: "Un non-assujettissement peut mener à un paiement d'office avec intérêts moratoires, ou à des amendes." },
    ],
    sections: [
      {
        t: 'Les taux en vigueur',
        p: [
          "En Suisse, le taux varie en fonction du secteur d'activité : 8,1 % est le taux normal pour la majorité des biens et des services, 2,6 % le taux réduit pour les biens de première nécessité tels que les aliments et les médicaments, et 3,8 % le taux spécial applicable au secteur de l'hôtellerie.",
          "Certaines activités comme la formation et la santé sont exonérées de TVA.",
        ],
      },
      {
        t: 'Suis-je assujetti ?',
        p: [
          "Toute société qui dépasse un chiffre d'affaires annuel de 100 000 francs est assujettie à la TVA. Cette règle s'applique également aux entreprises individuelles. Les associations à but non lucratif doivent l'appliquer si leur chiffre d'affaires dépasse 150 000 francs.",
          "Les personnes morales et physiques assujetties doivent s'annoncer auprès de l'Administration fédérale des contributions.",
        ],
      },
      {
        t: 'Quand dois-je m’assujettir ?',
        p: [
          "Il est obligatoire d'annoncer votre assujettissement à partir du moment où vos projections indiquent que vous allez atteindre 100 000 francs de chiffre d'affaires au cours de l'année fiscale en cours. Une fois ce chiffre atteint, vous avez 30 jours pour obtenir votre numéro d'immatriculation.",
          "Si vous venez de commencer votre activité et n'avez pas encore atteint ce seuil, un assujettissement volontaire peut être une bonne stratégie fiscale : cette démarche proactive vous permet de récupérer la taxe sur les produits et services achetés lors du lancement de vos activités.",
        ],
      },
    ],
    list: {
      t: 'Ce que notre équipe peut prendre en charge',
      items: [
        "Analyse de votre situation vis-à-vis de l'assujettissement à la taxe sur la valeur ajoutée",
        'Annonce et inscription auprès des autorités de taxation',
        'Établissement des décomptes',
        "Conseil en matière d'impôt sur les sociétés",
      ],
    },
  },

  '/mandat-de-gerant-et-administrateur-en-suisse/': {
    tagline: 'Menez vos activités en Suisse.',
    intro:
      "Une personne de notre direction peut être nommée gérant ou administrateur de votre société en Suisse. Son rôle est de représenter la société auprès des autorités du pays.",
    benefits: [
      { ico: 'pin', t: 'Une exigence légale', d: "Au moins un gérant ou administrateur vivant en Suisse doit figurer au registre du commerce." },
      { ico: 'users', t: 'Sàrl comme SA', d: "L'administrateur est à la SA ce que le gérant est à la Sàrl." },
      { ico: 'talk', t: 'Un avis avant de décider', d: "Utile aussi aux dirigeants qui veulent l'avis d'un expert avant une décision." },
    ],
    sections: [
      {
        t: "Qu'est-ce qu'un mandat de gérant",
        p: [
          "Un gérant est un individu siégeant dans le conseil d'administration d'une société dont le siège social est en Suisse. Son rôle est de représenter la société auprès des autorités du pays.",
          "Mandater un administrateur qui réside en Suisse est essentiel pour toute Sàrl établie sur le territoire. Les gérants font partie de ce que l'on peut appeler la « haute surveillance » de l'entreprise : le conseil d'administration décide notamment des choix financiers de la société.",
        ],
      },
      {
        t: "Le mandat d'administrateur pour une SA",
        p: [
          "Les principes du mandat de gérant pour une Sàrl s'appliquent également à la société anonyme.",
          "Au moins un administrateur ou un directeur vivant en Suisse doit être mentionné au registre du commerce.",
        ],
      },
    ],
    list: {
      t: 'Ce que notre expérience couvre',
      items: [
        'Les problématiques fiscales : TVA, taxes professionnelles, impôts',
        'La communication avec les instituts bancaires et les administrations',
        "L'élaboration de budgets et de business plans",
        'La mise en place de logiciels de gestion et de comptabilité analytique',
        "Le conseil financier ou la direction financière de l'entreprise",
      ],
    },
  },

  '/audit-des-comptes/': {
    tagline: 'Un service d’audit proche des PME.',
    intro:
      "L'audit annuel des comptes consiste à vérifier la conformité des comptes d'une entreprise avec les normes comptables en vigueur. Un tel exercice permet de vérifier si la comptabilité reflète parfaitement sa situation financière.",
    benefits: [
      { ico: 'doc', t: 'Un organe agréé', d: "L'organe de révision est composé d'auditeurs agréés externes, nommés par l'exécutif de la société." },
      { ico: 'chart', t: 'Deux formes de contrôle', d: 'Le contrôle restreint et le contrôle ordinaire, selon la taille et le chiffre d’affaires.' },
      { ico: 'users', t: 'Un réseau de réviseurs', d: "Notre réseau d'expert-réviseurs agréés couvre différents secteurs d'activité." },
    ],
    sections: [
      {
        t: 'Le contrôle restreint',
        p: [
          "Il s'agit du contrôle le moins restrictif. Il s'applique à toutes les entreprises qui comptent au minimum 10 employés.",
          "Une telle démarche de vérification des comptes peut également être mise en place si un ou plusieurs associés en font la demande.",
        ],
      },
      {
        t: 'Le contrôle ordinaire',
        p: [
          "Votre entreprise doit obligatoirement passer un audit ordinaire si deux des trois critères suivants sont remplis : un effectif de plus de 250 employés, un bilan affichant une valeur d'au moins 20 millions de francs, ou un chiffre d'affaires annuel d'au moins 40 millions.",
          "Les associations, les fondations et les sociétés coopératives peuvent également être assujetties à un audit des comptes sous certaines conditions spécifiques.",
        ],
      },
    ],
    list: {
      t: 'Les prestations dont vous bénéficiez',
      items: [
        'Révision et contrôle des comptes',
        'Vérification des procédures de contrôle interne',
        "Conseils et propositions d'amélioration",
        'Autres prestations sur demande : comptabilité analytique, analyse de rentabilité',
      ],
    },
  },

  '/controle-restreint/': {
    tagline: 'Remplissez vos obligations et renforcez votre crédibilité.',
    intro:
      "Le contrôle restreint est un audit financier limité, effectué par un réviseur agréé en Suisse, pour donner une opinion sur les comptes annuels d'une entreprise. Il ne fait pas partie de la clôture des comptes mais est exigé en cas d'opting-in.",
    benefits: [
      { ico: 'doc', t: 'Un réviseur agréé ASR', d: "L'examen aboutit à une opinion sur la conformité aux principes comptables suisses." },
      { ico: 'shield', t: 'Une portée limitée', d: "Pas de tests exhaustifs ni d'évaluation approfondie des systèmes de l'entreprise." },
      { ico: 'users', t: 'Une crédibilité renforcée', d: 'Une opinion professionnelle renforce la confiance des actionnaires, créanciers et fournisseurs.' },
    ],
    sections: [
      {
        t: "Qu'est-ce que le contrôle restreint",
        p: [
          "Cette mission consiste à effectuer une analyse limitée des comptes annuels d'une entreprise et à fournir une opinion sur la conformité des états financiers aux principes comptables suisses.",
          "Le contrôle restreint diffère d'un audit complet en ce qu'il est plus limité dans sa portée : le réviseur examine les documents comptables et financiers, mais ne conduit ni tests exhaustifs ni évaluation approfondie des systèmes et des processus.",
        ],
      },
      {
        t: 'Pourquoi il compte pour votre entreprise',
        p: [
          "Il fournit une opinion professionnelle sur la conformité des comptes annuels, ce qui aide à identifier les erreurs et les problèmes potentiels dans vos états financiers et à prendre des mesures pour les corriger.",
          "Il améliore votre transparence et votre crédibilité auprès des parties prenantes, et aide à vous conformer aux exigences légales en matière de déclaration financière.",
        ],
      },
      {
        t: 'La différence avec le contrôle ordinaire',
        p: [
          "Le contrôle ordinaire est une mission plus exhaustive, qui implique une évaluation approfondie des systèmes et des processus, des tests substantifs et des procédures de vérification étendues. Son but est de donner une assurance raisonnable que les comptes annuels sont exempts d'anomalies significatives.",
          "Le contrôle restreint, lui, est limité à la vérification des états financiers et à une attestation de garantie à fournir aux parties prenantes. Par ailleurs, en cas de difficulté financière ou d'engagement de plus de 10 employés à plein temps, la révision devient une obligation.",
        ],
      },
    ],
  },

  '/gestion-de-ppe/': {
    tagline: 'Confiez la gestion de votre PPE à des experts.',
    intro:
      "Les propriétés par étage sont de plus en plus courantes en Suisse et nécessitent une gestion et une administration efficaces. Nous offrons une gamme complète de services de gestion immobilière, y compris la gestion financière, la maintenance de la propriété et la résolution des conflits.",
    benefits: [
      { ico: 'clock', t: 'Gain de temps', d: "Notre équipe s'occupe des démarches fiscales et administratives." },
      { ico: 'talk', t: 'Œil externe', d: 'Notre équipe peut recommander des solutions avec un regard impartial.' },
      { ico: 'shield', t: 'Confidentialité', d: 'Notre équipe traite les dossiers des copropriétaires en toute confidentialité.' },
    ],
    sections: [
      {
        t: 'La gestion financière de la PPE',
        p: [
          "La gestion des finances comprend la collecte des frais de copropriété, la gestion des dépenses, la budgétisation et la préparation des états financiers.",
          "Nos experts en gestion immobilière peuvent vous aider à maintenir un budget sain, à réduire les coûts et à garantir que toutes les transactions financières sont effectuées en temps voulu.",
        ],
      },
      {
        t: 'Une fiduciaire immobilière',
        p: [
          "Nous sommes une fiduciaire immobilière expérimentée, spécialisée dans la gestion et l'administration de PPE en Suisse.",
          "Notre service implique la gestion des finances, la maintenance de la propriété et la résolution des conflits, pour assurer une expérience agréable aux propriétaires comme aux locataires.",
        ],
      },
    ],
    offer: {
      t: 'Analyse et devis gratuits',
      d: "Si vous souhaitez nous transmettre la gestion financière de votre PPE, nous procédons à l'analyse et au devis gratuitement avec vous.",
      cta: 'Me faire accompagner',
    },
  },

  /* ------------------------------------------------------- particuliers */
  '/declaration-dimpots/': {
    tagline: 'Notre équipe vous fait gagner du temps et de l’argent.',
    intro:
      "Notre équipe réalise votre déclaration de revenus auprès de l'Administration fiscale cantonale. Quelle que soit votre situation professionnelle et personnelle, notre équipe est là pour vous aider.",
    benefits: [
      { ico: 'users', t: 'Vérification à quatre yeux', d: 'Chaque déclaration est vérifiée par deux comptables-fiscalistes.' },
      { ico: 'coin', t: 'Déductions', d: 'Nous appliquons toutes les déductions fiscales auxquelles vous avez droit.' },
      { ico: 'shield', t: 'Confidentialité', d: 'Notre équipe traite votre dossier en toute confidentialité.' },
    ],
    sections: [
      {
        t: 'La déclaration fiscale en Suisse',
        p: [
          "Si vous habitez en Suisse, vous avez l'obligation de déclarer vos revenus à l'Administration fiscale cantonale, quelle que soit votre situation professionnelle.",
          "L'échéance est habituellement fixée au dernier jour du mois de mars de l'année qui suit la période fiscale. N'oubliez pas que vous pouvez demander une prolongation : si vous avez besoin d'aide, notre équipe peut réaliser cette demande.",
        ],
      },
      {
        t: 'Ce que nous vous demandons',
        p: [
          "La seule chose que vous devrez faire sera de nous envoyer les documents justificatifs, tels que vos certificats de salaire et vos attestations d'assurance maladie.",
          "Dilytics traite votre dossier en toute confidentialité.",
        ],
      },
    ],
    list: {
      t: 'Documents à nous transmettre',
      items: [
        'Documents liés aux revenus et extraits bancaires',
        'Vos frais d’assurance concernant la maladie et les accidents',
        'Vos justificatifs liés à une pension ou à des enfants à charge',
      ],
    },
  },

  '/particuliers-impot-a-la-source/': {
    tagline: 'Récupérez une partie de votre contribution fiscale.',
    intro:
      "Vous êtes frontalier ou titulaire d'un permis B ? Si c'est le cas, vous êtes soumis à l'impôt à la source. Dilytics effectue les démarches pour rectifier le montant que vous avez payé.",
    benefits: [
      { ico: 'users', t: 'Vérification à quatre yeux', d: 'Chaque demande est vérifiée par deux comptables-fiscalistes.' },
      { ico: 'coin', t: 'Déductions maximisées', d: 'Nous appliquons toutes les déductions fiscales auxquelles vous avez droit.' },
      { ico: 'shield', t: 'Confidentialité garantie', d: 'Notre équipe traite votre dossier en toute confidentialité.' },
    ],
    sections: [
      {
        t: 'La rectification, en pratique',
        p: [
          "En tant que résident temporaire ou travailleur frontalier, vous êtes soumis à l'impôt à la source. Le montant prélevé ne prend pas en compte certaines déductions auxquelles vous avez droit.",
          "Pour y remédier, vous pouvez effectuer une demande de rectification. Grâce à cette démarche, il est probable que vous récupériez l'argent que vous avez payé en trop.",
        ],
      },
      {
        t: 'Ce que nous vous demandons',
        p: [
          "Notre équipe est disponible pour réaliser votre demande de rectification d'impôt à la source.",
          "La seule chose que vous devrez faire sera de nous envoyer les documents justificatifs, tels que vos certificats de salaire et vos attestations d'assurance maladie.",
        ],
      },
    ],
  },

  '/conseil-fiscal/': {
    tagline: 'Améliorez votre situation fiscale.',
    intro:
      "Nos comptables-fiscalistes sont disponibles pour étudier votre situation et vous proposer des actions d'optimisation fiscale. Experts depuis 1999, notre cabinet est spécialisé dans l'imposition des personnes physiques et des entreprises.",
    benefits: [
      { ico: 'chart', t: 'Un service personnalisé', d: "Nous évaluons les impacts que certains éléments peuvent avoir sur vos impôts." },
      { ico: 'doc', t: 'Au-delà du simple conseil', d: 'Nos experts vous proposent un montage fiscal et les meilleurs plans d’action.' },
      { ico: 'talk', t: 'Une réponse à l’administration', d: "Nous répondons aux demandes à votre place, afin d'éviter la taxation d'office." },
    ],
    sections: [
      {
        t: 'Des conseils fiscaux personnalisés',
        p: [
          "Notre équipe de fiscalistes vous assure un service haut de gamme, personnalisé et innovant, en évaluant les impacts que peuvent avoir certains éléments sur vos impôts.",
          "Nos experts-fiscaux sont disponibles pour vous proposer un montage fiscal et vous montrer les meilleurs plans d'action pour préserver vos finances.",
        ],
      },
      {
        t: 'Optimiser votre déclaration de revenus',
        p: [
          "Nos fiscalistes se chargent de répondre aux demandes à votre place afin d'éviter la taxation d'office.",
          "Nos experts peuvent également vous montrer les démarches à entreprendre pour mentionner un don ou une succession sur votre déclaration d'impôt.",
        ],
      },
      {
        t: 'Un système à trois niveaux',
        p: [
          "Le système fiscal en Suisse se subdivise en trois niveaux : fédéral, cantonal et communal. Les impôts cantonaux et communaux peuvent grandement varier.",
          "Comprendre les dispositions fiscales en vigueur, quelle que soit votre situation, requiert de solides compétences fiscales.",
        ],
      },
    ],
  },

  '/declaration-de-succession/': {
    tagline: 'Un service qui comprend tous les aspects de la gestion d’une succession.',
    intro:
      "La gestion de la succession est une problématique qui se pose après le décès d'un proche. Il s'agit d'une obligation qui doit s'effectuer dans un contexte délicat pour la famille.",
    benefits: [
      { ico: 'talk', t: 'Une équipe à votre écoute', d: "Un questionnement sur un héritage, la taxation d'un legs ou une déclaration : nous sommes disponibles." },
      { ico: 'doc', t: 'La déclaration déposée', d: "Nous établissons la déclaration auprès de l'Administration fiscale cantonale." },
      { ico: 'shield', t: 'Un mandataire possible', d: 'Sous forme de procuration, nous vous libérons des obligations administratives et financières.' },
    ],
    sections: [
      {
        t: "En l'absence de testament",
        p: [
          "Lorsqu'aucun acte juridique comme un testament ou un pacte successoral n'a été conclu, le droit suisse des successions s'applique : le conjoint survivant a droit à 50 % de la succession en concurrence avec les descendants directs.",
          "Le conjoint a droit à 75 % de la succession si le défunt n'a pas de descendants directs, à condition qu'au moins un de ses parents ou un de ses frères et sœurs soit encore en vie. Dans les autres situations, le conjoint hérite de 100 % des actifs et des passifs.",
        ],
      },
      {
        t: "Vos droits en tant qu'héritier",
        p: [
          "En tant qu'héritier en Suisse, vous pouvez accepter la succession avec ou sans bénéfice d'inventaire, la faire liquider officiellement en mandatant une fiduciaire, ou en demander la répudiation.",
          "Dilytics propose également d'être mandataire pour vous libérer de toutes les obligations administratives et financières sous forme d'une procuration. Nous vous faisons alors un compte rendu de la situation et défendons vos intérêts en cas de complications ou de flou administratif.",
        ],
      },
    ],
    list: {
      t: 'Les documents essentiels à réunir',
      items: [
        'Le certificat de décès',
        'Le certificat d’héritier',
        'L’inventaire des biens à transmettre',
        'Le code pour la déclaration fiscale feue',
      ],
    },
  },

  '/prevoyance-3eme-pilier-geneve/': {
    tagline: 'Améliorez votre retraite et faites baisser votre pression fiscale.',
    intro:
      "En Suisse, l'octroi de la rente de retraite se base sur la cotisation des trois piliers. Le 3e pilier, prévoyance individuelle facultative, a pour but de maintenir le niveau de vie des anciens actifs devenus retraités.",
    benefits: [
      { ico: 'coin', t: 'Une déduction fiscale', d: "Avec un pilier 3a, vous pouvez déduire jusqu'à 6 883 francs par an de vos impôts." },
      { ico: 'chart', t: 'Un niveau de vie maintenu', d: 'Environ 40 % de votre salaire actuel ne sera pas assuré par vos 1er et 2e piliers.' },
      { ico: 'pin', t: 'Un achat immobilier facilité', d: "L'argent cotisé facilite le paiement de l'apport minimum de 25 % du prix du bien." },
    ],
    sections: [
      {
        t: 'Le pilier 3a et le pilier 3b',
        p: [
          "Le pilier 3a permet d'épargner un montant déductible des impôts. Celui-ci peut être retiré au moment du départ à la retraite ou lors de certains événements comme l'achat d'une résidence principale.",
          "Le pilier 3b permet d'épargner un montant qui n'a pas de limite. Contrairement au 3a, ce montant cotisé n'est pas déductible des impôts, mais il peut être retiré à tout moment.",
        ],
      },
      {
        t: 'Faire baisser le montant de vos impôts',
        p: [
          "En optant pour un pilier 3a, vous pouvez déduire de vos impôts jusqu'à 6 883 francs par an.",
          "Ce montant peut même aller jusqu'à 34 416 francs si vous êtes indépendant et non affilié à une caisse de pension.",
        ],
      },
      {
        t: 'Comment choisir le bon plan',
        p: [
          "En Suisse, il existe plusieurs fonds de pension, banques et assurances qui proposent des plans d'épargne 3a et 3b. Les taux de rendement peuvent varier d'une option à l'autre, et il est difficile de s'y retrouver quand on ne connaît pas le marché de la prévoyance.",
          "En faisant appel à une fiduciaire indépendante, vous comparez toutes les options existantes et bénéficiez de conseils fiscaux personnalisés.",
        ],
      },
    ],
    list: {
      t: 'Ce dont vous bénéficiez',
      items: [
        "Trouver le plan d'épargne le mieux adapté à votre situation",
        'Comparer toutes les options qui existent en Suisse',
        'Bénéficier de conseils fiscaux personnalisés',
        'Accéder à des simulations fiscales pour mieux évaluer vos futures décisions',
      ],
    },
  },

  '/gestion-administrative/': {
    tagline: 'Respirez et profitez de la vie.',
    intro:
      "Nos experts vous aident dans toutes vos tâches administratives, sur une base ponctuelle ou régulière. Il peut s'agir de démarches vis-à-vis de vos assurances, de paiements de factures ou de la gestion de vos courriers.",
    benefits: [
      { ico: 'users', t: 'Vérification à quatre yeux', d: 'Chaque document est vérifié par deux experts de notre équipe.' },
      { ico: 'clock', t: 'Réactivité', d: 'Nous répondons à vos demandes en moins de 24 h les jours ouvrables.' },
      { ico: 'shield', t: 'Confidentialité', d: 'Notre équipe traite vos dossiers en toute confidentialité.' },
    ],
    sections: [
      {
        t: 'Ponctuel ou régulier, à votre main',
        p: [
          "Pour obtenir une aide ponctuelle, il suffit de nous soumettre votre demande et nous la réglerons dans les plus brefs délais.",
          "Vous pouvez également obtenir une assistance administrative régulière. Dans ce cas, nous définissons avec vous les tâches que vous souhaitez déléguer à notre équipe. Ce service peut être facturé sous forme d'abonnement mensuel.",
        ],
      },
      {
        t: 'Une approche globale',
        p: [
          "En plus de notre service de gestion administrative, nous proposons du conseil fiscal, de la gestion de successions et de la déclaration d'impôts.",
          "Vous bénéficiez d'une équipe ayant de l'expérience dans la gestion administrative, la comptabilité et le droit des assurances.",
        ],
      },
    ],
    list: {
      t: 'Les démarches que nous prenons en charge',
      items: [
        'Rédaction de courriers',
        'Démarches vis-à-vis des assurances',
        'Demande de remboursement des frais médicaux',
        'Changement et demande de statut de résidence',
        'Contestation et renégociation de poursuites',
        'Établissement de l’état des lieux de votre résidence',
        'Ouverture de comptes bancaires',
        'Gestion des factures et résiliation de contrats',
      ],
    },
  },

  '/fiscalite-immobiliere/': {
    tagline: 'Un accompagnement sur mesure.',
    intro:
      "La fiscalité immobilière en Suisse peut avoir un impact significatif sur vos investissements. Les réglementations pèsent sur les investissements immobiliers, les ventes de biens et les revenus locatifs.",
    benefits: [
      { ico: 'pin', t: 'Fiscalité immobilière', d: 'Une équipe connaissant la fiscalité immobilière en Suisse.' },
      { ico: 'coin', t: 'Optimisation', d: 'Bénéficiez de conseils pour alléger votre charge fiscale immobilière.' },
      { ico: 'shield', t: 'Confidentialité', d: 'Notre équipe traite votre dossier en toute confidentialité.' },
    ],
    sections: [
      {
        t: 'Les impôts fonciers',
        p: [
          "Les impôts fonciers sont un impôt local prélevé sur la propriété immobilière en Suisse. Les taux varient selon les cantons et les communes, et sont basés sur la valeur locative du bien, calculée par les autorités fiscales d'après sa taille et sa situation géographique.",
          "En général, les impôts fonciers sont déductibles des impôts sur le revenu, ce qui peut réduire le fardeau fiscal. Les propriétaires doivent toutefois rester attentifs aux réglementations locales et aux échéances de paiement pour éviter les sanctions.",
        ],
      },
      {
        t: 'Les impôts sur les gains en capital',
        p: [
          "Les gains réalisés sur la vente de biens immobiliers en Suisse y sont soumis. Les taux varient selon la durée de possession et la résidence fiscale du vendeur : les non-résidents sont soumis à une retenue à la source sur le montant de la vente.",
          "Les gains sur les biens détenus depuis plus de cinq ans sont exempts d'impôt en Suisse. Les coûts liés à la vente — frais de courtage, d'avocat, de notaire — peuvent par ailleurs être déduits de la base d'imposition.",
        ],
      },
      {
        t: 'Les revenus locatifs',
        p: [
          "Les propriétaires de biens locatifs sont soumis à l'impôt sur les revenus locatifs. Les taux varient selon les cantons et les communes et sont basés sur le revenu locatif brut.",
          "Les frais de gestion, de maintenance et d'assurance se déduisent du revenu brut pour déterminer le revenu locatif net. En général, les propriétaires ne sont pas soumis à la TVA sur les revenus locatifs, mais peuvent la récupérer sur les coûts de maintenance et d'investissement.",
        ],
      },
    ],
    list: {
      t: "Nos conseils pour minimiser l'impact fiscal",
      items: [
        'Évitez de revendre trop souvent',
        'Calculez la valeur locative',
        'Contactez un fiscaliste',
      ],
    },
  },
}
