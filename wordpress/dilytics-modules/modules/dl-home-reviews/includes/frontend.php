<?php
$slots = max( 0, (int) dl_s( $settings, 'slots', 0 ) );
?>
<section<?php dl_root( $module, array( 'band', 'v-home-reviews' ) ); ?>>
	<div class="band-lead">
		<h2 class="d2 hd"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>

		<div class="g">
			<?php foreach ( dl_items( dl_s( $settings, 'reviews', array() ) ) as $r ) : ?>
				<figure class="rv surf"<?php echo dl_rv( 'up' ); ?>>
					<blockquote><?php echo dl_t( dl_s( $r, 'quote' ) ); ?></blockquote>
					<figcaption>
						<span class="t2"><?php echo dl_t( dl_s( $r, 'name' ) ); ?></span>
						<span class="sm"><?php echo dl_t( dl_s( $r, 'role' ) . ', ' . dl_s( $r, 'company' ) ); ?></span>
					</figcaption>
				</figure>
			<?php endforeach; ?>

			<div class="slots">
				<?php
				for ( $n = 1; $n <= $slots; $n++ ) {
					echo dl_pending(
						dl_s( $settings, 'slot_label' ),
						dl_s( $settings, 'slot_hint' ),
						array(),
						array(
							'data-rv'  => 'up',
							'data-rvd' => (string) ( $n * 6 ),
						)
					);
				}
				?>
			</div>
		</div>

		<ul class="marks" data-stagger>
			<?php foreach ( dl_items( dl_s( $settings, 'marks', array() ) ) as $d ) : ?>
				<?php $src = dl_photo( $d, 'img' ); ?>
				<li>
					<span class="top">
						<?php if ( $src ) : ?>
							<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( dl_s( $d, 'alt' ) ); ?>" class="lg">
						<?php else : ?>
							<span class="fig mv"><?php echo dl_t( dl_s( $d, 'v' ) ); ?></span>
						<?php endif; ?>
					</span>
					<span class="sm"><?php echo dl_t( dl_s( $d, 't' ) ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
