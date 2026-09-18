<?php
$ar    = dl_ar();
$title = dl_s( $settings, 'title' );
$ptab  = dl_s( $settings, 'parent_t' );
?>
<section<?php dl_root( $module, array( 'hero', 'v-slug' ) ); ?>>
	<div class="band-lead">
		<?php
		echo dl_crumb(
			$title,
			$ptab ? array(
				'label' => $ptab,
				'to'    => dl_s( $settings, 'parent_to' ),
			) : null,
			array(
				'label'  => true,
				'hidden' => true,
				'here'   => 'here',
			)
		);
		?>

		<div class="hg">
			<div>
				<h1 class="d1"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( $title ); ?></h1>
				<p class="tag"<?php echo dl_rv( 'up', 8 ); ?>><?php echo dl_t( dl_s( $settings, 'tagline' ) ); ?></p>
				<p class="body ld"<?php echo dl_rv( 'up', 12 ); ?>><?php echo dl_t( dl_s( $settings, 'intro' ) ); ?></p>
				<div class="acts"<?php echo dl_rv( 'up', 18 ); ?>>
					<a href="<?php echo esc_url( dl_contact( 'booking' ) ); ?>" target="_blank" rel="noopener" class="cta cta-ink" data-mag><span><?php echo dl_t( dl_s( $settings, 'book', 'Réserver un entretien' ) ); ?></span><?php echo $ar; ?></a>
					<a href="<?php echo esc_url( dl_url( '/contact/' ) ); ?>" class="lnk tel"><?php echo dl_t( dl_s( $settings, 'write', 'Nous écrire' ) ); ?><?php echo $ar; ?></a>
				</div>
			</div>

			<div class="shot hpic"<?php echo dl_rv( 'zoom', 6 ); ?>>
				<img src="<?php echo esc_url( dl_photo( $settings, 'img' ) ); ?>" alt="<?php echo esc_attr( dl_s( $settings, 'alt', $title ) ); ?>" data-px="16"><?php echo dl_photo_note( dl_img_name( dl_s( $settings, 'img' ) ) ); ?>
			</div>
		</div>
	</div>
</section>
