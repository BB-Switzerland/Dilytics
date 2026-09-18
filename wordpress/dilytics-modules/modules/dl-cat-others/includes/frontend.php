<?php
$ar   = dl_ar();
$more = dl_s( $settings, 'more' );
?>
<section<?php dl_root( $module, array( 'band', 'v-category-page' ) ); ?>>
	<div class="band-lead">
		<h2 class="d3 ohd"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
		<div class="others">
			<?php foreach ( dl_items( $settings->cards ?? array() ) as $i => $o ) : ?>
				<a href="<?php echo esc_url( dl_url( $o->to ?? '' ) ); ?>" class="oc surf surf-h"<?php echo dl_rv( 'up', $i ? $i * 6 : null ); ?>>
					<div class="shot opic2"><img src="<?php echo esc_url( dl_photo( $o, 'img' ) ); ?>" alt=""><?php echo dl_photo_note( dl_img_name( dl_s( $o, 'img' ) ), array( 'compact' => true ) ); ?></div>
					<div class="oin">
						<h3 class="t1"><?php echo esc_html( $o->t ?? '' ); ?></h3>
						<p class="sm"><?php echo esc_html( $o->d ?? '' ); ?></p>
						<span class="ogo"><?php echo dl_t( $more ); ?><?php echo $ar; ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
