<?php
/**
 * ACF configuration and theme data helpers.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Cloudflare R2 configuration.
 * These should match your Media Cloud Sync settings.
 */
define('WATACO_CLOUDFLARE_CDN_URL', 'https://cdn.wataco.com.vn');

/**
 * Convert local image path to Cloudflare R2 URL.
 * 
 * Handles legacy project_img_path migration:
 * - Local: /assets/images/project/Higashimatsushima.jpg
 * - Cloudflare: https://cdn.wataco.com.vn/wp-content/uploads/2026/05/Higashimatsushima.jpg
 * 
 * @param string $local_path The local image path
 * @return string Cloudflare R2 URL or empty string
 */
function wataco_convert_to_cloudflare_url($local_path) {
    if (empty($local_path)) {
        return '';
    }
    
    // Extract just the filename if it's a path
    $filename = basename($local_path);
    
    // Build Cloudflare URL: https://cdn.wataco.com.vn/wp-content/uploads/2026/05/filename.jpg
    return WATACO_CLOUDFLARE_CDN_URL . '/wp-content/uploads/2026/05/' . $filename;
}

/**
 * Get image URL with Media Cloud Sync support.
 * 
 * This function properly handles:
 * - ACF image fields (returns ID, converts to URL)
 * - Media Cloud Sync URLs (media-wataco/wp-content/uploads/...)
 * - WordPress attachment URLs
 * - Legacy meta paths → Cloudflare R2
 * 
 * @param int $attachment_id The attachment/image ID
 * @return string Image URL or empty string
 */
function wataco_get_image_url($attachment_id) {
    if (!$attachment_id || !is_numeric($attachment_id)) {
        return '';
    }
    
    $attachment_id = (int) $attachment_id;
    
    // Get attachment URL - Media Cloud Sync intercepts this automatically
    $url = wp_get_attachment_url($attachment_id);
    
    if ($url) {
        return $url;
    }
    
    // Fallback: Try with 'large' size
    $large_url = wp_get_attachment_image_url($attachment_id, 'large');
    if ($large_url) {
        return $large_url;
    }
    
    // If still no URL, try to get the source URL
    $attachment = get_post($attachment_id);
    if ($attachment) {
        return wp_get_attachment_url($attachment->ID);
    }
    
    return '';
}

/**
 * Get post image URL with Media Cloud Sync support.
 * 
 * Prioritizes:
 * 1. Featured image
 * 2. ACF project_img field
 * 3. Empty string
 * 
 * @param int $post_id The post ID
 * @param string $size Image size (default: 'large')
 * @return string Image URL or empty string
 */
function wataco_get_news_image($post_id, $size = 'large') {
    if (!$post_id || !is_numeric($post_id)) {
        return '';
    }
    
    $post_id = (int) $post_id;
    
    // 1. Try featured image first
    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail_url($post_id, $size);
    }
    
    // 2. Try ACF project image (Media Cloud Sync compatible)
    if (function_exists('get_field')) {
        $acf_img = get_field('project_img', $post_id);
        if (!empty($acf_img)) {
            if (is_numeric($acf_img)) {
                return wp_get_attachment_image_url((int) $acf_img, $size);
            } elseif (is_array($acf_img)) {
                $url = $acf_img['url'] ?? '';
                if (empty($url) && isset($acf_img['id'])) {
                    return wp_get_attachment_image_url($acf_img['id'], $size);
                }
                return $url;
            }
        }
    }

    // 3. Try legacy XML hero image used by imported posts.
    $xml_hero = get_post_meta($post_id, '_xml_hero_image', true);
    if (is_string($xml_hero) && $xml_hero !== '') {
        return esc_url_raw($xml_hero);
    }

    // 4. Try legacy path field and convert to Cloudflare URL.
    $legacy_path = get_post_meta($post_id, 'project_img_path', true);
    if (is_string($legacy_path) && $legacy_path !== '') {
        return wataco_convert_to_cloudflare_url($legacy_path);
    }
    
    return '';
}

/**
 * Register ACF Free field group attached to Theme Settings page.
 *
 * @return void
 */
