<section<?php dl_root( $module, array( 'ben', 'v-slug' ) ); ?>>
	<div class="band-lead">
		<ul data-stagger>
			<?php foreach ( dl_items( $settings->items ?? array() ) as $x ) : ?>
				<li>
					<span class="bi"><?php echo dl_ico( dl_s( $x, 'ico', 'check' ) ); ?></span>
					<h2 class="t1"><?php echo dl_t( dl_s( $x, 't' ) ); ?></h2>
					<p class="sm"><?php echo dl_t( dl_s( $x, 'd' ) ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
