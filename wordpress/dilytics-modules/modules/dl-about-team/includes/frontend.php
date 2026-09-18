<?php
$ar = dl_ar();
?>
<section<?php dl_root( $module, array( 'team', 'v-a-propos' ) ); ?>>
	<div class="band-lead">
		<header class="thd">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="body"<?php echo dl_rv( 'up', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>
		</header>

		<ul class="people">
			<?php foreach ( dl_items( dl_s( $settings, 'people', array() ) ) as $p ) : ?>
				<li<?php echo dl_rv( 'up' ); ?>>
					<div class="shot por"><img src="<?php echo esc_url( dl_photo( $p, 'img' ) ); ?>" alt="<?php echo esc_attr( $p->name ?? '' ); ?>" data-px="12"></div>
					<div class="say">
						<blockquote class="q"><?php echo dl_t( $p->quote ?? '' ); ?></blockquote>
						<div class="who">
							<span class="t2 nm"><?php echo dl_t( $p->name ?? '' ); ?></span>
							<span class="xs rl"><?php echo dl_t( $p->role ?? '' ); ?></span>
							<span class="xs cr"><?php echo dl_t( $p->diploma ?? '' ); ?></span>
							<span class="xs cr"><?php echo dl_t( $p->langs ?? '' ); ?></span>
							<?php if ( ! empty( $p->linkedin ) ) : ?>
								<a href="<?php echo esc_url( $p->linkedin ); ?>" target="_blank" rel="noopener" class="lnk li">LinkedIn<?php echo $ar; ?></a>
							<?php endif; ?>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php if ( dl_s( $settings, 'jobs_to' ) ) : ?>
			<a href="<?php echo esc_url( dl_url( dl_s( $settings, 'jobs_to' ) ) ); ?>" class="lnk jobs"<?php echo dl_rv( 'up' ); ?>><?php echo dl_t( dl_s( $settings, 'jobs_label' ) ); ?><?php echo $ar; ?></a>
		<?php endif; ?>
	</div>
</section>