function wataco_register_theme_settings_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_wataco_theme_settings',
        'title' => 'Theme Settings',
        'fields' => array(
            array(
                'key' => 'field_wataco_theme_settings_global_logo',
                'label' => 'Global Logo',
                'name' => 'global_logo',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_wataco_theme_settings_faded_background_logo',
                'label' => 'Faded Background Logo',
                'name' => 'faded_background_logo',
                'type' => 'image',
                'return_format' => 'id',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_wataco_theme_settings_email',
                'label' => 'Email',
                'name' => 'email',
                'type' => 'email',
            ),
            array(
                'key' => 'field_wataco_theme_settings_phone',
                'label' => 'Phone',
                'name' => 'phone',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wataco_theme_settings_linkedin',
                'label' => 'LinkedIn',
                'name' => 'linkedin',
                'type' => 'url',
            ),
            array(
                'key' => 'field_wataco_theme_settings_facebook',
                'label' => 'Facebook',
                'name' => 'facebook',
                'type' => 'url',
            ),
            array(
                'key' => 'field_wataco_theme_settings_zalo',
                'label' => 'Zalo',
                'name' => 'zalo',
                'type' => 'url',
            ),
            array(
                'key' => 'field_wataco_theme_settings_tiktok',
                'label' => 'TikTok',
                'name' => 'tiktok',
                'type' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-templates/template-theme-settings.php',
                ),
            ),
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-settings',
                ),
            ),
        ),
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));
}
add_action('acf/init', 'wataco_register_theme_settings_acf_fields');

/**
 * Register ACF Free field group for Home Solutions.
 *
 * @return void
 */
function wataco_register_home_solutions_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_home_solutions',
        'title' => 'Home: Investment Solutions',
        'fields' => array(
            array(
                'key' => 'field_home_solutions_subtitle',
                'label' => 'Subtitle',
                'name' => 'solutions_subtitle',
                'type' => 'text',
                'default_value' => 'INVESTMENT SOLUTIONS',
            ),
            array(
                'key' => 'field_home_solutions_title',
                'label' => 'Title',
                'name' => 'solutions_title',
                'type' => 'text',
                'default_value' => 'DIVERSE INVESTMENT SOLUTIONS',
            ),
            array(
                'key' => 'field_home_solutions_data',
                'label' => 'Solutions Data',
                'name' => 'solutions_data',
                'type' => 'repeater',
                'instructions' => 'Manage the different investment solutions displayed in the section.',
                'required' => 0,
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Add Solution',
                'sub_fields' => array(
                    array(
                        'key' => 'field_home_solutions_id',
                        'label' => 'ID (Anchor)',
                        'name' => 'id',
                        'type' => 'text',
                        'instructions' => 'Unique ID (e.g. esco, buy, lease)',
                    ),
                    array(
                        'key' => 'field_home_solutions_short_title',
                        'label' => 'Short Title (Tabs)',
                        'name' => 'short_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_home_solutions_full_title',
                        'label' => 'Full Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_home_solutions_desc',
                        'label' => 'Description',
                        'name' => 'desc',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                    array(
                        'key' => 'field_home_solutions_diagram_type',
                        'label' => 'Diagram Type',
                        'name' => 'diagram_type',
                        'type' => 'select',
                        'choices' => array(
                            'three-party' => 'Three Party (Triangle)',
                            'two-party'   => 'Two Party (Line)',
                        ),
                        'default_value' => 'three-party',
                    ),
                    array(
                        'key' => 'field_home_solutions_role_client',
                        'label' => 'Role: Client',
                        'name' => 'role_client',
                        'type' => 'text',
                        'default_value' => 'Client',
                    ),
                    array(
                        'key' => 'field_home_solutions_role_partner',
                        'label' => 'Role: Partner',
                        'name' => 'role_partner',
                        'type' => 'text',
                        'default_value' => 'Partner',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_home_solutions_diagram_type',
                                    'operator' => '==',
                                    'value' => 'three-party',
                                ),
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_home_solutions_flow_wataco_client',
                        'label' => 'Flow: WATACO to Client',
                        'name' => 'flow_wataco_client',
                        'type' => 'text',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_home_solutions_diagram_type',
                                    'operator' => '==',
                                    'value' => 'three-party',
                                ),
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_home_solutions_flow_partner_wataco',
                        'label' => 'Flow: Partner to WATACO',
                        'name' => 'flow_partner_wataco',
                        'type' => 'text',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_home_solutions_diagram_type',
                                    'operator' => '==',
                                    'value' => 'three-party',
                                ),
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_home_solutions_flow_client_partner',
                        'label' => 'Flow: Client to Partner',
                        'name' => 'flow_client_partner',
                        'type' => 'text',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_home_solutions_diagram_type',
                                    'operator' => '==',
                                    'value' => 'three-party',
                                ),
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_home_solutions_flow_client_wataco',
                        'label' => 'Flow: Client to WATACO',
                        'name' => 'flow_client_wataco',
                        'type' => 'text',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_home_solutions_diagram_type',
                                    'operator' => '==',
                                    'value' => 'two-party',
                                ),
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_home_solutions_link_slug',
                        'label' => 'Link Slug',
                        'name' => 'link_slug',
                        'type' => 'text',
                        'instructions' => 'Slug of the post for "View Details" link.',
                    ),
                    array(
                        'key' => 'field_home_solutions_note',
                        'label' => 'Note',
                        'name' => 'note',
                        'type' => 'text',
                        'instructions' => 'Optional disclaimer or note at the bottom.',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-templates/template-home.php',
                ),
            ),
        ),
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));
}
add_action('acf/init', 'wataco_register_home_solutions_acf_fields');

