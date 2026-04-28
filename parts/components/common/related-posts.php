<?php
/**
 * Related Posts Component
 * 
 * Hyper-optimized related posts query for sidebar widget.
 * Expects $post_id to be available in scope.
 */

if (!defined('ABSPATH')) {
    exit;
}

$category_ids = wp_get_post_categories($post_id);

$related_query = false;
if (!empty($category_ids)) {
    $args = array(
        'category__in'        => $category_ids,
        'post__not_in'        => array($post_id),
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
        'post_status'         => 'publish',
    );
    $related_query = new WP_Query($args);
}

$section_title = function_exists('pll__') ? pll__('Related Articles') : 'Related Articles';
$updating_text = function_exists('pll__') ? pll__('Updating...') : 'Updating...';
?>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="bg-[#F8FAFC] px-6 py-4 border-b border-gray-100">
        <h2 class="text-sm font-black text-[#1A2B3C] uppercase tracking-widest m-0">
            <?php echo esc_html($section_title); ?>
        </h2>
    </div>
    <div class="flex flex-col p-6 space-y-6">
        <?php if ($related_query && $related_query->have_posts()) : ?>
            <?php while ($related_query->have_posts()) : $related_query->the_post(); 
                $rel_post_id = get_the_ID();
                $rc = get_the_category();
                $rel_cat_name = !empty($rc) ? $rc[0]->name : '';
            ?>
                <a href="<?php echo esc_url(get_permalink()); ?>" class="group flex gap-4 items-center no-underline">
                    <div class="w-16 h-16 rounded-md overflow-hidden shrink-0 border border-gray-100">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url($rel_post_id, 'thumbnail')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" loading="lazy" />
                        <?php else : ?>
                            <div class="w-full h-full bg-gray-100"></div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-[#1A2B3C] line-clamp-2 leading-snug group-hover:text-[#228B22] transition-colors mb-1">
                            <?php echo esc_html(get_the_title()); ?>
                        </h5>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider"><?php echo esc_html($rel_cat_name); ?></span>
                    </div>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
            <p class="text-sm text-gray-500"><?php echo esc_html($updating_text); ?></p>
        <?php endif; ?>
    </div>
</div>
