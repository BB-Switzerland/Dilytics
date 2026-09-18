<?php
$c  = dl_contact();
$ar = dl_ar();
?>
<section<?php dl_root( $module, array( 'open', 'v-category-page' ) ); ?>>
	<div class="band-lead">
		<?php
		echo dl_crumb(
			dl_s( $settings, 'crumb' ),
			null,
			array(
				'label'  => true,
				'hidden' => true,
				'here'   => 'here',
			)
		);
		?>
		<div class="og">
			<div class="ot">
				<h1 class="d1"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h1>
				<p class="pitch"<?php echo dl_rv( 'up', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'pitch' ) ); ?></p>
				<p class="body ld"<?php echo dl_rv( 'up', 14 ); ?>><?php echo dl_t( dl_s( $settings, 'lede' ) ); ?></p>
				<div class="acts"<?php echo dl_rv( 'up', 20 ); ?>>
					<a href="<?php echo esc_url( $c['booking'] ?? '' ); ?>" target="_blank" rel="noopener" class="cta cta-ink"><span><?php echo dl_t( dl_s( $settings, 'book' ) ); ?></span><?php echo $ar; ?></a>
					<a href="<?php echo esc_attr( $c['phoneHref'] ?? '' ); ?>" class="lnk tel"><?php echo esc_html( $c['phone'] ?? '' ); ?><?php echo $ar; ?></a>
				</div>
			</div>

			<div class="shot opic"<?php echo dl_rv( 'zoom', 6 ); ?>><img src="<?php echo esc_url( dl_photo( $settings, 'img' ) ); ?>" alt="<?php echo esc_attr( dl_s( $settings, 'alt' ) ); ?>" data-px="20"><?php echo dl_photo_note( dl_img_name( dl_s( $settings, 'img' ) ) ); ?></div>
		</div>

		<ul class="facts">
			<?php foreach ( dl_items( $settings->facts ?? array() ) as $i => $f ) : ?>
				<li<?php echo dl_rv( 'up', $i ? $i * 6 : null ); ?>>
					<span class="fig fv"><?php echo esc_html( $f->v ?? '' ); ?></span>
					<p class="fig-l"><?php echo esc_html( $f->k ?? '' ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