/**
 * Build default culture section values for About Us.
 *
 * @return array<string, string>
 */
function wataco_get_about_culture_fallbacks() {
    $translate = static function ($text) {
        return function_exists('pll__') ? (string) pll__($text) : $text;
    };

    $fallbacks = array(
        'subtitle'    => $translate('Working Environment'),
        'title'       => $translate('Life Rhythm At WATACO'),
        'description' => $translate('Everyday moments, field trips, and smiles on-site are the most positive source of energy for us.'),
    );

    $fallbacks = apply_filters('wataco_about_culture_fallbacks', $fallbacks);
    do_action('wataco_about_culture_fallbacks_loaded', $fallbacks);

    return $fallbacks;
}

/**
 * Build About Us culture gallery cards from ACF fixed fields.
 *
 * @return array<int, array<string, string|int>>
 */
function wataco_get_about_culture_items() {
    $translate = static function ($text) {
        return function_exists('pll__') ? (string) pll__($text) : $text;
    };

    $meta = array(
        1 => array(
            'img'      => '/team_building.jpg',
            'span'     => 'md:col-span-2 md:row-span-2',
            'category' => $translate('Culture'),
            'title'    => $translate('Team Building 2025'),
        ),
        2 => array(
            'img'      => 'https://images.unsplash.com/photo-1759922378222-47ad736a174d?auto=format&fit=crop&q=80&w=800',
            'span'     => 'md:col-span-1 md:row-span-1',
            'category' => $translate('Work'),
            'title'    => $translate('Site Supervision'),
        ),
        3 => array(
            'img'      => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&q=80&w=800',
            'span'     => 'md:col-span-1 md:row-span-1',
            'category' => $translate('Development'),
            'title'    => $translate('Internal Training'),
        ),
        4 => array(
            'img'      => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&q=80&w=800',
            'span'     => 'md:col-span-1 md:row-span-2',
            'category' => $translate('Office'),
            'title'    => $translate('Quarterly Strategy Meeting'),
        ),
        5 => array(
            'img'      => 'https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?auto=format&fit=crop&q=80&w=800',
            'span'     => 'md:col-span-2 md:row-span-1',
            'category' => $translate('Work'),
            'title'    => $translate('Project Acceptance'),
        ),
        6 => array(
            'img'      => 'https://images.unsplash.com/photo-1762944082537-bf904828a5c9?auto=format&fit=crop&q=80&w=800',
            'span'     => 'md:col-span-2 md:row-span-1',
            'category' => $translate('Connection'),
            'title'    => $translate('Sports Activities'),
        ),
    );

    $culture_items = array();
    for ($index = 1; $index <= 6; $index++) {
        $default_item = $meta[$index];
        $image_id = function_exists('get_field') ? (int) get_field('culture_item_' . $index . '_img') : 0;
        $image_url = $default_item['img'];

        if ($image_id > 0) {
            $attachment_url = wp_get_attachment_image_url($image_id, 'large');
            if (is_string($attachment_url) && '' !== $attachment_url) {
                $image_url = $attachment_url;
            }
        }

        $category_value = function_exists('get_field') ? get_field('culture_item_' . $index . '_category') : '';
        $title_value = function_exists('get_field') ? get_field('culture_item_' . $index . '_title') : '';

        $culture_item = array(
            'id'       => $index,
            'img'      => $image_url,
            'span'     => $default_item['span'],
            'category' => (is_string($category_value) && '' !== trim($category_value)) ? trim($category_value) : $default_item['category'],
            'title'    => (is_string($title_value) && '' !== trim($title_value)) ? trim($title_value) : $default_item['title'],
        );

        $culture_items[] = apply_filters('wataco_about_culture_item', $culture_item, $index);
    }

    $culture_items = apply_filters('wataco_about_culture_items', $culture_items);
    do_action('wataco_about_culture_items_loaded', $culture_items);

    return $culture_items;
}

/**
 * Get Theme Settings page ID for ACF Free field access.
 *
 * @return int
 */
function wataco_get_theme_settings_page_id() {
    static $theme_settings_page_id = null;

    if (null !== $theme_settings_page_id) {
        return $theme_settings_page_id;
    }

    $theme_settings_page = get_page_by_path('theme-settings', OBJECT, 'page');
    $theme_settings_page_id = ($theme_settings_page instanceof WP_Post) ? (int) $theme_settings_page->ID : 0;

    if ($theme_settings_page_id && function_exists('pll_get_post')) {
        $translated_theme_settings_page_id = pll_get_post($theme_settings_page_id);
        if (!empty($translated_theme_settings_page_id)) {
            $theme_settings_page_id = (int) $translated_theme_settings_page_id;
        }
    }

    return $theme_settings_page_id;
}

