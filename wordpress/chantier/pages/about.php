<?php
/**
 * /a-propos/ — pages/a-propos.vue.
 */

defined( 'ABSPATH' ) || exit;

$c     = dlb_content();
$about = $c['components']['about'];
$id    = dlb_page( 'a-propos' );
dlb_meta( $id, 'À propos · Dilytics, fiduciaire à Genève' );
dlb_start( $id );
dlb_scope( 'v-a-propos' );

dlb_add(
	'dl-about-open',
	array_merge(
		array(
			'crumb' => 'À propos',
			'title' => 'Bien plus qu’une fiduciaire',
			'intro' => dlb_paras(
				array(
					'Notre équipe résout vos défis quotidiens, qui peuvent prendre plusieurs dimensions. Notre philosophie est de penser à votre projet et à vos besoins.',
					'Notre entreprise a pour ambition de devenir le partenaire qui vous aide à concrétiser vos objectifs entrepreneuriaux et financiers. Nous partageons vos responsabilités et comprenons vos défis.',
				)
			),
			'alt'   => 'La réception du cabinet Dilytics au Petit-Lancy',
		),
		dlb_photo( 'img', 'apropos' )
	)
);

dlb_add( 'dl-about-marks', array( 'items' => $about['marks'] ) );

dlb_add(
	'dl-about-hist',
	array(
		'title' => 'Notre histoire',
		'text'  => 'Une histoire qui s’est construite en deux étapes.',
		'eras'  => array_map(
			fn( $e ) => array(
				'y' => $e['y'],
				't' => $e['t'],
				'p' => dlb_paras( $e['p'] ),
			),
			$about['eras']
		),
	)
);

dlb_add(
	'dl-about-phi',
	array(
		'title'  => 'Notre philosophie',
		'text'   => 'Quatre principes, et des interlocuteurs humains qui vous accompagnent réellement.',
		'values' => $about['values'],
	)
);

dlb_add(
	'dl-about-team',
	array(
		'title'      => 'Découvrez notre équipe',
		'text'       => 'Notre politique de recrutement accorde une grande importance à l’expertise. Nous tenons à réunir des experts capables de proposer des solutions innovantes.',
		'people'     => array_map(
			fn( $p ) => array_merge(
				array(
					'name'     => $p['name'],
					'role'     => $p['role'],
					'quote'    => $p['quote'],
					'diploma'  => $p['diploma'],
					'langs'    => $p['langs'],
					'linkedin' => $p['linkedin'],
				),
				dlb_photo( 'img', $p['img'] )
			),
			$c['site']['TEAM']
		),
		'jobs_label' => 'Nous recrutons',
		'jobs_to'    => '/offres-demploi/',
	)
);

dlb_add(
	'dl-about-loc',
	array(
		'title' => 'Nos locaux',
		'label' => 'Photo réelle à fournir',
		'slots' => array_map( fn( $e ) => array( 't' => $e['brief'] ), $c['photos']['EXPECTED'] ),
	)
);

dlb_add(
	'dl-about-bex',
	array_merge(
		array(
			'alt'   => 'Badge bexio Partenaire Platine',
			'title' => 'Partenaire Platine bexio',
			'text'  => 'Dilytics est partenaire Platine du logiciel bexio. Nos spécialistes sont habilités à intégrer cette solution et à former votre personnel à son utilisation.',
		),
		dlb_photo( 'img', 'bexio_platine' )
	)
);

dlb_cta(
	array(
		'lines' => dlb_lines( array( 'Venez', 'nous voir.' ) ),
		'text'  => 'Notre cabinet se situe à Lancy, à moins de dix minutes du centre-ville de Genève. ' . $c['site']['CONTACT']['hours'] . '.',
	)
);

dlb_finish( $id );
