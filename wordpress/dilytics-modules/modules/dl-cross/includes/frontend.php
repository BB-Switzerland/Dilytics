<?php
$ar    = dl_ar();
$visit = dl_s( $settings, 'visit', 'Visiter la page' );
?>
<section<?php dl_root( $module, array( 'xs-sec', 'v-cross-sell' ) ); ?>>
	<div class="band-lead">
		<h2 class="d3 hd"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>

		<div class="grid">
			<?php foreach ( dl_items( $settings->items ?? array() ) as $i => $s ) : ?>
				<a href="<?php echo esc_url( dl_url( dl_s( $s, 'to' ) ) ); ?>" class="card surf surf-h"<?php echo dl_rv( 'up', $i ? $i * 5 : null ); ?>>
					<div class="shot pic"><img src="<?php echo esc_url( dl_photo( $s, 'img' ) ); ?>" alt=""><?php echo dl_photo_note( dl_img_name( dl_s( $s, 'img' ) ), array( 'compact' => true ) ); ?></div>
					<div class="in">
						<h3 class="t1"><?php echo dl_t( dl_s( $s, 't' ) ); ?></h3>
						<p class="sm"><?php echo dl_t( dl_s( $s, 'd' ) ); ?></p>
						<span class="visit"><?php echo dl_t( $visit ); ?><?php echo $ar; ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