/**
 * Get all data for the home page sections.
 *
 * @return array<string, mixed>
 */
function    wataco_get_home_data() {
    $translate = static function ($text) {
        return function_exists('pll__') ? (string) pll__($text) : $text;
    };

    $post_id = get_the_ID();

    // If Polylang is active, prefer the translation of the current page so
    // ACF functions (get_field / get_sub_field) return values for the
    // current language instead of the default language.
    if (function_exists('pll_get_post')) {
        $translated_post_id = pll_get_post($post_id);
        if (!empty($translated_post_id)) {
            $post_id = (int) $translated_post_id;
        }
    }

    // --- Fetch Dynamic Projects (Category 44) ---
    $projects_data = array(
        'vietnam' => array(),
        'international' => array()
    );

    $base_cat_id = 44;
    $translated_cat_id = $base_cat_id;
    if (function_exists('pll_get_term')) {
        $translated_cat_id = pll_get_term($base_cat_id, pll_current_language()) ?: $base_cat_id;
    }

    $projects_query = new WP_Query(array(
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'cat'            => $translated_cat_id,
        'no_found_rows'  => true,
    ));

    if ($projects_query->have_posts()) {
        while ($projects_query->have_posts()) {
            $projects_query->the_post();
            $pid = get_the_ID();

            // Determine category group
            $terms = wp_get_post_terms($pid, 'category');
            $group = 'vietnam';
            foreach ($terms as $t) {
                if (strpos($t->slug, 'international') !== false) {
                    $group = 'international';
                    break;
                }
            }

            // Image logic - Priority: ACF image field > featured image > legacy meta path
            // Media Cloud Sync integration: automatically handles URL conversion
            $img_url = '';
            
            // 1. Try ACF image field (returns ID)
            $img_id = function_exists('get_field') ? get_field('project_img', $pid) : false;
            if ($img_id) {
                $img_url = wataco_get_image_url($img_id);
            }
            
            // 2. Try featured image
            if (!$img_url && has_post_thumbnail($pid)) {
                $featured_id = get_post_thumbnail_id($pid);
                $img_url = wataco_get_image_url($featured_id);
            }
            
            // 3. Try legacy meta path (convert to Cloudflare R2)
            if (!$img_url) {
                $img_path = get_post_meta($pid, 'project_img_path', true);
                if ($img_path) {
                    if (strpos($img_path, 'http') === 0) {
                        // Already a full URL
                        $img_url = $img_path;
                    } elseif (strpos($img_path, 'cdn.wataco.com.vn') !== false || strpos($img_path, WATACO_CLOUDFLARE_CDN_URL) !== false) {
                        // Already a Cloudflare URL
                        $img_url = $img_path;
                    } else {
                        // Legacy local path → Convert to Cloudflare R2
                        $img_url = wataco_convert_to_cloudflare_url($img_path);
                    }
                }
            }

            $projects_data[$group][] = array(
                'name'     => get_the_title(),
                'location' => (string) get_post_meta($pid, 'project_location', true),
                'capacity' => (string) get_post_meta($pid, 'project_capacity', true),
                'year'     => (string) get_post_meta($pid, 'project_year', true),
                'status'   => $translate((string) get_post_meta($pid, 'project_status', true)),
                'img'      => $img_url,
                'slug'     => get_post_field('post_name', $pid),
            );
        }
        wp_reset_postdata();
    }

    $data = array(
        'stats' => array(
            array(
                'prefix' => '+',
                'val'    => 500,
                'suffix' => 'MWp',
                'label'  => $translate('TOTAL CAPACITY'),
            ),
            array(
                'prefix' => '+',
                'val'    => 10,
                'suffix' => '',
                'label'  => $translate('YEARS EXPERIENCE'),
            ),
            array(
                'prefix' => '+',
                'val'    => 200,
                'suffix' => '',
                'label'  => $translate('COMPLETED PROJECTS'),
            ),
            array(
                'prefix' => '',
                'val'    => 99.9,
                'suffix' => '%',
                'label'  => $translate('SYSTEM RELIABILITY'),
            ),
        ),
        'heritage' => array(
            'subtitle' => $translate('WATANABE CREATE HERITAGE'),
            'title'    => $translate('The Journey From Sendai To Vietnam'),
            'content1' => $translate('WATACO was founded on the foundation of WATANABE CREATE Group, Sendai, Japan. Established on December 17, 2015, WATANABE CREATE has achieved many achievements in consulting, design, and construction of solar power projects in Japan, a pioneer in renewable energy technology.'),
            'content2' => $translate('WATACO was established in 2021 in Vietnam, operating in the field of consulting, design, and construction of solar power projects in Vietnam with the motto "quality creates sustainable prestige". We are committed to providing optimal solutions, suitable to customers\' requirements in every detail.'),
            'content3' => $translate('In addition, WATACO also aims to develop the field of construction, renovation of houses, and interiors, bringing comfortable and modern living spaces in Vietnam. We always listen to customers\' wishes, create worthy works, and constantly learn, deserving to be the top choice.'),
        ),
        'solutions' => array(
            'subtitle' => function_exists('get_field') && get_field('solutions_subtitle', $post_id) ? $translate(get_field('solutions_subtitle', $post_id)) : $translate('INVESTMENT SOLUTIONS'),
            'title'    => function_exists('get_field') && get_field('solutions_title', $post_id) ? $translate(get_field('solutions_title', $post_id)) : $translate('DIVERSE INVESTMENT SOLUTIONS'),
            'labels'   => array(
                'chooseSolution' => $translate('Choose this solution'),
                'modelTitle'     => $translate('Model'),
                'detailCta'      => $translate('View Details'),
            ),
            'data'     => array(),
        ),
        'ppa' => array(
            'subtitle' => $translate('SOLAR POWER 0 Cost'),
            'title'    => $translate('PPA Cooperation Model'),
            'desc'     => $translate('Roof-top solar power system with 0 Cost investment capital for businesses.'),
            'benefits' => array(
                $translate('No investment capital needed'),
                $translate('Reduce operating costs'),
                $translate('Green certificates & Carbon credits'),
                $translate('Comprehensive O&M support'),
            ),
            'button'   => $translate('Get Consultation'),
        ),
        'epc' => array(
            'subtitle' => $translate('EPC TOTAL CONTRACTOR'),
            'title'    => $translate('Professional EPC Management'),
            'desc'     => $translate('We provide comprehensive EPC (Engineering, Procurement, and Construction) services, ensuring the highest standards of quality and efficiency.'),
            'quality'  => $translate('Quality Commitment'),
            'standard' => $translate('Japanese Standard'),
            'button'   => $translate('View EPC Profile'),
            'steps'    => array(
                array('title' => $translate('Design & Engineering'), 'desc' => $translate('Technical assessment and site feasibility study.')),
                array('title' => $translate('Procurement'), 'desc' => $translate('Optimized system design using international standards.')),
                array('title' => $translate('Construction'), 'desc' => $translate('Selection of Tier-1 equipment and materials.')),
                array('title' => $translate('O&M'), 'desc' => $translate('System monitoring and maintenance services.')),
            ),
        ),
        'map' => array(
            'subtitle'    => $translate('OPERATIONAL SCALE'),
            'title'       => $translate('Project Network'),
            'description' => $translate('Commitment to quality and outstanding performance across Vietnam with more than 500MWp of total installed capacity.'),
            'clientTitle' => $translate('Trusted Partners'),
            'stats'       => array(
                array(
                    'label' => $translate('PROJECTS SIGNED'),
                    'val'   => 250,
                    'suffix'=> '+',
                    'color' => '#3B82F6',
                    'icon'  => 'file-text'
                ),
                array(
                    'label' => $translate('TOTAL INSTALLED CAPACITY'),
                    'val'   => 500,
                    'suffix'=> ' MWp',
                    'color' => '#EAB308',
                    'icon'  => 'zap'
                ),
                array(
                    'label' => $translate('SYSTEMS OPERATING'),
                    'val'   => 180,
                    'suffix'=> '+',
                    'color' => '#228B22',
                    'icon'  => 'bar-chart'
                ),
            ),
            'locations' => array(
                array('top' => '15%', 'left' => '45%', 'name' => $translate('Bắc Ninh')),
                array('top' => '18%', 'left' => '48%', 'name' => $translate('Hải Dương')),
                array('top' => '20%', 'left' => '40%', 'name' => $translate('Hải Phòng')),
                array('top' => '48%', 'left' => '50%', 'name' => $translate('Quảng Ngãi')),
                array('top' => '75%', 'left' => '52%', 'name' => $translate('Lâm Đồng')),
                array('top' => '80%', 'left' => '55%', 'name' => $translate('Bình Thuận')),
                array('top' => '85%', 'left' => '40%', 'name' => $translate('Tây Ninh')),
                array('top' => '87%', 'left' => '45%', 'name' => $translate('Bình Dương')),
                array('top' => '88%', 'left' => '45%', 'name' => $translate('Đồng Nai')),
                array('top' => '82%', 'left' => '45%', 'name' => $translate('Long An')),
            ),
            'clients' => array(
                array('name' => 'TH True Milk', 'logo' => 'TH.svg', 'color' => '#013C78'),
                array('name' => 'ALPHA', 'logo' => 'alpha.svg', 'color' => '#00469B'),
                array('name' => 'AMANN', 'logo' => 'amann.svg', 'color' => '#028AD2'),
                array('name' => 'FGC', 'logo' => 'fgc.svg', 'color' => '#42851F'),
                array('name' => 'HAWA-EXPO', 'logo' => 'hawa-expo.svg', 'color' => '#A13538'),
                array('name' => 'KAIFA', 'logo' => 'kaifa.svg', 'color' => '#1D2088'),
                array('name' => 'MKVN', 'logo' => 'mkvn.svg', 'color' => '#00A650'),
                array('name' => 'RYOBI', 'logo' => 'ryobi.svg', 'color' => '#1456A1'),
                array('name' => 'STROMAN', 'logo' => 'stroman.svg', 'color' => '#0F75BC'),
            )
        ),
        'projects' => array(
            'subtitle' => $translate('ACTUAL WORKS'),
            'title'    => $translate('Projects'),
            'viewMore' => $translate('Project Details'),
            'tabs'     => array(
                array('id' => 'vietnam', 'label' => $translate('Vietnam')),
                array('id' => 'international', 'label' => $translate('International')),
            ),
            'data'     => $projects_data,
        ),
        'mission' => array(
            'subtitle' => $translate('Strategic Orientation'),
            'title'    => $translate('Vision, Mission & Core Values'),
            'vision'   => array(
                'title' => $translate('Vision'),
                'desc'  => $translate('Creating a sustainable future through constructing and investing in advanced solar energy in Vietnam, supporting business growth and partnering with the community.'),
            ),
            'mission'  => array(
                'title' => $translate('Mission'),
                'desc'  => $translate('Providing high-quality, advanced, and environmentally friendly solar energy construction and investment solutions, contributing to enhancing life quality and supporting the sustainable development of businesses in Vietnam.'),
            ),
            'values'   => array(
                'title' => $translate('Core Values'),
                'items' => array(
                    $translate('Sustainability and Eco-friendliness'),
                    $translate('Quality and Innovation'),
                    $translate('Responsibility and Transparency'),
                    $translate('Collaboration and Development'),
                )
            )
        ),
        'services' => array(
            'subtitle' => $translate('OUR SERVICES'),
            'title'    => $translate('Comprehensive Energy Solutions'),
            'items'    => array(
                array('title' => $translate('Rooftop Solar'), 'icon' => 'sun'),
                array('title' => $translate('Solar Farm'), 'icon' => 'factory'),
                array('title' => $translate('O&M Services'), 'icon' => 'wrench'),
                array('title' => $translate('EPC General Contractor'), 'icon' => 'settings'),
                array('title' => $translate('Energy Consulting'), 'icon' => 'zap'),
            )
        ),
        'whySolar' => array(
            'title'   => $translate('Why Choose Solar Energy?'),
            'tagline' => $translate('Efficient - Sustainable - Future'),
            'items'   => array(
                array('title' => $translate('Cost Saving'), 'desc' => $translate('Reduce monthly electricity bills significantly.'), 'icon' => 'wallet'),
                array('title' => $translate('Eco-friendly'), 'desc' => $translate('Reduce carbon footprint and protect environment.'), 'icon' => 'leaf'),
                array('title' => $translate('Energy Independence'), 'desc' => $translate('Reduce dependence on the national grid.'), 'icon' => 'shield'),
                array('title' => $translate('High Durability'), 'desc' => $translate('Long system lifespan with minimal maintenance.'), 'icon' => 'trending-up'),
            )
        )
    );

    // Fetch Solutions Data from ACF if available
    if (function_exists('get_field') && have_rows('solutions_data', $post_id)) {
        while (have_rows('solutions_data', $post_id)) {
            the_row();
            $data['solutions']['data'][] = array(
                'id'          => get_sub_field('id'),
                'shortTitle'  => $translate(get_sub_field('short_title')),
                'title'       => $translate(get_sub_field('title')),
                'desc'        => $translate(get_sub_field('desc')),
                'diagramType' => get_sub_field('diagram_type'),
                'roles'       => array(
                    'client'  => $translate(get_sub_field('role_client')),
                    'partner' => $translate(get_sub_field('role_partner')),
                ),
                'flows'       => array(
                    'watacoToClient'   => $translate(get_sub_field('flow_wataco_client')),
                    'partnerToWataco' => $translate(get_sub_field('flow_partner_wataco')),
                    'clientToPartner' => $translate(get_sub_field('flow_client_partner')),
                    'clientToWataco'  => $translate(get_sub_field('flow_client_wataco')),
                ),
                'linkSlug'    => get_sub_field('link_slug'),
                'note'        => $translate(get_sub_field('note')),
            );
        }
    } else {
        // Fallback to static data
        $data['solutions']['data'] = array(
            array(
                'id'          => 'esco',
                'shortTitle'  => $translate('1. ESCO Model'),
                'title'       => $translate('ESCO (Energy Service Company) Solution'),
                'desc'        => $translate('The ESCO model uses idle factory rooftops to deploy solar systems. WATACO acts as EPC contractor (engineering, procurement, construction, maintenance, and warranty) to ensure optimal system performance.'),
                'diagramType' => 'three-party',
                'roles'       => array('client' => $translate('Client'), 'partner' => $translate('Financial Partner')),
                'flows'       => array('watacoToClient' => $translate('Consulting, design, EPC, O&M'), 'partnerToWataco' => $translate('Financial disbursement'), 'clientToPartner' => $translate('Monthly electricity payment')),
                'linkSlug'    => 'giai-phap-esco'
            ),
            array(
                'id'          => 'lease',
                'shortTitle'  => $translate('2. Rooftop Leasing'),
                'title'       => $translate('Industrial Rooftop Leasing Solution'),
                'desc'        => $translate('Businesses with qualified idle rooftops can lease them to increase income. The financial partner covers the full installation cost while WATACO executes as EPC contractor.'),
                'diagramType' => 'three-party',
                'roles'       => array('client' => $translate('Client'), 'partner' => $translate('Financial Partner')),
                'flows'       => array('watacoToClient' => $translate('Installation, operation, maintenance'), 'partnerToWataco' => $translate('Financial disbursement'), 'clientToPartner' => $translate('Receive monthly lease income')),
                'note'        => $translate('*Clients lease idle rooftop space with low risk and can renew leasing or inherit the system after 20 years.'),
                'linkSlug'    => 'cho-thue-mai-xuong-lap-dien-mat-troi'
            ),
            array(
                'id'          => 'invest',
                'shortTitle'  => $translate('3. Direct Investment'),
                'title'       => $translate('Direct Investment Solution'),
                'desc'        => $translate('Invest once and benefit for over 30 years. By investing in solar, owners can save up to 90% on electricity and may sell surplus electricity to EVN. WATACO provides full EPC to maximize performance.'),
                'diagramType' => 'two-party',
                'roles'       => array('client' => $translate('Investor')),
                'flows'       => array('clientToWataco' => $translate('Full EPC package (consulting, design, construction, warranty)')),
                'linkSlug'    => 'giai-phap-dau-tu-he-thong-dien-mat-troi-tu-do-tai-chinh'
            ),
            array(
                'id'          => 'finance',
                'shortTitle'  => $translate('4. Financial Leasing'),
                'title'       => $translate('Financial Leasing Solution'),
                'desc'        => $translate('WATACO helps businesses connect with banks offering favorable packages. The business pays only 20% upfront, while the bank finances the remaining 80%. WATACO serves as EPC contractor.'),
                'diagramType' => 'three-party',
                'roles'       => array('client' => $translate('Client'), 'partner' => $translate('Bank')),
                'flows'       => array('watacoToClient' => $translate('Consulting, design, EPC, O&M'), 'partnerToWataco' => $translate('Financial disbursement 80%'), 'clientToPartner' => $translate('Monthly lease payment (principal + interest)')),
                'note'        => $translate('*WATACO partners with trusted banks to provide preferential interest-rate services.'),
                'linkSlug'    => 'cho-thue-tai-chinh-dien-mat-troi-dau-tu-20-phan-tram'
            ),
        );
    }

    return apply_filters('wataco_home_data', $data);
}

