<?php
/**
 * Generic page template with page-part routing.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $page_part_slug = function_exists('wataco_resolve_page_part_slug')
            ? wataco_resolve_page_part_slug(get_post())
            : '';
        ?>

        <?php if ('' !== $page_part_slug) : ?>
            <?php get_template_part('parts/pages/' . $page_part_slug); ?>
        <?php else : ?>
            <main class="container mx-auto my-10 px-4">
                <article <?php post_class('prose max-w-none'); ?>>
                    <h1 class="mb-6"><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </article>
            </main>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();
