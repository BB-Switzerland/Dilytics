<?php
/**
 * /photos-a-fournir/ — pages/photos-a-fournir.vue. Not linked, not indexed.
 * The list itself comes from the photo registry (option dl_photos).
 */

defined( 'ABSPATH' ) || exit;

$id = dlb_page( 'photos-a-fournir' );
dlb_start( $id );

dlb_add(
	'dl-photos',
	array(
		'title'     => 'Photos à fournir',
		'intro'     => "{total} emplacements attendent une photo réelle de l'équipe, des locaux ou de l'environnement de travail, comme Dilytics l'a demandé. Sur le site, chacun porte une note rouge qui rappelle ce qu'il faut montrer. Les autres images (gros plans, vues de Genève, illustrations d'articles) ne sont pas concernées. Cette page n'est pas référencée.",
		'new_t'     => 'Nouveaux emplacements',
		'new_d'     => "Aucune image aujourd'hui : la photo est à créer.",
		'new_label' => 'Photo attendue',
		'groups'    => array(
			array(
				'prio' => '1',
				't'    => 'Pages clés',
				'd'    => 'Vues par tous les visiteurs. À traiter en premier.',
			),
			array(
				'prio' => '2',
				't'    => 'Pages prestations',
				'd'    => "Chaque image apparaît en haut de sa page et dans les cartes « Avez-vous besoin d'un autre service ? ». Une même séance photo peut couvrir les cinq.",
			),
		),
		'file'      => 'Fichier actuel : {file}',
	)
);

dlb_finish( $id );
