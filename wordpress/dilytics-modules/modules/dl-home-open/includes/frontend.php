<?php
$c     = dl_contact();
$ar    = dl_ar();
$years = (string) dl_years();
?>
<section<?php dl_root( $module, array( 'hero', 'v-home-open' ) ); ?>>
	<div class="bg">
		<img src="<?php echo esc_url( dl_photo( $settings, 'img' ) ); ?>" alt="">
	</div>
	<div class="scrim" aria-hidden="true"></div>
	<?php
	echo dl_photo_note(
		dl_img_name( dl_s( $settings, 'img' ) ),
		array(
			'at'    => 'hero',
			'frame' => false,
		)
	);
	?>

	<div class="inner wrap">
		<?php
		echo dl_head3(
			dl_lines( dl_s( $settings, 'lines' ) ),
			array(
				'cls'    => 'd1 hh',
				'accent' => (int) dl_s( $settings, 'accent', -1 ),
				'delay'  => 0.38,
			)
		);
		?>

		<p class="body ld"><?php echo dl_t( str_replace( '{since}', (string) ( $c['since'] ?? '' ), dl_s( $settings, 'intro' ) ) ); ?></p>

		<div class="acts">
			<a href="<?php echo esc_url( $c['booking'] ?? '' ); ?>" target="_blank" rel="noopener" class="cta cta-red" data-mag><span><?php echo dl_t( dl_s( $settings, 'label' ) ); ?></span><?php echo $ar; ?></a>
			<a href="<?php echo esc_attr( $c['phoneHref'] ?? '' ); ?>" class="lnk tel"><?php echo esc_html( $c['phone'] ?? '' ); ?><?php echo $ar; ?></a>
		</div>
	</div>

	<div class="foot wrap">
		<span class="rule-top" aria-hidden="true"></span>
		<ul class="strip">
			<?php foreach ( dl_items( dl_s( $settings, 'strip', array() ) ) as $s ) : ?>
				<li><span class="sv num"><?php echo dl_t( str_replace( '{years}', $years, dl_s( $s, 'v' ) ) ); ?></span><span class="sl"><?php echo dl_t( dl_s( $s, 'l' ) ); ?></span></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
