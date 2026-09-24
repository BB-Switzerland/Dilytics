<?php
/**
 * JSON-LD (schema.org) on every page: the cabinet as an AccountingService,
 * the website, the page with its breadcrumb, and on a service page the
 * service and its questions.
 *
 * What does not change from page to page is set by the build
 * (wordpress/chantier/metas.php): the dl_org option and each page's _dl_ld.
 * The URLs are resolved here, against the site's own address, and the FAQ is
 * read from the page's FAQ module, so an answer edited in Beaver Builder is
 * the answer in the markup. No e-mail address anywhere.
 */

defined( 'ABSPATH' ) || exit;

/** An absolute URL for a path of the site. */
function dl_ld_url( $path ) {
	return home_url( '/' === $path ? '/' : $path );
}

/** The cabinet, the same node on every page. */
function dl_ld_org() {
	$org  = (array) get_option( 'dl_org', array() );
	$c    = dl_contact();
	$home = dl_ld_url( '/' );
	$id   = $home . '#organization';

	// "1213 Petit-Lancy, Genève": postal code and locality
	preg_match( '/^(\d{4})\s+([^,]+)/u', (string) ( $c['city'] ?? '' ), $city );

	$node = array(
		'@type'       => 'AccountingService',
		'@id'         => $id,
		'name'        => 'Dilytics',
		'url'         => $home,
		'description' => $org['description'] ?? '',
		'logo'        => array(
			'@type'  => 'ImageObject',
			'url'    => DL_URL . 'assets/img/favicon.png',
			'width'  => 512,
			'height' => 512,
		),
		'telephone'   => $c['phone'] ?? '',
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $c['street'] ?? '',
			'postalCode'      => $city[1] ?? '',
			'addressLocality' => $city[2] ?? '',
			'addressRegion'   => 'GE',
			'addressCountry'  => 'CH',
		),
		'hasMap'      => $c['map'] ?? '',
		// "Lundi au vendredi, 9h – 12h et 13h – 18h"
		'openingHoursSpecification' => array(
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
				'opens'     => '09:00',
				'closes'    => '12:00',
			),
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
				'opens'     => '13:00',
				'closes'    => '18:00',
			),
		),
		'foundingDate' => (string) ( $c['since'] ?? '' ),
		'areaServed'   => $org['area'] ?? '',
		'sameAs'       => $org['same_as'] ?? array(),
	);

	$front = (int) get_option( 'page_on_front' );
	$img   = $front ? dl_img_url( (int) get_post_meta( $front, '_dl_image', true ) ) : '';
	if ( $img ) {
		$node['image'] = $img;
	}

	// No ReserveAction: the Bookings link carries an e-mail address.

	foreach ( $org['team'] ?? array() as $p ) {
		$node['employee'][] = array(
			'@type'    => 'Person',
			'name'     => $p['name'],
			'jobTitle' => $p['role'],
			'sameAs'   => array( $p['linkedin'] ),
			'worksFor' => array( '@id' => $id ),
		);
	}

	$families = array();
	foreach ( $org['catalog'] ?? array() as $f ) {
		$offers = array();
		foreach ( $f['services'] as $s ) {
			$offers[] = array(
				'@type'       => 'Offer',
				'itemOffered' => array(
					'@type' => 'Service',
					'name'  => $s[0],
					'url'   => dl_ld_url( $s[1] ),
				),
			);
		}
		$families[] = array(
			'@type'           => 'OfferCatalog',
			'name'            => $f['name'],
			'url'             => dl_ld_url( $f['path'] ),
			'itemListElement' => $offers,
		);
	}
	if ( $families ) {
		$node['hasOfferCatalog'] = array(
			'@type'           => 'OfferCatalog',
			'name'            => 'Prestations',
			'itemListElement' => $families,
		);
	}

	return array_filter( $node, fn( $v ) => '' !== $v && array() !== $v );
}

