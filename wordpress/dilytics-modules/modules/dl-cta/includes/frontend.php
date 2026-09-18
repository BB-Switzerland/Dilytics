<?php
$c  = dl_contact();
$ar = dl_ar();
$to = dl_s( $settings, 'to' );
?>
<section<?php dl_root( $module, array( 'cn', 'v-site-cta' ) ); ?>>
	<div class="wrap grid">
		<div class="left">
			<?php
			echo dl_head3(
				dl_lines( dl_s( $settings, 'lines' ) ),
				array(
					'cls'    => 'd2',
					'as'     => 'h2',
					'accent' => 1,
					'mode'   => 'scroll',
				)
			);
			?>
			<p class="body"<?php echo dl_rv( 'up', 14 ); ?>><?php echo dl_t( dl_s( $settings, 'text' ) ); ?></p>

			<a href="<?php echo esc_attr( $c['phoneHref'] ?? '' ); ?>" class="phone d2"<?php echo dl_rv( 'up', 20 ); ?>><?php echo esc_html( $c['phone'] ?? '' ); ?></a>

			<div class="acts"<?php echo dl_rv( 'up', 26 ); ?>>
				<?php if ( $to ) : ?>
					<a href="<?php echo esc_url( dl_url( $to ) ); ?>" class="cta cta-red"><span><?php echo dl_t( dl_s( $settings, 'label' ) ); ?></span><?php echo $ar; ?></a>
				<?php else : ?>
					<a href="<?php echo esc_url( $c['booking'] ?? '' ); ?>" target="_blank" rel="noopener" class="cta cta-red"><span><?php echo dl_t( dl_s( $settings, 'label', 'Réserver un entretien' ) ); ?></span><?php echo $ar; ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_attr( 'mailto:' . ( $c['mail'] ?? '' ) ); ?>" class="cta cta-line"><span><?php echo esc_html( $c['mail'] ?? '' ); ?></span></a>
			</div>

			<dl class="meta"<?php echo dl_rv( 'up', 32 ); ?>>
				<div><dt class="xs">Adresse</dt><dd class="sm"><?php echo esc_html( ( $c['street'] ?? '' ) . ', ' . ( $c['city'] ?? '' ) ); ?></dd></div>
				<div><dt class="xs">Horaires</dt><dd class="sm"><?php echo esc_html( $c['hours'] ?? '' ); ?></dd></div>
			</dl>
		</div>

		<div class="right"<?php echo dl_rv( 'zoom', 6 ); ?>>
			<div class="shot pic"><img src="<?php echo esc_url( dl_photo( $settings, 'img' ) ); ?>" data-px="18" alt=""><?php echo dl_photo_note( dl_img_name( dl_s( $settings, 'img' ) ) ); ?></div>
		</div>
	</div>
</section>
