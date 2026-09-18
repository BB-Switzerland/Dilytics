<section<?php dl_root( $module, array( 'bay-s', 'v-articles' ) ); ?>>
	<div class="wrap">
		<div class="grid">
			<?php foreach ( dl_items( dl_s( $settings, 'items', array() ) ) as $i => $a ) : ?>
				<a href="<?php echo esc_url( dl_url( $a->to ?? '' ) ); ?>" class="a"<?php echo dl_rv( 'up', $i ? $i * 8 : null ); ?>>
					<div class="shot pic"><img src="<?php echo esc_url( dl_photo( $a, 'img' ) ); ?>" alt=""></div>
					<h3 class="t1"><?php echo dl_t( $a->t ?? '' ); ?></h3>
					<p class="sm"><?php echo dl_t( $a->excerpt ?? '' ); ?></p>
					<span class="xs mt"><?php echo dl_t( $a->date ?? '' ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
