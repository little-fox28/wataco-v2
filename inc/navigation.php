<?php
/**
 * Navigation and routing helpers.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Resolve active language token for menu cache keys.
 *
 * @return string
 */
function wataco_get_menu_cache_language_token() {
    if (function_exists('pll_current_language')) {
        $polylang_language = (string) pll_current_language('slug');
        if ($polylang_language !== '') {
            return sanitize_key($polylang_language);
        }
    }

    return sanitize_key((string) determine_locale());
}

/**
 * Get current menu cache version.
 *
 * @return int
 */
function wataco_get_nav_menu_cache_version() {
    $cache_version = (int) get_option('wataco_nav_menu_cache_version', 1);

    return $cache_version > 0 ? $cache_version : 1;
}

/**
 * Invalidate all cached menu markup by bumping cache version.
 *
 * @return void
 */
function wataco_bump_nav_menu_cache_version($unused = null, $unused_2 = null) {
    update_option(
        'wataco_nav_menu_cache_version',
        wataco_get_nav_menu_cache_version() + 1,
        false
    );
}
add_action('wp_update_nav_menu', 'wataco_bump_nav_menu_cache_version');
add_action('wp_delete_nav_menu', 'wataco_bump_nav_menu_cache_version');
add_action('update_option_nav_menu_options', 'wataco_bump_nav_menu_cache_version', 10, 2);
add_action('update_option_theme_mods_' . get_stylesheet(), 'wataco_bump_nav_menu_cache_version', 10, 2);

/**
 * Render and cache a nav menu's final HTML output.
 *
 * @param array<string, mixed> $args wp_nav_menu arguments.
 * @return string
 */
function wataco_get_cached_nav_menu_markup($args) {
    $menu_args = wp_parse_args(
        $args,
        array(
            'theme_location' => '',
            'echo'           => false,
            'fallback_cb'    => false,
        )
    );

    $language_token = wataco_get_menu_cache_language_token();
    $theme_location = sanitize_key((string) ($menu_args['theme_location'] ?? ''));
    $cache_version = wataco_get_nav_menu_cache_version();
    $cache_context = array(
        'theme_location' => $theme_location,
        'menu_class'     => (string) ($menu_args['menu_class'] ?? ''),
        'items_wrap'     => (string) ($menu_args['items_wrap'] ?? ''),
        'depth'          => (int) ($menu_args['depth'] ?? 1),
        'link_before'    => (string) ($menu_args['link_before'] ?? ''),
        'link_after'     => (string) ($menu_args['link_after'] ?? ''),
        'link_localizer' => 'v1',
        'lang'           => $language_token,
    );
    $cache_suffix = substr(md5(wp_json_encode($cache_context)), 0, 12);
    $transient_key = sprintf(
        'wataco_nav_menu_%s_%s_v%d_%s',
        $theme_location !== '' ? $theme_location : 'default',
        $language_token,
        $cache_version,
        $cache_suffix
    );

    $cached_menu_markup = get_transient($transient_key);
    if (is_string($cached_menu_markup) && $cached_menu_markup !== '') {
        return $cached_menu_markup;
    }

    $menu_markup = wp_nav_menu($menu_args);
    if (!is_string($menu_markup) || $menu_markup === '') {
        return '';
    }

    $cache_ttl = (int) apply_filters('wataco_nav_menu_cache_ttl', 6 * HOUR_IN_SECONDS, $menu_args);
    if ($cache_ttl < MINUTE_IN_SECONDS) {
        $cache_ttl = 6 * HOUR_IN_SECONDS;
    }

    set_transient($transient_key, $menu_markup, $cache_ttl);

    return $menu_markup;
}

/**
 * Resolve current-language posts page URL (Polylang-aware).
 *
 * @return string
 */
function wataco_get_localized_posts_page_url() {
    $posts_page_id = (int) get_option('page_for_posts');
    if ($posts_page_id <= 0) {
        return '';
    }

    $target_page_id = $posts_page_id;
    if (function_exists('pll_current_language') && function_exists('pll_get_post')) {
        $current_language = (string) pll_current_language('slug');
        if ($current_language !== '') {
            $translated_page_id = (int) pll_get_post($posts_page_id, $current_language);
            if ($translated_page_id > 0) {
                $target_page_id = $translated_page_id;
            }
        }
    }

    $permalink = get_permalink($target_page_id);
    return is_string($permalink) ? $permalink : '';
}

/**
 * Determine whether nav menu item points to the configured posts page.
 *
 * @param WP_Post $item Menu item object.
 * @return bool
 */
function wataco_is_posts_page_menu_item($item) {
    if (!$item instanceof WP_Post) {
        return false;
    }

    $posts_page_id = (int) get_option('page_for_posts');
    if ($posts_page_id <= 0) {
        return false;
    }

    $candidate_ids = array($posts_page_id);
    if (function_exists('pll_get_post_translations')) {
        $translations = pll_get_post_translations($posts_page_id);
        if (is_array($translations)) {
            foreach ($translations as $translation_id) {
                $candidate_ids[] = (int) $translation_id;
            }
        }
    }

    $menu_object_id = isset($item->object_id) ? (int) $item->object_id : 0;
    $menu_object = isset($item->object) ? (string) $item->object : '';

    return $menu_object === 'page' && in_array($menu_object_id, array_unique($candidate_ids), true);
}

/**
 * Force primary menu posts-page item to current-language URL.
 *
 * @param array<string,string> $atts Anchor attributes.
 * @param WP_Post              $item Menu item object.
 * @param stdClass             $args Menu args.
 * @param int                  $depth Menu depth.
 * @return array<string,string>
 */
