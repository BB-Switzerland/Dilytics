<section<?php dl_root( $module, array( 'marks', 'v-a-propos' ) ); ?>>
	<div class="band-lead">
		<ul data-stagger>
			<?php foreach ( dl_items( dl_s( $settings, 'items', array() ) ) as $m ) : ?>
				<li>
					<span class="mv fig"><?php echo dl_t( $m->v ?? '' ); ?></span>
					<div class="mt">
						<h2 class="t1"><?php echo dl_t( $m->t ?? '' ); ?></h2>
						<p class="sm"><?php echo dl_t( $m->d ?? '' ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
