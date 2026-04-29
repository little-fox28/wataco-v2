<?php
/**
 * Common Breadcrumbs Component
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$pll = function_exists('pll__');
$t_home = $pll ? pll__('Home') : 'Home';

$current_title = is_singular() ? get_the_title() : (is_archive() ? get_the_archive_title() : (is_search() ? 'Search Results' : get_the_title()));

$category_link = '#';
$category_name = '';

if (is_singular('post')) {
    $categories = get_the_category();
    if (!empty($categories)) {
        $section_slug_map = array(
            'careers'  => array('careers', 'careers-vn', 'careers-en', 'careers-ja', 'tuyen-dung', 'tuyen-dung-vn'),
            'news'     => array('news', 'news-en', 'news-ja', 'tin-tuc', 'tin-tuc-vn'),
            'projects' => array('projects', 'projects-vn', 'projects-en', 'projects-ja', 'du-an', 'quoc-te', 'international', 'trong-nuoc', 'vietnam-vn'),
        );

        $section_page_paths = array(
            'careers' => array(
                'vi'      => array('tuyen-dung', 'careers-vn'),
                'en'      => array('careers', 'careers-en'),
                'ja'      => array('careers-ja'),
                'default' => array('tuyen-dung', 'careers'),
            ),
            'news' => array(
                'vi'      => array('tin-tuc', 'tin-tuc-vn'),
                'en'      => array('news', 'news-en'),
                'ja'      => array('news-ja', 'news'),
                'default' => array('news', 'tin-tuc'),
            ),
            'projects' => array(
                'vi'      => array('du-an', 'projects-vn'),
                'en'      => array('projects', 'projects-en'),
                'ja'      => array('projects-ja', 'projects'),
                'default' => array('projects', 'du-an'),
            ),
        );

        $current_lang = function_exists('pll_current_language') ? (string) pll_current_language('slug') : '';
        $matched_section = '';
        $primary_category = $categories[0];
        $top_parent = $primary_category;

        foreach ($categories as $cat) {
            $terms_to_check = array($cat);
            $ancestor_ids = get_ancestors($cat->term_id, 'category');
            foreach ($ancestor_ids as $ancestor_id) {
                $ancestor_term = get_category((int) $ancestor_id);
                if ($ancestor_term && !is_wp_error($ancestor_term)) {
                    $terms_to_check[] = $ancestor_term;
                }
            }

            foreach ($terms_to_check as $term) {
                if ((int) $term->parent === 0) {
                    $top_parent = $term;
                }

                foreach ($section_slug_map as $section_key => $section_slugs) {
                    if (in_array($term->slug, $section_slugs, true)) {
                        $matched_section = $section_key;
                        break 3;
                    }
                }
            }
        }

        if ($matched_section !== '' && isset($section_page_paths[$matched_section])) {
            $path_candidates = array();
            if ($current_lang !== '' && isset($section_page_paths[$matched_section][$current_lang])) {
                $path_candidates = $section_page_paths[$matched_section][$current_lang];
            }
            $path_candidates = array_merge($path_candidates, $section_page_paths[$matched_section]['default']);
            $path_candidates = array_values(array_unique(array_filter($path_candidates)));

            foreach ($path_candidates as $path_slug) {
                $page = get_page_by_path($path_slug, OBJECT, 'page');
                if (!$page instanceof WP_Post) {
                    continue;
                }

                $page_id = (int) $page->ID;
                if ($current_lang !== '' && function_exists('pll_get_post')) {
                    $translated_page_id = (int) pll_get_post($page_id, $current_lang);
                    if ($translated_page_id > 0) {
                        $page_id = $translated_page_id;
                    }
                }

                $permalink = get_permalink($page_id);
                if ($permalink) {
                    $category_link = $permalink;
                    $category_name = get_the_title($page_id);
                    break;
                }
            }
        }

        if (empty($category_name)) {
            $category_link = get_category_link($top_parent->term_id);
            $category_name = $top_parent->name;
        }
    }
}
?>

<!-- Semantic Breadcrumbs -->
<nav aria-label="Breadcrumb" class="flex items-center space-x-2 text-[10px] uppercase tracking-widest text-white/80 mb-6 font-bold transition-all duration-500 delay-75"
     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'">
    <ol class="flex items-center space-x-2 list-none m-0 p-0">
        <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-white transition-colors"><?php echo esc_html($t_home); ?></a></li>
        <li><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
        <?php if (!empty($category_name)) : ?>
            <li><a href="<?php echo esc_url($category_link); ?>" class="hover:text-white transition-colors"><?php echo esc_html($category_name); ?></a></li>
            <li><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
        <?php endif; ?>
        <li aria-current="page" class="text-[#FFD700] line-clamp-1 max-w-50"><?php echo esc_html($current_title); ?></li>
    </ol>
</nav>
