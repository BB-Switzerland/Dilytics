<?php
/**
 * Markup of SiteNav.vue, element for element. The scope classes sit on the
 * component roots (v-scroll-bar, v-site-nav), never on the module's own root,
 * so the two components' rules never reach each other: both name a `.bar`.
 */

$fams    = dl_menu_families();
$home    = is_front_page();
$phone   = dl_contact( 'phone' );
$tel     = dl_contact( 'phoneHref' );
$booking = dl_contact( 'booking' );
$contact = dl_url( '/contact/' );
$ar      = dl_ar();
?>
<div<?php dl_root( $module, array( 'dl-shell' ) ); ?>>
<div class="bar v-scroll-bar" aria-hidden="true"><span style="transform:scaleX(0);"></span></div>
<header class="nv v-site-nav<?php echo $home ? ' over' : ''; ?>"<?php echo $home ? ' data-home' : ''; ?>>
	<div class="bar band-lead">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand" aria-label="Dilytics, accueil"><?php echo dl_logo(); ?></a>

		<nav class="mid" aria-label="Navigation principale">
			<?php foreach ( $fams as $f ) : ?>
				<a href="<?php echo esc_url( $f['to'] ); ?>" class="tg" aria-expanded="false" data-panel="<?php echo esc_attr( $f['label'] ); ?>"><?php echo esc_html( $f['label'] ); ?></a>
			<?php endforeach; ?>
			<a href="<?php echo esc_url( $contact ); ?>" class="tg flat<?php echo dl_is_current( '/contact/' ) ? ' router-link-active' : ''; ?>">Contact</a>
			<span class="mark" style="transform:translateX(0px) scaleX(0);"></span>
		</nav>

		<div class="end">
			<a href="<?php echo esc_attr( $tel ); ?>" class="tel"><?php echo esc_html( $phone ); ?></a>
			<a href="<?php echo esc_url( $booking ); ?>" target="_blank" rel="noopener" class="cta cta-red cta-sm"><span><?php echo dl_t( dl_s( $settings, 'cta', 'Rendez-vous' ) ); ?></span><?php echo $ar; ?></a>
			<button class="bg" aria-expanded="false" aria-label="Menu"><i></i><i></i></button>
		</div>
	</div>

	<div class="mega">
		<?php foreach ( $fams as $f ) : ?>
			<div class="mg band-lead" data-panel="<?php echo esc_attr( $f['label'] ); ?>" style="display:none;">
				<div class="zone intro">
					<h2 class="d3"><?php echo esc_html( $f['label'] ); ?></h2>
					<p class="sm"><?php echo esc_html( $f['blurb'] ); ?></p>
					<a href="<?php echo esc_url( $f['to'] ); ?>" class="lnk">Voir les <?php echo count( $f['items'] ); ?> prestations<?php echo $ar; ?></a>
				</div>

				<ul class="zone links">
					<?php foreach ( $f['items'] as $i => $it ) : ?>
						<li style="--i:<?php echo (int) $i; ?>;"><a href="<?php echo esc_url( $it['to'] ); ?>"><span class="nm"><?php echo esc_html( $it['label'] ); ?></span><?php echo $ar; ?></a></li>
					<?php endforeach; ?>
				</ul>

				<div class="zone aside">
					<div class="shot pic"><img src="<?php echo esc_url( dl_img_url( $f['img'] ) ); ?>" alt=""><?php echo dl_photo_note( dl_img_name( $f['img'] ), array( 'compact' => true ) ); ?></div>
					<p class="xs"><?php echo dl_t( dl_s( $settings, 'aside', 'Une question avant de choisir ?' ) ); ?></p>
					<a href="<?php echo esc_attr( $tel ); ?>" class="ph"><?php echo esc_html( $phone ); ?></a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</header>

<div class="drw v-site-nav">
	<div class="di">
		<?php foreach ( $fams as $f ) : ?>
			<div>
				<button class="gt" aria-expanded="false" data-acc="<?php echo esc_attr( $f['label'] ); ?>"><?php echo esc_html( $f['label'] ); ?><i class=""></i></button>
				<div class="gb">
					<div class="gl">
						<a href="<?php echo esc_url( $f['to'] ); ?>" class="top-link">Vue d'ensemble<?php echo $ar; ?></a>
						<?php foreach ( $f['items'] as $it ) : ?>
							<a href="<?php echo esc_url( $it['to'] ); ?>"><?php echo esc_html( $it['label'] ); ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		<a href="<?php echo esc_url( $contact ); ?>" class="gt">Contact</a>
		<div class="df">
			<a href="<?php echo esc_attr( $tel ); ?>" class="d2 dt"><?php echo esc_html( $phone ); ?></a>
			<a href="<?php echo esc_url( $booking ); ?>" target="_blank" rel="noopener" class="cta cta-red"><span><?php echo dl_t( dl_s( $settings, 'drawer_cta', 'Prendre rendez-vous' ) ); ?></span><?php echo $ar; ?></a>
		</div>
	</div>
</div>
</div>
