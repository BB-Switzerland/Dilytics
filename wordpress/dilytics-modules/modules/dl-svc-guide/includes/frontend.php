<?php
$secs = dl_items( $settings->secs ?? array() );
$pic  = dl_photo( $settings, 'img' );
// a photograph breaks the reading column after the first part, on guides
// long enough to need something to look at
$after = count( $secs ) > 2 && $pic ? 0 : -1;
?>
<section<?php dl_root( $module, array( 'guide', 'v-slug' ) ); ?>>
	<div class="gwrap">
		<aside class="rail">
			<div class="stick">
				<p class="rt"><?php echo dl_t( dl_s( $settings, 'rail_t', 'Sommaire' ) ); ?></p>
				<nav aria-label="<?php echo esc_attr( dl_s( $settings, 'rail_t', 'Sommaire' ) ); ?>">
					<?php foreach ( $secs as $i => $sec ) : ?>
						<a href="#sec-<?php echo (int) $i; ?>"<?php echo 0 === $i ? ' class="on"' : ''; ?>><?php echo dl_t( dl_s( $sec, 't' ) ); ?></a>
					<?php endforeach; ?>
				</nav>

				<div class="ask">
					<p class="xs"><?php echo dl_t( dl_s( $settings, 'ask' ) ); ?></p>
					<a href="<?php echo esc_attr( dl_contact( 'phoneHref' ) ); ?>" class="ph"><?php echo esc_html( dl_contact( 'phone' ) ); ?></a>
				</div>
			</div>
		</aside>

		<div class="doc">
			<?php foreach ( $secs as $i => $sec ) : ?>
				<section id="sec-<?php echo (int) $i; ?>" class="sec">
					<h2 class="sh"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $sec, 't' ) ); ?></h2>
					<?php foreach ( dl_paras( dl_s( $sec, 'p' ) ) as $j => $par ) : ?>
						<p class="p"<?php echo dl_rv( 'text', $j ? $j * 4 : null ); ?>><?php echo dl_t( $par ); ?></p>
					<?php endforeach; ?>
				</section>

				<?php if ( $i === $after ) : ?>
					<figure class="brk"<?php echo dl_rv( 'zoom' ); ?>>
						<div class="shot fpic">
							<img src="<?php echo esc_url( $pic ); ?>" alt="<?php echo esc_attr( dl_s( $settings, 'alt' ) ); ?>" data-px="18"><?php echo dl_photo_note( dl_img_name( dl_s( $settings, 'img' ) ) ); ?>
						</div>
					</figure>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
