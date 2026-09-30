<?php
// four reviews to a slide, the first of the four large (HomeReviews.vue)
$slides = array_chunk( dl_items( dl_s( $settings, 'reviews', array() ) ), 4 );
$ar     = dl_ar();
?>
<section<?php dl_root( $module, array( 'band', 'v-home-reviews' ) ); ?>>
	<div class="band-lead">
		<div class="top-r">
			<h2 class="d2"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
			<div class="ctl">
				<button type="button" class="prev" aria-label="Avis précédents" disabled><?php echo $ar; ?></button>
				<span class="sm ct" aria-live="polite">1 / <?php echo count( $slides ); ?></span>
				<button type="button" class="next" aria-label="Avis suivants"<?php echo count( $slides ) > 1 ? '' : ' disabled'; ?>><?php echo $ar; ?></button>
			</div>
		</div>

		<div class="track" tabindex="0" aria-label="Avis clients" data-lenis-prevent-horizontal<?php echo dl_rv( 'up' ); ?>>
			<?php foreach ( $slides as $s ) : ?>
				<div class="slide n<?php echo count( $s ); ?>">
					<?php foreach ( $s as $i => $r ) : ?>
						<?php
						$sub  = implode( ', ', array_filter( array( dl_s( $r, 'role' ), dl_s( $r, 'company' ) ) ) );
						$logo = dl_photo( $r, 'logo' );
						?>
						<figure class="rv surf<?php echo $i ? '' : ' big'; ?>">
							<blockquote><?php echo dl_t( dl_s( $r, 'quote' ) ); ?></blockquote>
							<figcaption>
								<span class="who">
									<span class="t2"><?php echo dl_t( dl_s( $r, 'name' ) ); ?></span>
									<?php if ( $sub ) : ?>
										<span class="sm"><?php echo dl_t( $sub ); ?></span>
									<?php endif; ?>
								</span>
								<?php if ( $logo ) : ?>
									<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( dl_s( $r, 'logo_alt' ) ); ?>" class="org" loading="lazy">
								<?php endif; ?>
							</figcaption>
						</figure>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<h3 class="d3 pth"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'pt_title' ) ); ?></h3>
		<ul class="logos" data-stagger>
			<?php foreach ( dl_items( dl_s( $settings, 'partners', array() ) ) as $p ) : ?>
				<?php $src = dl_photo( $p, 'img' ); ?>
				<li>
					<?php if ( $src ) : ?>
						<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( dl_s( $p, 'name' ) ); ?>" loading="lazy">
					<?php else : ?>
						<span class="t2"><?php echo dl_t( dl_s( $p, 'name' ) ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>

		<ul class="marks" data-stagger>
			<?php foreach ( dl_items( dl_s( $settings, 'marks', array() ) ) as $d ) : ?>
				<?php $src = dl_photo( $d, 'img' ); ?>
				<li>
					<span class="top">
						<?php if ( $src ) : ?>
							<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( dl_s( $d, 'alt' ) ); ?>" class="lg">
						<?php else : ?>
							<span class="fig mv"><?php echo dl_t( dl_s( $d, 'v' ) ); ?></span>
						<?php endif; ?>
					</span>
					<span class="sm"><?php echo dl_t( dl_s( $d, 't' ) ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
