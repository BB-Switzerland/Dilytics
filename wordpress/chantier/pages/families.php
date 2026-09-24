<?php
/**
 * /entreprises/, /creation-dentreprise/, /particuliers/ — components/CategoryPage.vue,
 * one page per family (pages/entreprises.vue, creation-dentreprise.vue, particuliers.vue).
 */

defined( 'ABSPATH' ) || exit;

$fam_c = dlb_content();

foreach ( $fam_c['categories'] as $fam ) {
	$fam_id = dlb_page( trim( $fam['slug'], '/' ) );
	dlb_start( $fam_id );
	dlb_scope( 'v-category-page' );

	dlb_add(
		'dl-cat-open',
		array_merge(
			array(
				'crumb' => $fam['title'],
				'title' => $fam['title'],
				'pitch' => $fam['pitch'],
				'lede'  => $fam['lede'],
				'book'  => 'Réserver un entretien',
				'alt'   => $fam['title'],
				'facts' => $fam['facts'],
			),
			dlb_photo( 'img', $fam['img'] )
		)
	);

	// the rows of ServiceList: the one-line pitch rather than the full lede
	$fam_rows = array();
	foreach ( $fam_c['services'] as $fam_s ) {
		if ( $fam_s['group'] !== $fam['key'] ) {
			continue;
		}
		$fam_rows[] = array(
			't'  => ( $fam_c['h1'][ $fam_s['slug'] ] ?? '' ) ?: $fam_s['title'],
			'd'  => ( $fam_c['pitch'][ $fam_s['slug'] ] ?? '' ) ?: $fam_s['lede'],
			'to' => $fam_s['slug'],
		);
	}
	dlb_add(
		'dl-cat-list',
		array(
			'title' => '{n} prestations<br />dans cette famille.',
			'text'  => 'Chaque page dit ce qui est inclus, comment cela se passe, et ce que les gens nous demandent le plus souvent.',
			'rows'  => $fam_rows,
		)
	);

	dlb_add(
		'dl-cat-cover',
		array(
			'title'   => $fam['promise'],
			'label'   => 'Demander un devis',
			'to'      => '/contact/',
			'bullets' => dlb_lines( $fam['bullets'] ),
		)
	);

	dlb_add(
		'dl-cat-note',
		array_merge(
			array(
				'title' => $fam['aside']['t'],
				'text'  => $fam['aside']['d'],
				'book'  => 'Prendre rendez-vous',
			),
			dlb_photo( 'img', 'meet' )
		)
	);

	$fam_cards = array();
	foreach ( $fam_c['categories'] as $fam_o ) {
		if ( $fam_o['key'] === $fam['key'] ) {
			continue;
		}
		$fam_cards[] = array_merge(
			array(
				't'  => $fam_o['title'],
				'd'  => $fam_o['pitch'],
				'to' => $fam_o['slug'],
			),
			dlb_photo( 'img', $fam_o['img'] )
		);
	}
	dlb_add(
		'dl-cat-others',
		array(
			'title' => 'Vous cherchiez autre chose ?',
			'more'  => 'Voir la famille',
			'cards' => $fam_cards,
		)
	);

	dlb_ask();
	dlb_cta();

	dlb_finish( $fam_id );
}
