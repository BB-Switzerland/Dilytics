<?php
/**
 * / (the front page, /accueil/) — pages/index.vue.
 */

defined( 'ABSPATH' ) || exit;

$c  = dlb_content();
$s  = $c['site'];
$k  = $c['components'];
$id = dlb_page( 'accueil' );
dlb_start( $id );

// HomeOpen: the years are counted at render time from the founding
$strip         = $k['homeOpen']['strip'];
$strip[0]['v'] = '{years} ans';
dlb_add(
	'dl-home-open',
	array_merge(
		array(
			'lines'  => dlb_lines( array( 'Le partenaire stratégique', 'des dirigeants.' ) ),
			'accent' => '1',
			'intro'  => "Depuis {since}, notre fiduciaire à Genève vous libère de vos obligations fiscales, juridiques et administratives, à travers un accompagnement personnalisé ou une aide ponctuelle. Notre équipe intervient dans toute la Suisse romande et à l'étranger.",
			'label'  => 'Réserver mon entretien',
			'strip'  => $strip,
		),
		dlb_photo( 'img', 'meet' )
	)
);

dlb_add(
	'dl-home-demand',
	array(
		'title' => 'Nos prestations<br />pour les entreprises',
		'all'   => 'Toutes nos prestations',
		'to'    => '/entreprises/',
		'rows'  => $k['homeDemand']['rows'],
	)
);

dlb_add(
	'dl-home-benefits',
	array(
		'title' => 'De la création à la transmission<br />de votre entreprise.',
		'text'  => 'Nous voulons être un véritable partenaire stratégique pour les dirigeants. Voici ce que cela change concrètement.',
		'items' => $k['homeBenefits']['items'],
	)
);

dlb_add(
	'dl-home-statement',
	array(
		'text' => "Nos conseillers <span class=\"red\">anticipent toujours vos défis à venir</span> et proposent des solutions concrètes, adaptées aux entreprises d'aujourd'hui.",
	)
);

dlb_add(
	'dl-home-split',
	array_merge(
		array(
			'badge_alt' => 'Badge bexio Partenaire Platine',
			'badge_t'   => 'Partenaire<br />bexio',
			'title'     => "Ce qui nous distingue d'une fiduciaire classique.",
			'text'      => "Les fiduciaires classiques n'accompagnent pas leurs clients dans les problématiques du quotidien. Dilytics ne commet pas cette erreur.",
			'points'    => $k['homeSplit']['points'],
		),
		dlb_photo( 'img', 'desk' ),
		dlb_photo( 'badge', 'bexio_platine' )
	)
);

dlb_add(
	'dl-home-start',
	array(
		'title' => 'Quinze minutes pour savoir<br />si nous pouvons vous aider.',
		'text'  => "Vous aimeriez parler avec un de nos conseillers à propos d'un service, ou simplement savoir si notre fiduciaire peut vous être utile ? Voici comment cela se passe.",
		'steps' => $k['homeStart']['steps'],
		'label' => 'Réserver mon entretien',
	)
);

// HomeFigures: TEAM[0] and STATS
$lead  = $s['TEAM'][0];
$stats = array();
foreach ( $s['STATS'] as $st ) {
	$stats[] = array(
		'n'       => isset( $st['n'] ) ? (string) $st['n'] : '',
		'prefix'  => $st['prefix'] ?? '',
		'suffix'  => $st['suffix'] ?? '',
		'text'    => $st['text'] ?? '',
		'label'   => $st['label'] ?? '',
		'pending' => $st['pending'] ?? '',
		'hint'    => $st['hint'] ?? '',
	);
}
dlb_add(
	'dl-home-figures',
	array_merge(
		array(
			'quote' => "J'ai très vite constaté que l'importance n'était pas accordée <span class=\"red\">aux projets des clients.</span>",
			'name'  => $lead['name'],
			'role'  => $lead['role'],
			'label' => 'Découvrir le cabinet',
			'to'    => '/a-propos/',
			'stats' => $stats,
		),
		dlb_photo( 'img', $lead['img'] )
	)
);

// HomeReviews: REVIEWS, REVIEW_SLOTS, DISTINCTIONS
$reviews = array();
foreach ( $s['REVIEWS'] as $r ) {
	$reviews[] = array(
		'quote'   => $r['quote'],
		'name'    => $r['name'],
		'role'    => $r['role'],
		'company' => $r['company'],
	);
}
$marks = array();
foreach ( $s['DISTINCTIONS'] as $d ) {
	$marks[] = array_merge(
		array(
			'v'   => $d['v'],
			't'   => $d['t'],
			'alt' => $d['alt'] ?? '',
		),
		! empty( $d['img'] ) ? dlb_photo( 'img', $d['img'] ) : array()
	);
}
dlb_add(
	'dl-home-reviews',
	array(
		'title'      => 'Ce que disent nos clients.',
		'reviews'    => $reviews,
		'slots'      => (string) $s['REVIEW_SLOTS'],
		'slot_label' => 'Avis client à fournir',
		'slot_hint'  => "Une citation courte, avec le nom, la fonction et l'entreprise du client, et son accord pour la publier.",
		'marks'      => $marks,
	)
);

// HomeJournal: ARTICLES, every one linking to the articles page as on Nuxt
$articles = array();
foreach ( $s['ARTICLES'] as $a ) {
	$articles[] = array_merge(
		array(
			'title'   => $a['title'],
			'excerpt' => $a['excerpt'],
			'date'    => $a['date'],
		),
		dlb_photo( 'img', $a['img'] )
	);
}
dlb_add(
	'dl-home-journal',
	array(
		'title'    => 'Ce que nous écrivons.',
		'all'      => 'Tous les articles',
		'to'       => '/articles/',
		'articles' => $articles,
	)
);

dlb_cta();

dlb_finish( $id );
