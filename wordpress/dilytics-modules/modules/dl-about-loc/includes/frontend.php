<?php
$c = dl_contact();
?>
<section<?php dl_root( $module, array( 'loc', 'v-a-propos' ) ); ?>>
	<div class="band-lead">
		<header class="lhd">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<p class="body"<?php echo dl_rv( 'up', 8 ); ?>><?php echo esc_html( ( $c['building'] ?? '' ) . ', ' . ( $c['street'] ?? '' ) . ', ' . ( $c['city'] ?? '' ) . '.' ); ?></p>
		</header>
		<ul class="lgrid" data-stagger>
			<?php foreach ( dl_items( dl_s( $settings, 'slots', array() ) ) as $s ) : ?>
				<li><?php echo dl_pending( dl_s( $settings, 'label' ), $s->t ?? '', array( 'photo' => true ) ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
