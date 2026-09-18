<?php
$rows = dl_items( $settings->rows ?? array() );
?>
<section<?php dl_root( $module, array( 'band', 'v-category-page' ) ); ?>>
	<div class="band-lead">
		<header class="hd">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_h( str_replace( '{n}', (string) count( $rows ), dl_s( $settings, 'title' ) ) ); ?></h2>
			<p class="body"<?php echo dl_rv( 'up', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>
		</header>

		<?php echo dl_service_list( $rows ); ?>
	</div>
</section>
