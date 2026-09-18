<?php
/**
 * pages/a-propos.vue, "Découvrez notre équipe": each member in their own
 * words, then the link to the job offers.
 */

class DL_About_Team_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'À propos : équipe', 'Titre, texte, les membres de l’équipe avec leur citation, et le lien vers les offres d’emploi.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_settings_form(
	'dl_about_team_person',
	array(
		'title' => 'Membre de l’équipe',
		'tabs'  => dl_form(
			array(
				'img'      => dl_f_photo( 'Portrait' ),
				'name'     => dl_f_text( 'Nom' ),
				'role'     => dl_f_text( 'Fonction' ),
				'quote'    => dl_f_area( 'Citation', '', 6 ),
				'diploma'  => dl_f_text( 'Diplômes' ),
				'langs'    => dl_f_text( 'Langues' ),
				'linkedin' => dl_f_link( 'Profil LinkedIn' ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_About_Team_Module',
	dl_form(
		array(
			'title'      => dl_f_text( 'Titre' ),
			'text'       => dl_f_area( 'Texte' ),
			'people'     => array_merge( dl_f_items( 'Membres de l’équipe', 'dl_about_team_person' ), array( 'preview_text' => 'name' ) ),
			'jobs_label' => dl_f_text( 'Lien sous l’équipe : libellé' ),
			'jobs_to'    => dl_f_link( 'Lien sous l’équipe : page' ),
		)
	)
);
