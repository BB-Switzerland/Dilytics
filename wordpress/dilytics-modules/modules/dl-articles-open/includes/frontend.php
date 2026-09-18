<section<?php dl_root( $module, array( 'op', 'wrap', 'v-articles' ) ); ?>>
	<?php echo dl_crumb( dl_s( $settings, 'crumb' ) ); ?>
	<div class="og">
		<?php echo dl_head3( dl_lines( dl_s( $settings, 'lines' ) ), array( 'accent' => (int) dl_s( $settings, 'accent', -1 ) ) ); ?>
		<p class="body"<?php echo dl_rv( 'up', 16 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>
	</div>

	<a href="<?php echo esc_url( dl_url( dl_s( $settings, 'to' ) ) ); ?>" class="lead"<?php echo dl_rv( 'up', 12 ); ?>>
		<div class="shot lp"><img src="<?php echo esc_url( dl_photo( $settings, 'img' ) ); ?>" alt=""></div>
		<div class="lt">
			<h2 class="d3"><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="body"><?php echo dl_t( dl_s( $settings, 'excerpt' ) ); ?></p>
			<span class="xs mt"><?php echo dl_t( dl_s( $settings, 'date' ) ); ?></span>
		</div>
	</a>
</section>
