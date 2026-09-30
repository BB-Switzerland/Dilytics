<?php
/**
 * Title, description and share image of every page: the only place they are
 * set. Metas only, the layouts are left alone, so a page edited in Beaver
 * Builder keeps its edits.
 *
 *   wordpress/deploy.sh metas
 *
 * Every description is taken from the text the page itself shows (dlb_desc):
 * the service and family ledes, the opening paragraph of the other pages.
 * The share image is the page's opening picture.
 */

defined( 'ABSPATH' ) || exit;

$c     = dlb_content();
$since = $c['site']['CONTACT']['since'];
$lead  = $c['site']['ARTICLES'][0];
$rows  = array();

// Where the lede's whole sentences make too short or too long a description,
// other sentences the same page shows (its pitch, tagline or intro), whole.
$pitch = $c['pitch'];
$lede1 = fn( $text ) => preg_split( '/(?<=[.!?])\s+/u', $text )[0];
$cats  = array_column( $c['categories'], null, 'slug' );
$svc   = array_column( $c['services'], null, 'slug' );
$descs = array(
	'/entreprises/'                  => $cats['/entreprises/']['pitch'] . ' ' . $lede1( $cats['/entreprises/']['lede'] ),
	'/particuliers/'                 => $cats['/particuliers/']['pitch'] . ' ' . $lede1( $cats['/particuliers/']['lede'] ),
	'/creation-dentreprise/'         => $cats['/creation-dentreprise/']['pitch'] . ' ' . $lede1( $cats['/creation-dentreprise/']['lede'] ),
	'/payroll-et-administration-rh/' => $lede1( $svc['/payroll-et-administration-rh/']['lede'] ) . ' ' . $pitch['/payroll-et-administration-rh/'],
	'/tva-suisse/'                   => $c['bodies']['/tva-suisse/']['tagline'] . ' ' . $lede1( $svc['/tva-suisse/']['lede'] ),
	'/controle-restreint/'           => $lede1( $c['bodies']['/controle-restreint/']['intro'] ),
);

/*
 * $ld feeds the page's JSON-LD (dilytics-modules/includes/schema.php): its
 * schema.org type, its breadcrumb as the page shows it, and for a service
 * page the service itself. Paths only: the plugin resolves them against the
 * site's URL when it prints the graph.
 */
$set = function ( $slug, $title, $desc, $img, array $ld = array(), $noindex = false ) use ( &$rows ) {
	$p = get_page_by_path( $slug, OBJECT, 'page' );
	if ( ! $p ) {
		WP_CLI::warning( "No page {$slug}" );
		return;
	}
	$desc = $desc ? dlb_desc( $desc ) : '';
	dlb_meta( $p->ID, $title, $desc, $noindex, $img );
	$ld ? update_post_meta( $p->ID, '_dl_ld', $ld ) : delete_post_meta( $p->ID, '_dl_ld' );
	$rows[] = sprintf( '%-48s %3d %3d  %s', '/' . $slug . '/', mb_strlen( $title ), mb_strlen( $desc ), $title );
};
$crumbs = fn( ...$trail ) => array_merge( array( array( 'Accueil', '/' ) ), $trail );

// the footer's line: the opening paragraph of the home page runs past 160
$set(
	'accueil',
	"Dilytics, votre fiduciaire à Genève depuis {$since}",
	"Fiduciaire genevoise depuis {$since}. Comptabilité, fiscalité, salaires et création d'entreprise, pour les PME et les particuliers.",
	'meet',
	array( 'type' => 'WebPage' )
);

foreach ( $c['categories'] as $fam ) {
	$set(
		trim( $fam['slug'], '/' ),
		dlb_title( $fam['title'] ),
		$descs[ $fam['slug'] ] ?? $fam['lede'],
		$fam['img'],
		array(
			'type'   => 'CollectionPage',
			'crumbs' => $crumbs( array( $fam['title'], $fam['slug'] ) ),
		)
	);
}

