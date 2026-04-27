<?php
/**
 * Template Name: Projects
 *
 * @package Wataco
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		get_template_part( 'parts/pages/projects' );
	endwhile;
endif;

get_footer();
