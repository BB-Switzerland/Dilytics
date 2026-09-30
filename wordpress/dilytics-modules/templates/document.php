<?php
/**
 * A legal document (the cookie policy Complianz generates): the page title
 * and its content in the site's frame, the Themer header and footer around.
 * Typography in assets/css/wp.css (.dl-doc).
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) {
	the_post();
	?>
	<article class="dl-doc band-lead">
		<?php echo dl_crumb( get_the_title(), null, array( 'hidden' => true ) ); ?>
		<h1 class="d1"><?php the_title(); ?></h1>
		<div class="dl-doc-body"><?php the_content(); ?></div>
	</article>
	<?php
}

get_footer();
