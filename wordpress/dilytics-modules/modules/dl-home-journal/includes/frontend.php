<?php
$to   = esc_url( dl_url( dl_s( $settings, 'to' ) ) );
$all  = dl_items( dl_s( $settings, 'articles', array() ) );
$lead = array_shift( $all );
?>
<section<?php dl_root( $module, array( 'band', 'v-home-journal' ) ); ?>>
	<div class="band-lead">
		<header class="jhd">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<a href="<?php echo $to; ?>" class="lnk"<?php echo dl_rv( 'up', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'all' ) ); ?><?php echo dl_ar(); ?></a>
		</header>

		<div class="g">
			<?php if ( $lead ) : ?>
				<a href="<?php echo $to; ?>" class="lead"<?php echo dl_rv( 'up' ); ?>>
					<div class="shot lp"><img src="<?php echo esc_url( dl_photo( $lead, 'img' ) ); ?>" alt="" data-px="18"></div>
					<div class="lt">
						<h3 class="d3"><?php echo dl_t( dl_s( $lead, 'title' ) ); ?></h3>
						<p class="body"><?php echo dl_t( dl_s( $lead, 'excerpt' ) ); ?></p>
						<p class="xs meta"><?php echo dl_t( dl_s( $lead, 'date' ) ); ?></p>
					</div>
				</a>
			<?php endif; ?>

			<div class="side">
				<?php foreach ( $all as $i => $a ) : ?>
					<a href="<?php echo $to; ?>" class="row"<?php echo dl_rv( 'up', 8 + $i * 7 ); ?>>
						<div class="shot rp"><img src="<?php echo esc_url( dl_photo( $a, 'img' ) ); ?>" alt="" data-px="12"></div>
						<div>
							<h3 class="t2"><?php echo dl_t( dl_s( $a, 'title' ) ); ?></h3>
							<p class="xs meta"><?php echo dl_t( dl_s( $a, 'date' ) ); ?></p>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
