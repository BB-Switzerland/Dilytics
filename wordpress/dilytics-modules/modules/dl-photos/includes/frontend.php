<?php
// The registry as the Nuxt page reads it: every listed picture, grouped by
// priority, and the slots that have no picture yet.
$reg      = dl_photos();
$expected = array_values( (array) ( $reg['EXPECTED'] ?? array() ) );
$list     = array();
foreach ( (array) ( $reg['PHOTOS'] ?? array() ) as $pid => $p ) {
	$list[] = array_merge( (array) $p, array( 'id' => (string) $pid ) );
}
$total = count( $list ) + count( $expected );
$scope = 'v-photos-a-fournir';
?>
<div<?php dl_root( $module, array() ); ?>>
	<section class="op band-lead <?php echo esc_attr( $scope ); ?>">
		<h1 class="d1"><?php echo dl_t( dl_s( $settings, 'title' ) ); ?></h1>
		<p class="body ld"><?php echo dl_t( str_replace( '{total}', (string) $total, dl_s( $settings, 'intro' ) ) ); ?></p>
	</section>

	<section class="grp band-lead <?php echo esc_attr( $scope ); ?>">
		<header class="gh">
			<h2 class="d3"><?php echo dl_t( dl_s( $settings, 'new_t' ) ); ?> <span class="ct"><?php echo count( $expected ); ?></span></h2>
			<p class="sm"><?php echo dl_t( dl_s( $settings, 'new_d' ) ); ?></p>
		</header>
		<ul class="rows">
			<?php foreach ( $expected as $e ) : ?>
				<li>
					<?php echo dl_pending( dl_s( $settings, 'new_label' ), '', array( 'photo' => true ) ); ?>
					<div>
						<p class="t2"><?php echo esc_html( $e['brief'] ?? '' ); ?></p>
						<p class="xs wh"><?php echo esc_html( implode( ' · ', (array) ( $e['where'] ?? array() ) ) ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>

	<?php foreach ( dl_items( dl_s( $settings, 'groups', array() ) ) as $g ) : ?>
		<?php
		$prio  = (int) ( $g->prio ?? 0 );
		$items = array_values(
			array_filter(
				$list,
				function ( $p ) use ( $prio ) {
					return (int) ( $p['prio'] ?? 0 ) === $prio;
				}
			)
		);
		?>
		<section class="grp band-lead <?php echo esc_attr( $scope ); ?>">
			<header class="gh">
				<h2 class="d3"><?php echo dl_t( $g->t ?? '' ); ?> <span class="ct"><?php echo count( $items ); ?></span></h2>
				<p class="sm"><?php echo dl_t( $g->d ?? '' ); ?></p>
			</header>
			<ul class="rows">
				<?php foreach ( $items as $p ) : ?>
					<li>
						<div class="shot th"><img src="<?php echo esc_url( dl_img_url( dl_img_id( $p['id'] ) ) ); ?>" alt="" loading="lazy"></div>
						<div>
							<p class="t2"><?php echo esc_html( $p['brief'] ?? '' ); ?></p>
							<p class="xs wh"><?php echo esc_html( implode( ' · ', (array) ( $p['where'] ?? array() ) ) ); ?></p>
							<p class="xs wh"><?php echo dl_t( str_replace( '{file}', $p['id'] . '.webp', dl_s( $settings, 'file' ) ) ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endforeach; ?>
</div>
