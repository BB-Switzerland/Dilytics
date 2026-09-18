<section<?php dl_root( $module, array( 'band', 'v-home-benefits' ) ); ?>>
	<div class="band-lead">
		<header class="hd">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_h( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="body"<?php echo dl_rv( 'up', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>
		</header>

		<ul data-stagger>
			<?php foreach ( dl_items( dl_s( $settings, 'items', array() ) ) as $x ) : ?>
				<li>
					<span class="bi"><?php echo dl_ico( dl_s( $x, 'ico' ) ); ?></span>
					<h3 class="t1"><?php echo dl_t( dl_s( $x, 't' ) ); ?></h3>
					<p class="sm"><?php echo dl_t( dl_s( $x, 'd' ) ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
