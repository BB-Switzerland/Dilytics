<?php
$c  = dl_contact();
$ar = dl_ar();
?>
<section<?php dl_root( $module, array( 'band', 'start', 'v-home-start' ) ); ?>>
	<div class="band-lead">
		<header class="hd">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_h( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="body"<?php echo dl_rv( 'up', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>
		</header>

		<div class="track">
			<div class="line"><span class="fill"></span></div>
			<ol>
				<?php foreach ( dl_items( dl_s( $settings, 'steps', array() ) ) as $s ) : ?>
					<li class="st">
						<h3 class="t1"><?php echo dl_t( dl_s( $s, 't' ) ); ?></h3>
						<p class="sm"><?php echo dl_t( dl_s( $s, 'd' ) ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>

		<div class="foot"<?php echo dl_rv( 'up' ); ?>>
			<a href="<?php echo esc_url( $c['booking'] ?? '' ); ?>" target="_blank" rel="noopener" class="cta cta-ink" data-mag><span><?php echo dl_t( dl_s( $settings, 'label' ) ); ?></span><?php echo $ar; ?></a>
			<a href="<?php echo esc_attr( $c['phoneHref'] ?? '' ); ?>" class="lnk tel"><?php echo esc_html( $c['phone'] ?? '' ); ?><?php echo $ar; ?></a>
		</div>
	</div>
</section>
