<?php
$c     = dl_contact();
$ar    = dl_ar();
$facts = dl_items( $settings->facts ?? array() );
$aside = dl_s( $settings, 'offer_t' ) ? 'offer' : ( $facts ? 'facts' : null );
// the figure counts up to itself (site.js): it holds the published figure until then
$raw = (string) dl_s( $settings, 'amount' );
?>
<section<?php dl_root( $module, array( 'pr', 'v-price-block' ) ); ?>>
	<div class="band-lead">
		<div class="wrap2<?php echo $aside ? '' : ' solo'; ?>">
			<div class="card main"<?php echo dl_rv( 'up' ); ?> data-tilt>
				<p class="lead"><?php echo dl_t( dl_s( $settings, 'lead' ) ); ?></p>

				<p class="amount">
					<span class="fig n" data-price="<?php echo esc_attr( $raw ); ?>"><?php echo esc_html( $raw ); ?></span>
					<span class="unit">
						<span class="cur"><?php echo dl_t( dl_s( $settings, 'unit' ) ); ?></span>
						<?php if ( dl_s( $settings, 'per' ) ) : ?>
							<span class="per"><?php echo dl_t( dl_s( $settings, 'per' ) ); ?></span>
						<?php endif; ?>
					</span>
				</p>
				<?php if ( dl_s( $settings, 'terms' ) ) : ?>
					<p class="terms"><?php echo dl_t( dl_s( $settings, 'terms' ) ); ?></p>
				<?php endif; ?>

				<p class="detail"><?php echo dl_t( dl_s( $settings, 'detail' ) ); ?></p>

				<div class="acts">
					<a href="<?php echo esc_url( dl_url( '/contact/' ) ); ?>" class="cta cta-red" data-mag><span><?php echo dl_t( dl_s( $settings, 'cta' ) ); ?></span><?php echo $ar; ?></a>
					<?php if ( dl_s( $settings, 'pay' ) ) : ?>
						<a href="<?php echo esc_url( dl_s( $settings, 'pay' ) ); ?>" class="cta cta-ink" data-mag><span><?php echo dl_t( dl_s( $settings, 'pay_label', 'Payer en ligne' ) ); ?></span><?php echo $ar; ?></a>
					<?php endif; ?>
					<a href="<?php echo esc_attr( $c['phoneHref'] ?? '' ); ?>" class="ph"><?php echo esc_html( $c['phone'] ?? '' ); ?></a>
				</div>
			</div>

			<?php if ( 'offer' === $aside ) : ?>
				<div class="card gift"<?php echo dl_rv( 'up', 8 ); ?> data-tilt>
					<h2 class="gt"><?php echo dl_t( dl_s( $settings, 'offer_t' ) ); ?></h2>
					<p class="gd"><?php echo dl_t( dl_s( $settings, 'offer_d' ) ); ?></p>
					<a href="<?php echo esc_url( dl_url( '/contact/' ) ); ?>" class="cta cta-light" data-mag><span><?php echo dl_t( dl_s( $settings, 'offer_cta' ) ); ?></span><?php echo $ar; ?></a>
				</div>
			<?php elseif ( 'facts' === $aside ) : ?>
				<div class="card keys"<?php echo dl_rv( 'up', 8 ); ?> data-tilt>
					<h2 class="kt"><?php echo dl_t( dl_s( $settings, 'facts_t' ) ); ?></h2>
					<dl>
						<?php foreach ( $facts as $f ) : ?>
							<div>
								<dt><?php echo dl_t( dl_s( $f, 'k' ) ); ?></dt>
								<dd><?php echo dl_t( dl_s( $f, 'v' ) ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
					<a href="<?php echo esc_url( $c['booking'] ?? '' ); ?>" target="_blank" rel="noopener" class="cta cta-light" data-mag><span><?php echo dl_t( dl_s( $settings, 'facts_cta', 'Prendre rendez-vous' ) ); ?></span><?php echo $ar; ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
