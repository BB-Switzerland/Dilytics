<?php
$c  = dl_contact();
$ar = dl_ar();
?>
<section<?php dl_root( $module, array( 'band', 'v-category-page' ) ); ?>>
	<div class="band-lead note">
		<div class="shot npic"<?php echo dl_rv( 'zoom' ); ?>><img src="<?php echo esc_url( dl_photo( $settings, 'img' ) ); ?>" alt="" data-px="16"><?php echo dl_photo_note( dl_img_name( dl_s( $settings, 'img' ) ) ); ?></div>
		<div class="ntxt">
			<h2 class="d3"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="body"<?php echo dl_rv( 'up', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>
			<div class="nacts"<?php echo dl_rv( 'up', 12 ); ?>>
				<a href="<?php echo esc_url( $c['booking'] ?? '' ); ?>" target="_blank" rel="noopener" class="cta cta-red"><span><?php echo dl_t( dl_s( $settings, 'book' ) ); ?></span><?php echo $ar; ?></a>
				<a href="<?php echo esc_attr( $c['phoneHref'] ?? '' ); ?>" class="lnk"><?php echo esc_html( $c['phone'] ?? '' ); ?><?php echo $ar; ?></a>
			</div>
		</div>
	</div>
</section>
