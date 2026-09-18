<section<?php dl_root( $module, array( 'op', 'wrap', 'v-offres-demploi' ) ); ?>>
	<?php echo dl_crumb( dl_s( $settings, 'crumb' ) ); ?>
	<div class="og">
		<div>
			<?php echo dl_head3( dl_lines( dl_s( $settings, 'lines' ) ), array( 'accent' => (int) dl_s( $settings, 'accent', -1 ) ) ); ?>
			<p class="body ld"<?php echo dl_rv( 'up', 22 ); ?>><?php echo dl_t( dl_s( $settings, 'intro' ) ); ?></p>
		</div>
		<div class="shot opic"<?php echo dl_rv( 'zoom', 6 ); ?>><img src="<?php echo esc_url( dl_photo( $settings, 'img' ) ); ?>" alt="<?php echo esc_attr( dl_s( $settings, 'alt' ) ); ?>"><?php echo dl_photo_note( dl_img_name( dl_s( $settings, 'img' ) ) ); ?></div>
	</div>
</section>