$catalog = array();
foreach ( $c['services'] as $s ) {
	$heading = ( $c['h1'][ $s['slug'] ] ?? '' ) ? $c['h1'][ $s['slug'] ] : $s['title'];
	$fam     = $cats[ array_column( $c['categories'], 'slug', 'key' )[ $s['group'] ] ];
	$set(
		trim( $s['slug'], '/' ),
		dlb_title( $heading ),
		$descs[ $s['slug'] ] ?? $s['lede'],
		$s['img'],
		array(
			'type'    => 'WebPage',
			'crumbs'  => $crumbs( array( $fam['nav'], $fam['slug'] ), array( $heading, $s['slug'] ) ),
			'service' => array(
				'name'        => $heading,
				'description' => $s['lede'],
				'category'    => $fam['title'],
			),
		)
	);
	$catalog[ $fam['slug'] ]['name']       = $fam['title'];
	$catalog[ $fam['slug'] ]['services'][] = array( $heading, $s['slug'] );
}

$set(
	'a-propos',
	dlb_title( 'À propos' ),
	'Notre équipe résout vos défis quotidiens, qui peuvent prendre plusieurs dimensions. Notre philosophie est de penser à votre projet et à vos besoins.',
	'apropos',
	array(
		'type'   => 'AboutPage',
		'crumbs' => $crumbs( array( 'À propos', '/a-propos/' ) ),
	)
);

$set(
	'contact',
	dlb_title( 'Contact' ),
	'Remplissez le formulaire pour nous poser vos questions ou demander un devis. Vous pouvez également nous joindre par téléphone, du lundi au vendredi.',
	'geneve',
	array(
		'type'   => 'ContactPage',
		'crumbs' => $crumbs( array( 'Contact', '/contact/' ) ),
	)
);

// the postings shown today are samples: no JobPosting until real ones exist
$set(
	'offres-demploi',
	dlb_title( "Offres d'emploi" ),
	"Chez Dilytics, nous sommes une équipe passionnée, innovante et résolument tournée vers l'avenir, qui valorise ses collaborateurs autant que ses clients.",
	'duo',
	array(
		'type'   => 'WebPage',
		'crumbs' => $crumbs( array( 'Carrière', '/offres-demploi/' ) ),
	)
);

$set(
	'articles',
	dlb_title( 'Articles' ),
	"Dilytics propose une série d'articles en lien avec la création d'entreprise et la fiscalité en Suisse.",
	$lead['img'],
	array(
		'type'   => 'CollectionPage',
		'crumbs' => $crumbs( array( 'Articles', '/articles/' ) ),
	)
);

$set( 'photos-a-fournir', 'Photos à fournir · Dilytics', '', '', array(), true );
$set( 'paiement-confirme', 'Paiement reçu · Dilytics', '', '', array(), true );
$set( 'politique-de-cookies', 'Politique de cookies · Dilytics', '', '', array(), true );
$set( 'declaration-sur-la-protection-des-donnees', 'Protection des données · Dilytics', '', '', array(), true );
$set( 'conditions-generales-de-vente', 'Conditions générales de vente · Dilytics', '', '', array(), true );

/*
 * The cabinet, for the JSON-LD of every page: what the site says of it and
 * no more. The contact details, hours and booking link are read at print
 * time from the dl_contact option. No e-mail address, as asked. No rating:
 * the Google reviews are collected on Google, and marking them up on the
 * site's own pages breaks Google's review guidelines.
 */
update_option(
	'dl_org',
	array(
		'description' => "Fiduciaire genevoise depuis {$since}. Comptabilité, fiscalité, salaires et création d'entreprise, pour les PME et les particuliers.",
		'area'        => 'Suisse romande',
		'same_as'     => array_column( $c['site']['SOCIAL'], 'href' ),
		'team'        => array_map(
			fn( $p ) => array(
				'name'     => $p['name'],
				'role'     => $p['role'],
				'linkedin' => $p['linkedin'],
			),
			$c['site']['TEAM']
		),
		'catalog'     => array_map(
			fn( $path, $f ) => array(
				'name'     => $f['name'],
				'path'     => $path,
				'services' => $f['services'],
			),
			array_keys( $catalog ),
			$catalog
		),
	),
	false
);

dlb_log( sprintf( '%-48s %3s %3s  %s', 'page', 'T', 'D', 'title (T, D: lengths)' ) );
foreach ( $rows as $r ) {
	dlb_log( $r );
}
