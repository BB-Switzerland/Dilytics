<section<?php dl_root( $module, array( 'band', 'v-category-page' ) ); ?>>
	<div class="band-lead cov">
		<div class="cov-l">
			<h2 class="d3"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<a href="<?php echo esc_url( dl_url( dl_s( $settings, 'to' ) ) ); ?>" class="lnk cl"<?php echo dl_rv( 'up', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'label' ) ); ?><?php echo dl_ar(); ?></a>
		</div>

		<ul class="cov-r">
			<?php foreach ( dl_lines( dl_s( $settings, 'bullets' ) ) as $i => $b ) : ?>
				<li<?php echo dl_rv( 'up', $i ? $i * 5 : null ); ?>>
					<svg width="15" height="15" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2.5 7.5 5.5 10.5 11.5 4" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"></path></svg>
					<span><?php echo esc_html( $b ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