/**
 * Get stats data for the home page.
 *
 * @deprecated Use wataco_get_home_data()['stats'] instead.
 * @return array<int, array<string, string|float|int>>
 */
function wataco_get_home_stats() {
    $data = wataco_get_home_data();
    return $data['stats'];
}

/**
 * Get ACF field value from Theme Settings page.
 *
 * @param string       $field_name Field name.
 * @param mixed|string $default_value Optional default value.
 * @return mixed|string
 */
function wataco_get_theme_settings_field($field_name, $default_value = '') {
    if (empty($field_name) || !function_exists('get_field')) {
        return $default_value;
    }

    $theme_settings_page_id = wataco_get_theme_settings_page_id();
    if (empty($theme_settings_page_id)) {
        return $default_value;
    }

    $value = apply_filters(
        'wataco_theme_settings_field_value',
        get_field($field_name, $theme_settings_page_id),
        $field_name,
        $theme_settings_page_id
    );

    if (null === $value || false === $value || '' === $value) {
        return $default_value;
    }

    return $value;
}

/**
 * Get ACF field value from Theme Settings options page.
 *
 * @param string       $field_name Field name.
 * @param mixed|string $default_value Optional default value.
 * @return mixed|string
 */
function wataco_get_theme_settings_option_field($field_name, $default_value = '') {
    if (empty($field_name) || !function_exists('get_field')) {
        return $default_value;
    }

    $value = apply_filters(
        'wataco_theme_settings_option_field_value',
        get_field($field_name, 'theme-settings'),
        $field_name
    );

    if (null === $value || false === $value || '' === $value) {
        return $default_value;
    }

    do_action('wataco_theme_settings_option_field_loaded', $field_name, $value);

    return $value;
}

