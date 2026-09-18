<?php
/**
 * The nineteen service pages — pages/[slug].vue, one page per entry of
 * SERVICES, every value computed as the Nuxt page computes it.
 */

defined( 'ABSPATH' ) || exit;

( function () {
	$c        = dlb_content();
	$services = $c['services'];
	$by_slug  = array_column( $services, null, 'slug' );
	$cats     = array_column( $c['categories'], null, 'key' );

	// CrossSell: the related services first, then the same family, then the
	// others, four at most, in the order of SERVICES
	$cross = function ( array $s ) use ( $services ) {
		$out = array_values( $s['related'] ?? array() );
		foreach ( $services as $o ) {
			if ( count( $out ) >= 4 ) {
				break;
			}
			if ( $o['slug'] !== $s['slug'] && ! in_array( $o['slug'], $out, true ) && $o['group'] === $s['group'] ) {
				$out[] = $o['slug'];
			}
		}
		foreach ( $services as $o ) {
			if ( count( $out ) >= 4 ) {
				break;
			}
			if ( $o['slug'] !== $s['slug'] && ! in_array( $o['slug'], $out, true ) ) {
				$out[] = $o['slug'];
			}
		}
		return array_slice( $out, 0, 4 );
	};

	foreach ( $services as $s ) {
		$slug    = $s['slug'];
		$parent  = $cats[ $s['group'] ];
		$price   = $c['price'][ $slug ] ?? null;
		$heading = ( $c['h1'][ $slug ] ?? '' ) ? $c['h1'][ $slug ] : $s['title'];
		$b       = $c['bodies'][ $slug ] ?? null;
		$tagline = ( $b['tagline'] ?? '' ) ? $b['tagline'] : ( ( $c['pitch'][ $slug ] ?? '' ) ? $c['pitch'][ $slug ] : $s['lede'] );
		$secs    = $b['sections'] ?? array();

		$id = dlb_page( trim( $slug, '/' ), $heading );
		dlb_meta( $id, $heading . ' · Dilytics, fiduciaire à Genève', mb_substr( $tagline, 0, 155 ) );
		dlb_start( $id );
		dlb_scope( 'v-slug' );

		dlb_add(
			'dl-svc-hero',
			array_merge(
				array(
					'parent_t'  => $parent['nav'],
					'parent_to' => $parent['slug'],
					'title'     => $heading,
					'tagline'   => $tagline,
					'intro'     => $b ? $b['intro'] : $s['lede'],
					'book'      => 'Réserver un entretien',
					'write'     => 'Nous écrire',
					'alt'       => $heading,
				),
				dlb_photo( 'img', $s['img'] )
			)
		);

		if ( ! empty( $b['benefits'] ) ) {
			dlb_add(
				'dl-svc-benefits',
				array(
					'items' => array_map(
						function ( $x ) {
							return array(
								'ico' => $x['ico'],
								't'   => $x['t'],
								'd'   => $x['d'],
							);
						},
						$b['benefits']
					),
				)
			);
		}

		if ( $secs ) {
			dlb_add(
				'dl-svc-guide',
				array_merge(
					array(
						'rail_t' => 'Sommaire',
						'ask'    => 'Une question avant de vous lancer ?',
						'secs'   => array_map(
							function ( $sec ) {
								return array(
									't' => $sec['t'],
									'p' => dlb_paras( $sec['p'] ),
								);
							},
							$secs
						),
						'alt'    => $parent['nav'],
					),
					dlb_photo( 'img', $parent['img'] )
				)
			);
		}

		if ( ! empty( $b['list'] ) ) {
			dlb_add(
				'dl-svc-list',
				array(
					'title' => $b['list']['t'],
					// a plain line is an item without a name
					'items' => array_map(
						function ( $it ) {
							return is_array( $it )
								? array(
									't' => $it['t'] ?? '',
									'd' => $it['d'] ?? '',
								)
								: array(
									't' => '',
									'd' => $it,
								);
						},
						$b['list']['items']
					),
				)
			);
		}

		if ( $price ) {
			$offer = $b['offer'] ?? null;
			dlb_add(
				'dl-price',
				array(
					'lead'      => $price['lead'] ?? '',
					'amount'    => (string) $price['amount'],
					'unit'      => $price['unit'] ?? '',
					'per'       => $price['per'] ?? '',
					'terms'     => $price['terms'] ?? '',
					'detail'    => $price['detail'] ?? '',
					'cta'       => $price['cta'] ?? '',
					'offer_t'   => $offer['t'] ?? '',
					'offer_d'   => $offer['d'] ?? '',
					'offer_cta' => $offer['cta'] ?? '',
					'facts_t'   => $heading . ', en bref',
					'facts'     => array_map(
						function ( $f ) {
							return array(
								'k' => $f['k'],
								'v' => $f['v'],
							);
						},
						$s['facts'] ?? array()
					),
					'facts_cta' => 'Prendre rendez-vous',
				)
			);
		}

		dlb_add(
			'dl-svc-faq',
			array(
				'title' => 'Questions fréquentes',
				'text'  => 'Votre situation ne rentre dans aucune case ? Appelez-nous, la première conversation ne vous engage à rien.',
				'items' => array_map(
					function ( $f ) {
						return array(
							't' => $f['q'],
							'd' => $f['a'],
						);
					},
					$s['faq'] ?? array()
				),
			)
		);

		$cards = array();
		foreach ( $cross( $s ) as $o ) {
			if ( empty( $by_slug[ $o ] ) ) {
				continue;
			}
			$o       = $by_slug[ $o ];
			$cards[] = array_merge(
				array(
					't'  => $o['title'],
					'd'  => ( $c['pitch'][ $o['slug'] ] ?? '' ) ? $c['pitch'][ $o['slug'] ] : $o['lede'],
					'to' => $o['slug'],
				),
				dlb_photo( 'img', $o['img'] )
			);
		}
		dlb_add(
			'dl-cross',
			array(
				'title' => "Avez-vous besoin d'un autre service ?",
				'items' => $cards,
				'visit' => 'Visiter la page',
			)
		);

		dlb_ask();

		// a service may word its own closing call, as the CFO page does
		$o = array();
		if ( ! empty( $b['cta']['title'] ) ) {
			$o['lines'] = dlb_lines( $b['cta']['title'] );
		}
		if ( ! empty( $b['cta']['text'] ) ) {
			$o['text'] = $b['cta']['text'];
		}
		if ( ! empty( $b['cta']['action'] ) ) {
			$o['label'] = $b['cta']['action']['label'] ?? '';
			$o['to']    = $b['cta']['action']['to'] ?? '';
		}
		dlb_cta( $o );

		dlb_finish( $id );
	}
} )();
