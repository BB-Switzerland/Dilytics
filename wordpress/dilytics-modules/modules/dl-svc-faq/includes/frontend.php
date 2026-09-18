<section<?php dl_root( $module, array( 'tint', 'v-slug' ) ); ?>>
	<div class="band-lead fwrap">
		<div class="fhd">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="sm"<?php echo dl_rv( 'text', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>
			<a href="<?php echo esc_attr( dl_contact( 'phoneHref' ) ); ?>" class="fph"<?php echo dl_rv( 'text', 12 ); ?>><?php echo esc_html( dl_contact( 'phone' ) ); ?></a>
		</div>
		<div class="faq" data-stagger>
			<?php foreach ( dl_items( $settings->items ?? array() ) as $i => $f ) : ?>
				<div class="q surf<?php echo 0 === $i ? ' on' : ''; ?>">
					<button aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>"><span class="t2"><?php echo dl_t( dl_s( $f, 't' ) ); ?></span><i aria-hidden="true"></i></button>
					<div class="a"><div><p class="sm"><?php echo dl_t( dl_s( $f, 'd' ) ); ?></p></div></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
