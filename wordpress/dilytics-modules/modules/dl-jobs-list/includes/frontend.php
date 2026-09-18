<?php
$c      = dl_contact();
$ar     = dl_ar();
$offers = dl_items( dl_s( $settings, 'offers', array() ) );
?>
<section<?php dl_root( $module, array( 'bay', 'v-offres-demploi' ) ); ?>>
	<div class="wrap">
		<h2 class="d2 hd"<?php echo dl_rv( 'up' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>

		<?php if ( ! $offers ) : ?>
			<p class="body none"<?php echo dl_rv( 'up', 6 ); ?>><?php echo dl_t( dl_s( $settings, 'none' ) ); ?></p>
		<?php else : ?>
			<ul class="of">
				<?php foreach ( $offers as $i => $o ) : ?>
					<?php
					// the subject encoded as encodeURIComponent does on the Nuxt site
					$subject = str_replace( '{poste}', $o->t ?? '', dl_s( $settings, 'subject' ) );
					$subject = strtr(
						rawurlencode( $subject ),
						array(
							'%21' => '!',
							'%2A' => '*',
							'%27' => "'",
							'%28' => '(',
							'%29' => ')',
						)
					);
					?>
					<li<?php echo dl_rv( 'up', $i ? $i * 7 : null ); ?>>
						<div class="oi">
							<h3 class="t1"><?php echo dl_t( $o->t ?? '' ); ?></h3>
							<p class="sm"><?php echo dl_t( $o->d ?? '' ); ?></p>
						</div>
						<span class="xs"><?php echo dl_t( $o->p ?? '' ); ?></span>
						<span class="xs"><?php echo dl_t( $o->l ?? '' ); ?></span>
						<a href="<?php echo esc_attr( 'mailto:' . ( $c['mail'] ?? '' ) . '?subject=' . $subject ); ?>" class="cta cta-line cta-sm">
							<span><?php echo dl_t( dl_s( $settings, 'apply' ) ); ?></span><?php echo $ar; ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