function wataco_primary_menu_posts_link_attributes($atts, $item, $args, $depth) {
    if (empty($args->theme_location) || $args->theme_location !== 'primary_menu') {
        return $atts;
    }

    if (!wataco_is_posts_page_menu_item($item)) {
        return $atts;
    }

    $localized_posts_url = wataco_get_localized_posts_page_url();
    if ($localized_posts_url === '') {
        return $atts;
    }

    $atts['href'] = esc_url($localized_posts_url);
    return $atts;
}
add_filter('nav_menu_link_attributes', 'wataco_primary_menu_posts_link_attributes', 20, 4);

/**
 * Resolve page-part slug from current page context.
 *
 * Priority:
 * 1. Assigned page template name (template-*.php => parts/pages/*.php).
 * 2. Current page slug.
 * 3. Polylang translated page slugs.
 *
 * @param WP_Post|int|null $page Page object or page ID.
 * @return string
 */
function wataco_resolve_page_part_slug($page = null) {
    $page_post = get_post($page);
    if (!$page_post instanceof WP_Post || $page_post->post_type !== 'page') {
        return '';
    }

    $candidates = array();
    $template_slug = (string) get_page_template_slug($page_post);
    if ('' !== $template_slug) {
        $template_base = basename($template_slug, '.php');
        if (0 === strpos($template_base, 'template-')) {
            $candidates[] = substr($template_base, 9);
        }
    }

    if ('' !== (string) $page_post->post_name) {
        $candidates[] = sanitize_title((string) $page_post->post_name);
    }

    if (function_exists('pll_get_post_translations')) {
        $translations = pll_get_post_translations((int) $page_post->ID);
        if (is_array($translations)) {
            foreach ($translations as $translation_id) {
                $translated_slug = get_post_field('post_name', (int) $translation_id);
                if (is_string($translated_slug) && '' !== $translated_slug) {
                    $candidates[] = sanitize_title($translated_slug);
                }
            }
        }
    }

    $candidates = array_values(array_unique(array_filter($candidates)));

    foreach ($candidates as $candidate) {
        if ('' !== locate_template('parts/pages/' . $candidate . '.php', false, false)) {
            return $candidate;
        }
    }

    return '';
}

/**
 * Fallback Menu for Footer
 *
 * Displays default footer links when no menu is assigned to 'footer_menu' location.
 * Provides safe fallback with all strings translated via pll__().
 *
 * @return void
 */
function wataco_footer_menu_fallback() {
    ?>
    <ul class="space-y-4 text-sm text-gray-400">
        <li><a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('About Us')); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/careers/')); ?>" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('Careers')); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/news/')); ?>" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('News')); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/projects/')); ?>" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('Projects')); ?></a></li>
    </ul>
    <?php
}

/**
 * Build footer nav menu args with Tailwind-compatible output.
 *
 * @param string $theme_location Menu location.
 * @param string|false $fallback_callback Fallback callback.
 * @return array<string, mixed>
 */
function wataco_get_footer_nav_menu_args($theme_location = 'footer_about_menu', $fallback_callback = 'wataco_footer_menu_fallback') {
    $menu_args = array(
        'theme_location' => $theme_location,
        'container'      => false,
        'menu_id'        => '',
        'menu_class'     => '',
        'fallback_cb'    => $fallback_callback,
        'items_wrap'     => '<ul class="space-y-4 text-sm text-gray-400">%3$s</ul>',
        'depth'          => 1,
        'link_before'    => '',
        'link_after'     => '',
    );

    return apply_filters('wataco_footer_nav_menu_args', $menu_args, $theme_location, $fallback_callback);
}

/**
 * Remove default LI classes from footer menu output.
 *
 * @param array<int, string> $classes Menu item classes.
 * @param WP_Post            $item Menu item data.
 * @param stdClass           $args Menu args.
 * @return array<int, string>
 */
function wataco_footer_menu_item_classes($classes, $item, $args) {
    $footer_locations = array('footer_menu', 'footer_about_menu', 'footer_solutions_menu');
    if (empty($args->theme_location) || !in_array($args->theme_location, $footer_locations, true)) {
        return $classes;
    }

    return array();
}
add_filter('nav_menu_css_class', 'wataco_footer_menu_item_classes', 10, 3);

/**
 * Remove default LI IDs from footer menu output.
 *
 * @param string    $menu_id Menu item ID.
 * @param WP_Post   $item Menu item data.
 * @param stdClass  $args Menu args.
 * @return string
 */
function wataco_footer_menu_item_id($menu_id, $item, $args) {
    $footer_locations = array('footer_menu', 'footer_about_menu', 'footer_solutions_menu');
    if (empty($args->theme_location) || !in_array($args->theme_location, $footer_locations, true)) {
        return $menu_id;
    }

    return '';
}
add_filter('nav_menu_item_id', 'wataco_footer_menu_item_id', 10, 3);

/**
 * Add Tailwind anchor classes to footer menu links.
 *
 * @param array<string, string> $atts Menu link attributes.
 * @param WP_Post               $item Menu item data.
 * @param stdClass              $args Menu args.
 * @param int                   $depth Menu depth.
 * @return array<string, string>
 */
function wataco_footer_menu_link_attributes($atts, $item, $args, $depth) {
    $footer_locations = array('footer_menu', 'footer_about_menu', 'footer_solutions_menu');
    if (empty($args->theme_location) || !in_array($args->theme_location, $footer_locations, true)) {
        return $atts;
    }

    $class_name = 'hover:text-[#FFD700] transition-colors';
    if (!empty($atts['class'])) {
        $class_name = trim($atts['class'] . ' ' . $class_name);
    }

    $atts['class'] = $class_name;

    return $atts;
}
add_filter('nav_menu_link_attributes', 'wataco_footer_menu_link_attributes', 10, 4);