/**
 * Build footer data from ACF Theme Settings and Polylang strings.
 *
 * @return array<string, mixed>
 */
function wataco_get_footer_data() {
    $theme_settings_page_id = wataco_get_theme_settings_page_id();
    $global = wataco_get_global_contact_info();
    $social = wataco_get_social_links();

    $footer_data = array(
        'global_logo_id'            => (int) wataco_get_theme_settings_field('global_logo', 0),
        'faded_background_logo_id'  => (int) wataco_get_theme_settings_field('faded_background_logo', 0),
        'email'                     => $global['email'],
        'phone'                     => $global['phone'],
        'linkedin'                  => $global['linkedin'],
        'facebook'                  => $global['facebook'],
        'zalo'                      => $global['zalo'],
        'tiktok'                    => $social['tiktok'],
        'youtube'                   => $social['youtube'],
        'company_description'       => (string) pll__('Company Description'),
        'address_1'                 => (string) pll__('Address 1 (HQ)'),
        'address_2'                 => (string) pll__('Address 2 (Branch)'),
        'title_solutions'           => (string) pll__('Tiêu đề footer cột 2'),
        'title_about'               => (string) pll__('Tiêu đề footer cột 3'),
        'title_contact'             => (string) pll__('Tiêu đề footer cột 4'),
    );

    $footer_data = apply_filters('wataco_footer_data', $footer_data, $theme_settings_page_id);

    do_action('wataco_footer_data_loaded', $footer_data, $theme_settings_page_id);

    return $footer_data;
}

