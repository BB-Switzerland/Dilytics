<section<?php dl_root( $module, array( 'phi', 'v-a-propos' ) ); ?>>
	<div class="band-lead pwrap">
		<div class="pstick">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="sm"<?php echo dl_rv( 'text', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>
		</div>

		<ol class="vals" data-stagger>
			<?php foreach ( dl_items( dl_s( $settings, 'values', array() ) ) as $v ) : ?>
				<li>
					<h3 class="vt"><?php echo dl_t( $v->t ?? '' ); ?></h3>
					<p class="body"><?php echo dl_t( $v->d ?? '' ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
