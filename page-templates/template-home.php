<?php
/**
 * Template Name: Home
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();
        get_template_part('parts/pages/home');
    endwhile;
else :
    get_template_part('parts/pages/home');
endif;

get_footer();