/** The questions of the page's FAQ module, as the page shows them. */
function dl_ld_faq( $post_id ) {
	if ( ! class_exists( 'FLBuilderModel' ) ) {
		return array();
	}
	$out = array();
	foreach ( (array) FLBuilderModel::get_layout_data( 'published', $post_id ) as $node ) {
		if ( 'module' !== ( $node->type ?? '' ) || 'dl-svc-faq' !== ( $node->settings->type ?? '' ) ) {
			continue;
		}
		foreach ( dl_items( $node->settings->items ?? array() ) as $it ) {
			$q = trim( wp_strip_all_tags( (string) ( $it->t ?? '' ) ) );
			$a = trim( wp_strip_all_tags( (string) ( $it->d ?? '' ) ) );
			if ( '' !== $q && '' !== $a ) {
				$out[] = array(
					'@type'          => 'Question',
					'name'           => $q,
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => $a,
					),
				);
			}
		}
	}
	return $out;
}

add_action(
	'wp_head',
	function () {
		if ( dl_editing() || ! is_singular() ) {
			return;
		}
		$id = get_queried_object_id();
		if ( ! $id || get_post_meta( $id, '_dl_noindex', true ) ) {
			return;
		}

		$ld   = (array) get_post_meta( $id, '_dl_ld', true );
		$home = dl_ld_url( '/' );
		$url  = get_permalink( $id );
		$org  = array( '@id' => $home . '#organization' );
		$page = array(
			'@type'      => $ld['type'] ?? 'WebPage',
			'@id'        => $url . '#webpage',
			'url'        => $url,
			'name'       => (string) get_post_meta( $id, '_dl_title', true ),
			'description' => (string) get_post_meta( $id, '_dl_description', true ),
			'inLanguage' => 'fr-CH',
			'isPartOf'   => array( '@id' => $home . '#website' ),
			'about'      => $org,
		);
		$img = dl_img_url( (int) get_post_meta( $id, '_dl_image', true ) );
		if ( $img ) {
			$page['primaryImageOfPage'] = array( '@type' => 'ImageObject', 'url' => $img );
		}

		$graph = array(
			dl_ld_org(),
			array(
				'@type'      => 'WebSite',
				'@id'        => $home . '#website',
				'url'        => $home,
				'name'       => 'Dilytics',
				'inLanguage' => 'fr-CH',
				'publisher'  => $org,
			),
		);

		if ( ! empty( $ld['crumbs'] ) ) {
			$items = array();
			foreach ( array_values( $ld['crumbs'] ) as $i => $cr ) {
				$items[] = array(
					'@type'    => 'ListItem',
					'position' => $i + 1,
					'name'     => $cr[0],
					'item'     => dl_ld_url( $cr[1] ),
				);
			}
			$page['breadcrumb'] = array( '@id' => $url . '#breadcrumb' );
			$graph[]            = array(
				'@type'           => 'BreadcrumbList',
				'@id'             => $url . '#breadcrumb',
				'itemListElement' => $items,
			);
		}

		if ( ! empty( $ld['service'] ) ) {
			$service = array(
				'@type'       => 'Service',
				'@id'         => $url . '#service',
				'name'        => $ld['service']['name'],
				'description' => $ld['service']['description'],
				'category'    => $ld['service']['category'],
				'url'         => $url,
				'provider'    => $org,
				'areaServed'  => ( (array) get_option( 'dl_org', array() ) )['area'] ?? '',
			);
			if ( $img ) {
				$service['image'] = $img;
			}
			$page['about'] = array( '@id' => $url . '#service' );
			$graph[]       = array_filter( $service, fn( $v ) => '' !== $v );

			// the page's questions make it an FAQ page as well
			$faq = dl_ld_faq( $id );
			if ( $faq ) {
				$page['@type']      = array( 'WebPage', 'FAQPage' );
				$page['mainEntity'] = $faq;
			}
		}

		$graph[] = array_filter( $page, fn( $v ) => '' !== $v );

		$json = wp_json_encode(
			array(
				'@context' => 'https://schema.org',
				'@graph'   => $graph,
			),
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG
		);
		echo '<script type="application/ld+json">' . $json . "</script>\n";
	},
	3
);
