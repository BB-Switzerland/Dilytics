<section<?php dl_root( $module, array( 'bex', 'v-a-propos' ) ); ?>>
	<div class="band-lead bwrap">
		<img src="<?php echo esc_url( dl_photo( $settings, 'img' ) ); ?>" alt="<?php echo esc_attr( dl_s( $settings, 'alt' ) ); ?>" class="bxb"<?php echo dl_rv( 'up' ); ?>>
		<div>
			<h2 class="d3 bt"<?php echo dl_rv( 'up', 6 ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="body bd"<?php echo dl_rv( 'up', 12 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>
		</div>
	</div>
</section>
