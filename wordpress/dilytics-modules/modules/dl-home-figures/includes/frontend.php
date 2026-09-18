<section<?php dl_root( $module, array( 'cab', 'v-home-figures' ) ); ?>>
	<div class="band-lead">
		<div class="panel navy-panel"<?php echo dl_rv( 'up' ); ?>>
			<div class="left">
				<blockquote class="d2"><?php echo dl_h( dl_s( $settings, 'quote' ) ); ?></blockquote>
				<div class="who">
					<div class="shot av"><img src="<?php echo esc_url( dl_photo( $settings, 'img' ) ); ?>" alt=""></div>
					<div>
						<span class="t2"><?php echo dl_t( dl_s( $settings, 'name' ) ); ?></span>
						<span class="xs"><?php echo dl_t( dl_s( $settings, 'role' ) ); ?></span>
					</div>
				</div>
				<a href="<?php echo esc_url( dl_url( dl_s( $settings, 'to' ) ) ); ?>" class="cta cta-light"><span><?php echo dl_t( dl_s( $settings, 'label' ) ); ?></span><?php echo dl_ar(); ?></a>
			</div>

			<ul class="nums">
				<?php foreach ( dl_items( dl_s( $settings, 'stats', array() ) ) as $i => $s ) : ?>
					<li<?php echo dl_rv( 'up', $i ? $i * 6 : null ); ?>>
						<?php if ( '' !== dl_s( $s, 'pending' ) ) : ?>
							<?php echo dl_pending( dl_s( $s, 'pending' ), dl_s( $s, 'hint' ), array( 'dark' => true ) ); ?>
						<?php else : ?>
							<?php if ( '' !== dl_s( $s, 'text' ) ) : ?>
								<span class="fig n"><?php echo dl_t( dl_s( $s, 'text' ) ); ?></span>
							<?php else : ?>
								<span class="fig n"><?php echo dl_t( dl_s( $s, 'prefix' ) ); ?><?php echo dl_counter( dl_s( $s, 'n', 0 ) ); ?><?php echo dl_t( dl_s( $s, 'suffix' ) ); ?></span>
							<?php endif; ?>
							<p class="l"><?php echo dl_t( dl_s( $s, 'label' ) ); ?></p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
