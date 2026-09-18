<?php
$items = dl_items( $settings->items ?? array() );
// named parts with a description sit three abreast under the heading
$rich = $items && '' !== (string) dl_s( $items[0], 't' );
?>
<section<?php dl_root( $module, array( 'tint', 'v-slug' ) ); ?>>
	<div class="band-lead lwrap<?php echo $rich ? ' rich' : ''; ?>">
		<h2 class="d2 lhd"<?php echo dl_rv( 'mask' ); ?>><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h2>
		<ul class="lst" data-stagger>
			<?php foreach ( $items as $it ) : ?>
				<li>
					<span class="lk"><?php echo dl_ico( 'check' ); ?></span>
					<?php if ( '' !== (string) dl_s( $it, 't' ) ) : ?>
						<span><span class="lit"><?php echo dl_t( dl_s( $it, 't' ) ); ?></span><span class="lid"><?php echo dl_t( dl_s( $it, 'd' ) ); ?></span></span>
					<?php else : ?>
						<span><?php echo dl_t( dl_s( $it, 'd' ) ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