/**
 * Helper: Get Global Contact Info
 *
 * Retrieves the 5 global contact fields from WATACO Settings.
 * Generates a clean phone number for hrefs.
 *
 * @return array<string, string>
 */
function wataco_get_global_contact_info() {
    $phone = get_option('wataco_contact_phone', '0359 959 831');
    return array(
        'facebook'    => get_option('wataco_social_facebook', 'https://facebook.com/wataco'),
        'linkedin'    => get_option('wataco_social_linkedin', 'https://linkedin.com/company/wataco'),
        'zalo'        => get_option('wataco_social_zalo', 'https://zalo.me/0359959831'),
        'phone'       => $phone,
        'phone_clean' => preg_replace('/[^0-9+]/', '', $phone),
        'email'       => get_option('wataco_contact_email', 'info@wataco.com.vn'),
    );
}

/**
 * Helper: Get Social Links
 *
 * Delegates to wataco_get_global_contact_info() for the core 3 social links
 * and adds tiktok/youtube from ACF Theme Settings.
 *
 * @return array<string, string> Social links with linkedin, facebook, zalo, tiktok, youtube keys
 */
function wataco_get_social_links() {
    $global = wataco_get_global_contact_info();

    return array(
        'linkedin' => $global['linkedin'],
        'facebook' => $global['facebook'],
        'zalo'     => $global['zalo'],
        'tiktok'   => (string) wataco_get_theme_settings_option_field('tiktok', ''),
        'youtube'  => (string) wataco_get_theme_settings_option_field('youtube', ''),
    );
}

