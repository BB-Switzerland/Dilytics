<?php
/**
 * Markup of SiteFoot.vue. The footer is the module's root.
 */

$fams = dl_menu_families();
$c    = dl_contact();
?>
<footer<?php dl_root( $module, array( 'ft', 'v-site-foot' ) ); ?>>
	<div class="wrap">
		<?php echo dl_ax(); ?>
		<div class="top">
			<div class="brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="lg" aria-label="Dilytics, accueil"><?php echo dl_logo(); ?></a>
				<p class="sm"><?php echo dl_t( str_replace( '{since}', (string) ( $c['since'] ?? '' ), dl_s( $settings, 'intro' ) ) ); ?></p>
				<address class="xs ad"><?php echo esc_html( $c['street'] ?? '' ); ?><br><?php echo esc_html( $c['city'] ?? '' ); ?><br><?php echo esc_html( $c['hours'] ?? '' ); ?></address>
				<?php if ( dl_photo( $settings, 'badge' ) ) : ?>
					<img src="<?php echo esc_url( dl_photo( $settings, 'badge' ) ); ?>" alt="<?php echo esc_attr( dl_s( $settings, 'badge_alt' ) ); ?>" class="bxf" loading="lazy">
				<?php endif; ?>
			</div>

			<nav class="cols">
				<?php foreach ( $fams as $f ) : ?>
					<div>
						<h2 class="ch"><?php echo esc_html( $f['label'] ); ?></h2>
						<?php foreach ( $f['items'] as $it ) : ?>
							<a href="<?php echo esc_url( $it['to'] ); ?>"><?php echo esc_html( $it['label'] ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<div>
					<h2 class="ch">Contact</h2>
					<a href="<?php echo esc_url( dl_url( '/contact/' ) ); ?>">Nous écrire</a>
					<a href="<?php echo esc_url( $c['booking'] ?? '' ); ?>" target="_blank" rel="noopener">Prendre rendez-vous</a>
					<a href="<?php echo esc_attr( $c['phoneHref'] ?? '' ); ?>"><?php echo esc_html( $c['phone'] ?? '' ); ?></a>
					<a href="<?php echo esc_attr( 'mailto:' . ( $c['mail'] ?? '' ) ); ?>"><?php echo esc_html( $c['mail'] ?? '' ); ?></a>
				</div>
			</nav>
		</div>

		<?php echo dl_ax(); ?>
		<div class="bot">
			<span class="xs"><?php echo dl_t( dl_s( $settings, 'copy' ) ); ?></span>
			<nav class="legal" aria-label="Informations légales">
				<?php foreach ( dl_items( $settings->legal ?? array() ) as $l ) : ?>
					<a href="<?php echo esc_url( dl_url( $l->to ?? '' ) ); ?>" target="_blank" rel="noopener" class="xs"><?php echo esc_html( $l->t ?? '' ); ?></a>
				<?php endforeach; ?>
			</nav>
		</div>
	</div>
</footer>
