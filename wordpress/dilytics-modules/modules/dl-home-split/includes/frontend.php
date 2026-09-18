<section<?php dl_root( $module, array( 'band', 'split', 'v-home-split' ) ); ?>>
	<div class="g">
		<div class="art"<?php echo dl_rv( 'up' ); ?>>
			<div class="shot big"><img src="<?php echo esc_url( dl_photo( $settings, 'img' ) ); ?>" alt="" data-px="20"></div>
			<div class="surf badge">
				<img src="<?php echo esc_url( dl_photo( $settings, 'badge' ) ); ?>" alt="<?php echo esc_attr( dl_s( $settings, 'badge_alt' ) ); ?>" class="bx">
				<p class="fig-l k"><?php echo dl_h( dl_s( $settings, 'badge_t' ) ); ?></p>
			</div>
		</div>

		<div class="txt">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_h( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="body ld"<?php echo dl_rv( 'up', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>

			<ul class="pts">
				<?php foreach ( dl_items( dl_s( $settings, 'points', array() ) ) as $i => $p ) : ?>
					<li<?php echo dl_rv( 'up', 14 + $i * 7 ); ?>>
						<h3 class="t2"><?php echo dl_t( dl_s( $p, 't' ) ); ?></h3>
						<p class="sm"><?php echo dl_t( dl_s( $p, 'd' ) ); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
