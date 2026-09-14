// Every photograph on the site that is still a stock picture, and what should
// replace it.
//
// Dilytics asked for real pictures of its team, its offices and its working
// environment. Until they arrive, each stock picture carries a visible red note
// saying what to shoot, and the full list is laid out on /photos-a-fournir for
// the photographer. Set NOTES to false once the real pictures are in: every
// note disappears at once.
//
// prio 1: key pages, seen by every visitor. 2: service pages. 3: articles.

export const NOTES = true

export const PHOTOS = {
  /* ------------------------------------------------------------ key pages */
  meet: {
    prio: 1,
    brief: "L'équipe au complet dans les locaux, en discussion. Format très large, personnes dans la moitié droite : le titre se pose à gauche.",
    where: ['Accueil, image de fond du haut de page', "Pages Entreprises, Création d'entreprise et Particuliers, bloc rendez-vous"],
  },
  cta: {
    prio: 1,
    brief: "La salle de réunion ou l'accueil du cabinet, prêts à recevoir un client.",
    where: ['Bloc de contact en bas de chaque page'],
  },
  desk: {
    prio: 1,
    brief: 'Un collaborateur au travail sur bexio, écran lisible, cadré de près.',
    where: ['Accueil, « Ce qui nous distingue »', 'Article « Bexio et Dilytics »'],
  },
  geneve: {
    prio: 1,
    brief: "L'entrée du bâtiment Lancy Small City, ou la vue depuis le 6e étage, pour que le visiteur reconnaisse le lieu.",
    where: ['Contact, haut de page', 'Article « Paradis fiscaux »'],
  },
  duo: {
    prio: 1,
    brief: 'Deux ou trois collaborateurs qui travaillent ensemble sur un dossier, ambiance naturelle.',
    where: ['Carrière, haut de page', 'Menu Carrière'],
  },
  entr: {
    prio: 1,
    brief: 'Un associé en rendez-vous avec un dirigeant de PME, au cabinet.',
    where: ['Page Entreprises, haut de page', 'Menu Entreprises', 'Prestations entreprises, image au fil du texte', 'Cartes « Vous cherchiez autre chose ? »'],
  },
  crea: {
    prio: 1,
    brief: 'La remise des statuts ou la signature avec un entrepreneur qui crée sa société.',
    where: ["Page Création d'entreprise, haut de page", "Menu Création d'entreprise", 'Prestations création, image au fil du texte', 'Cartes « Vous cherchiez autre chose ? »'],
  },
  part: {
    prio: 1,
    brief: "Un conseiller avec un particulier ou un couple, autour d'un dossier.",
    where: ['Page Particuliers, haut de page', 'Menu Particuliers', 'Prestations particuliers, image au fil du texte', 'Cartes « Vous cherchiez autre chose ? »'],
  },

  /* -------------------------------------------------------------- services */
  compta: { prio: 2, brief: "Un comptable de l'équipe sur un dossier client, écran et pièces visibles.", where: ['Page Comptabilité'] },
  payroll: { prio: 2, brief: "La préparation des salaires, cadrée sur l'écran et les mains.", where: ['Page Payroll et administration RH'] },
  tva: { prio: 2, brief: 'Un fiscaliste au travail sur un décompte TVA, au bureau.', where: ['Page TVA'] },
  audit: { prio: 2, brief: "Deux collaborateurs en revue d'un dossier de comptes.", where: ['Page Audit des comptes', 'Article « Déterminez la rentabilité de votre entreprise »'] },
  revision: { prio: 2, brief: 'Gros plan sur des états financiers annotés, au bureau.', where: ['Page Contrôle restreint', 'Article « Fiscalité numérique »'] },
  mandat: { prio: 2, brief: "Un associé en visioconférence avec un client établi à l'étranger.", where: ["Page Mandat de gérant et d'administrateur"] },
  domicil: { prio: 2, brief: "L'accueil du 6e étage ou la boîte aux lettres, là où arrive le courrier des sociétés domiciliées.", where: ['Page Domiciliation à Genève', 'Article « Comment bien choisir sa fiduciaire ? »'] },
  ppe: { prio: 2, brief: 'Un rendez-vous avec des copropriétaires ou leur administrateur, au cabinet.', where: ['Page Gestion de PPE'] },
  sarl: { prio: 2, brief: 'Des associés fondateurs en rendez-vous de création.', where: ['Page Création de Sàrl'] },
  sa: { prio: 2, brief: "La signature des statuts d'une société anonyme.", where: ['Page Création de société anonyme'] },
  ri: { prio: 2, brief: 'Un indépendant en rendez-vous avec un conseiller.', where: ['Page Création de raison individuelle'] },
  conseilfisc: { prio: 2, brief: 'Un conseiller fiscal en entretien avec un client.', where: ['Page Conseil fiscal'] },
  immo: { prio: 2, brief: 'Un dossier immobilier étudié au cabinet, plans ou documents visibles.', where: ['Page Fiscalité immobilière'] },
  succession: { prio: 2, brief: 'Un entretien calme avec une famille, dossier sur la table.', where: ['Page Déclaration de succession'] },
  pilier3: { prio: 2, brief: 'Un conseiller qui présente un plan de prévoyance à un client.', where: ['Page Prévoyance et 3e pilier'] },
  admin: { prio: 2, brief: 'Le traitement de documents administratifs au bureau.', where: ['Page Gestion administrative'] },
  source: { prio: 2, brief: 'Un rendez-vous avec un frontalier ou un titulaire de permis B.', where: ['Page Impôt à la source'] },
  impots: { prio: 2, brief: 'Un conseiller avec un particulier, déclaration en cours.', where: ["Page Déclaration d'impôts"] },

  /* -------------------------------------------------------------- articles */
  crop_screen: { prio: 3, brief: "Reprendre l'image de l'article publié sur dilytics.ch.", where: ['Article « Réforme TVA 2025 en Suisse »'] },
  crop_hands: { prio: 3, brief: "Reprendre l'image de l'article publié sur dilytics.ch.", where: ['Article « Créer sa start-up en Suisse »'] },
}

// Places that will show a real photograph which does not exist yet.
export const EXPECTED = [
  { id: 'locaux-equipe', brief: "L'équipe au complet, photo de groupe dans les locaux.", where: ['À propos, « Nos locaux »'] },
  { id: 'locaux-reunion', brief: 'Un rendez-vous client en salle de réunion.', where: ['À propos, « Nos locaux »'] },
  { id: 'locaux-bureaux', brief: 'Les bureaux, avec les collaborateurs au travail.', where: ['À propos, « Nos locaux »'] },
]
