// The photographs Dilytics asked to replace with real ones.
//
// Its request was precise: real pictures of the team, the offices and the
// working environment instead of generic ones. So only the stock pictures that
// stand for the cabinet itself are listed here: people a visitor would take for
// the team, meetings with a client, office scenes. Close-ups of documents, views
// of Geneva, clients at home and article illustrations were not asked about and
// stay as they are, without a note.
//
// Each listed picture carries a visible red note on the page, and the full list
// is laid out on /photos-a-fournir for the photographer. Set NOTES to false once
// the real pictures are in: every note disappears at once.
//
// prio 1: pictures on the key pages, seen by every visitor. 2: service pages.

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
    brief: "Un membre de l'équipe à son poste, dans les bureaux.",
    where: ['Bloc de contact en bas de chaque page'],
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

  /* -------------------------------------------------------------- services */
  payroll: { prio: 2, brief: 'Un collaborateur qui prépare les salaires à son poste, écran visible.', where: ['Page Payroll et administration RH'] },
  tva: { prio: 2, brief: "Un fiscaliste de l'équipe au travail sur un décompte, au bureau.", where: ['Page TVA'] },
  mandat: { prio: 2, brief: 'Un associé en rendez-vous avec un client, en salle de réunion.', where: ["Page Mandat de gérant et d'administrateur"] },
  ppe: { prio: 2, brief: 'Deux collaborateurs à leur poste, dans les bureaux.', where: ['Page Gestion de PPE'] },
  conseilfisc: { prio: 2, brief: 'Un conseiller fiscal en entretien avec un client, au cabinet.', where: ['Page Conseil fiscal'] },
}

// Places that will show a real photograph which does not exist yet.
export const EXPECTED = [
  { id: 'locaux-equipe', brief: "L'équipe au complet, photo de groupe dans les locaux.", where: ['À propos, « Nos locaux »'] },
  { id: 'locaux-reunion', brief: 'Un rendez-vous client en salle de réunion.', where: ['À propos, « Nos locaux »'] },
  { id: 'locaux-bureaux', brief: 'Les bureaux, avec les collaborateurs au travail.', where: ['À propos, « Nos locaux »'] },
]