/**
 * Helper: Get Contact Information
 *
 * Delegates to wataco_get_global_contact_info() for phone/email
 * and adds Polylang-translated addresses.
 *
 * @return array<string, string> Contact info with address_1, address_2, email, phone keys
 */
function wataco_get_contact_info() {
    $global = wataco_get_global_contact_info();

    return apply_filters('wataco_contact_info', array(
        'address_1' => function_exists('pll__') ? pll__('Address 1 (HQ)') : '',
        'address_2' => function_exists('pll__') ? pll__('Address 2 (Branch)') : '',
        'email'     => $global['email'],
        'phone'     => $global['phone'],
    ));
}

/**
 * Helper: Get Current Year
 *
 * @return string Current year in 4-digit format
 */
function wataco_get_current_year() {
    return date('Y');
}

/**
 * Helper: Get Contact Page URL
 *
 * @return string Contact page URL
 */
function wataco_get_contact_page_url() {
    return wataco_get_global_contact_info()['zalo'];
}

/**
 * Helper: Get Privacy Page URL
 *
 * @return string Privacy policy page URL
 */
function wataco_get_privacy_page_url() {
    return home_url('/privacy/');
}

/**
 * Helper: Get Terms Page URL
 *
 * @return string Terms and conditions page URL
 */
function wataco_get_terms_page_url() {
    return home_url('/terms/');
}

/**
 * ACF Local JSON
 */
add_filter('acf/settings/save_json', function ($path) {
    return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});
