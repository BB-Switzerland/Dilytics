<section<?php dl_root( $module, array( 'pb', 'v-offres-demploi' ) ); ?>>
	<div class="wrap">
		<h2 class="d3 ph"><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
		<ul class="pk">
			<?php foreach ( dl_items( dl_s( $settings, 'items', array() ) ) as $i => $p ) : ?>
				<li<?php echo dl_rv( 'up', $i ? $i * 6 : null ); ?>>
					<h3 class="t2"><?php echo dl_t( $p->t ?? '' ); ?></h3>
					<p class="sm"><?php echo dl_t( $p->d ?? '' ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
