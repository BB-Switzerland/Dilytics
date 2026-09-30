<?php
/**
 * A page of plain content in the site's frame: a legal document (the cookie
 * policy Complianz generates, the privacy statement, the terms), or the
 * payment confirmation (_dl_layout = done: centred, a check above the title,
 * no breadcrumb). _dl_heading overrides the title as the h1. Typography in
 * assets/css/wp.css (.dl-doc).
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) {
	the_post();
	$heading = get_post_meta( get_the_ID(), '_dl_heading', true );
	$done    = 'done' === get_post_meta( get_the_ID(), '_dl_layout', true );
	?>
	<article class="dl-doc band-lead<?php echo $done ? ' dl-doc--done' : ''; ?>">
		<?php if ( $done ) : ?>
			<svg class="dl-check" width="72" height="72" viewBox="0 0 72 72" fill="none" aria-hidden="true"><circle cx="36" cy="36" r="34" stroke="currentColor" stroke-width="2.5"/><path d="M23 37.5l9 9 17-19" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
		<?php else : ?>
			<?php echo dl_crumb( get_the_title(), null, array( 'hidden' => true ) ); ?>
		<?php endif; ?>
		<h1 class="d1"><?php echo esc_html( $heading ? $heading : get_the_title() ); ?></h1>
		<div class="dl-doc-body"><?php the_content(); ?></div>
	</article>
	<?php
}

get_footer();
