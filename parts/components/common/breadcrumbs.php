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
    if ( !empty($categories) ) {
        // 1. TẠO TỪ ĐIỂN ÁNH XẠ
        $breadcrumb_map = array(
            'projects' => array(
                'slugs'   => array('projects', 'projects-vn', 'projects-ja', 'vietnam-vn', 'trong-nuoc', 'quoc-te', 'international'),
                'page_id' => 26 
            ),
            'news' => array(
                'slugs'   => array('news', 'tin-tuc', 'tin-tuc-vn', 'news-en', 'news-ja'),
                'page_id' => 150 
            ),
            'careers' => array(
                'slugs'   => array('careers', 'tuyen-dung', 'tuyen-dung-vn', 'careers-en', 'careers-ja'),
                'page_id' => 180 
            )
        );

        $matched_base_page_id = null;

        // 2. THUẬT TOÁN DÒ TÌM
        foreach ( $categories as $cat ) {
            foreach ( $breadcrumb_map as $group => $data ) {
                if ( in_array( $cat->slug, $data['slugs'] ) ) {
                    $matched_base_page_id = $data['page_id'];
                    break 2;
                }
            }
        }

        // 3. XỬ LÝ URL DỰA TRÊN KẾT QUẢ DÒ TÌM
        if ( $matched_base_page_id ) {
            if ( function_exists('pll_get_post') ) {
                $translated_page_id = pll_get_post( $matched_base_page_id, pll_current_language() );
                if ( $translated_page_id ) {
                    $category_link = get_permalink( $translated_page_id );
                    $category_name = get_the_title( $translated_page_id ); 
                }
            } else {
                $category_link = get_permalink( $matched_base_page_id );
                $category_name = get_the_title( $matched_base_page_id );
            }
        } else {
            $category_link = get_category_link( $categories[0]->term_id );
            $category_name = $categories[0]->name;
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
        <li aria-current="page" class="text-[#FFD700] line-clamp-1 max-w-[200px]"><?php echo esc_html($current_title); ?></li>
    </ol>
</nav>
