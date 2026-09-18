<section<?php dl_root( $module, array( 'op', 'v-a-propos' ) ); ?>>
	<div class="band-lead">
		<?php echo dl_crumb( dl_s( $settings, 'crumb' ), null, array( 'hidden' => true ) ); ?>
		<h1 class="huge"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h1>
		<div class="intro">
			<?php foreach ( dl_paras( dl_s( $settings, 'intro' ) ) as $i => $p ) : ?>
				<p class="body"<?php echo dl_rv( 'up', 10 + 6 * $i ); ?>><?php echo dl_t( $p ); ?></p>
			<?php endforeach; ?>
		</div>
	</div>

	<figure class="bleed"<?php echo dl_rv( 'zoom' ); ?>>
		<img src="<?php echo esc_url( dl_photo( $settings, 'img' ) ); ?>" alt="<?php echo esc_attr( dl_s( $settings, 'alt' ) ); ?>">
	</figure>
</section>
