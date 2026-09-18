<section<?php dl_root( $module, array( 'hist', 'v-a-propos' ) ); ?>>
	<div class="band-lead">
		<header class="hhd">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="body"<?php echo dl_rv( 'up', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>
		</header>

		<div class="eras" data-stagger>
			<?php foreach ( dl_items( dl_s( $settings, 'eras', array() ) ) as $e ) : ?>
				<article>
					<span class="ey fig"><?php echo dl_t( $e->y ?? '' ); ?></span>
					<h3 class="d3"><?php echo dl_t( $e->t ?? '' ); ?></h3>
					<?php foreach ( dl_paras( $e->p ?? '' ) as $par ) : ?>
						<p class="prose"><?php echo dl_t( $par ); ?></p>
					<?php endforeach; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
