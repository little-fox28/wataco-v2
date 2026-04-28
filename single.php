<?php
/**
 * Single post template — Universal wrapper for ALL post types.
 *
 * Strategy:
 * - Detects if the current post belongs to the translated "Projects" category tree
 *   using Polylang-compatible `get_term_by('slug', 'projects', 'category')`.
 * - Routes to the appropriate template partial:
 *   • Project posts  → parts/pages/single-project.php
 *   • Default posts  → parts/pages/single-post.php
 *
 * Progressive Enhancement:
 * - All content is server-rendered and readable before JS executes.
 * - Alpine.js enhances interactivity (progress bar, smooth scroll TOC).
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();

        get_template_part('parts/pages/single', 'post');

    endwhile;
endif;

get_footer();
