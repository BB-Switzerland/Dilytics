<section<?php dl_root( $module, array( 'band', 'v-home-demand' ), array( 'id' => 'prestations' ) ); ?>>
	<div class="band-lead">
		<header class="hd">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_h( dl_s( $settings, 'title' ) ); ?></h2>
			<a href="<?php echo esc_url( dl_url( dl_s( $settings, 'to' ) ) ); ?>" class="lnk all"<?php echo dl_rv( 'up', 10 ); ?>><?php echo dl_t( dl_s( $settings, 'all' ) ); ?><?php echo dl_ar(); ?></a>
		</header>

		<?php echo dl_service_list( dl_items( dl_s( $settings, 'rows', array() ) ) ); ?>
	</div>
</section>
