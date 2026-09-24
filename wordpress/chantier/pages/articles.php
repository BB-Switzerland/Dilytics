<?php
/**
 * /articles/ — pages/articles.vue. The first article is the lead, the others
 * fill the grid; every card links to the page itself, as on the Nuxt site.
 */

defined( 'ABSPATH' ) || exit;

$c    = dlb_content();
$arts = $c['site']['ARTICLES'];
$lead = $arts[0];
$id   = dlb_page( 'articles' );
dlb_start( $id );
dlb_scope( 'v-articles' );

dlb_add(
	'dl-articles-open',
	array_merge(
		array(
			'crumb'   => 'Articles',
			'lines'   => dlb_lines( array( 'Trouvez les conseils', 'dont vous avez besoin.' ) ),
			'accent'  => '1',
			'text'    => "Dilytics propose une série d'articles en lien avec la création d'entreprise et la fiscalité en Suisse.",
			'title'   => $lead['title'],
			'excerpt' => $lead['excerpt'],
			'date'    => $lead['date'],
			'to'      => '/articles/',
		),
		dlb_photo( 'img', $lead['img'] )
	)
);

dlb_add(
	'dl-articles-grid',
	array(
		'items' => array_map(
			fn( $a ) => array_merge(
				array(
					't'       => $a['title'],
					'excerpt' => $a['excerpt'],
					'date'    => $a['date'],
					'to'      => '/articles/',
				),
				dlb_photo( 'img', $a['img'] )
			),
			array_slice( $arts, 1 )
		),
	)
);

dlb_cta( array( 'lines' => dlb_lines( array( 'Une question', 'précise ?' ) ) ) );

dlb_finish( $id );
