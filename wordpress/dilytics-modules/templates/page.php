<?php
/**
 * Every page built with Beaver Builder: the full width of the window, with no
 * theme container, no post title, nothing between the sections and the page.
 * Header and footer are the Themer layouts, printed by get_header() and
 * get_footer() as on any page of the theme.
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) {
	the_post();
	the_content();
}

get_footer();
