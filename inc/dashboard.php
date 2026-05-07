<?php
/**
 * WordPress Dashboard & Admin Menu customization.
 *
 * Manage Yoast SEO access, Polylang permissions for Editors, and clean admin UI.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * -----------------------------------------------------------
 * 1. BLOCK YOAST SEO (RESTRICT PERMISSIONS)
 * -----------------------------------------------------------
 */

/**
 * Restrict Yoast SEO to Administrators (activate_plugins).
 *
 * @return string
 */
add_filter('wpseo_manage_options_capability', 'wataco_lock_yoast_for_admin');
function wataco_lock_yoast_for_admin() {
    return 'activate_plugins';
}

// Lazy-load Yoast to reduce memory usage on non-admin pages.
add_action('init', function() {
    if (!is_admin() && !wp_doing_ajax()) {
        add_filter('option_wpseo_ms_deny_wpseo_dashglobe', '__return_true');
    }
}, 1);

/**
 * Remove Yoast menu using priority 999 (sufficient for most cases, reduces load).
 *
 * @return void
 */
add_action('admin_menu', 'wataco_force_hide_yoast', 999);
function wataco_force_hide_yoast() {
    // Cache the capability check to avoid repeated permission lookups.
    static $can_activate;
    if ($can_activate === null) {
        $can_activate = current_user_can('activate_plugins');
    }
    
    if (!$can_activate) {
        remove_menu_page('wpseo_dashboard');
        remove_menu_page('wpseo_workouts');
    }
}

/**
 * Hide Yoast icon from the Admin Bar.
 *
 * @return void
 */
add_action('wp_before_admin_bar_render', 'wataco_remove_yoast_admin_bar');
function wataco_remove_yoast_admin_bar() {
    if (!is_admin_bar_showing()) {
        return;
    }
    
    global $wp_admin_bar;
    
    // Cache capability check.
    static $can_activate;
    if ($can_activate === null) {
        $can_activate = current_user_can('activate_plugins');
    }
    
    if (!$can_activate && isset($wp_admin_bar)) {
        $wp_admin_bar->remove_menu('wpseo-menu');
    }
}

/**
 * -----------------------------------------------------------
 * 2. POLYLANG - GRANT PERMISSIONS FOR EDITORS
 * -----------------------------------------------------------
 */

/**
 * Display Polylang menu for the Editor role.
 *
 * @return void
 */
add_action('admin_menu', 'wataco_show_polylang_for_editor', 999);
function wataco_show_polylang_for_editor() {
    // Cache capability checks to reduce database queries.
    static $is_editor, $is_admin;
    if ($is_editor === null) {
        $is_editor = current_user_can('edit_others_posts');
        $is_admin = current_user_can('activate_plugins');
    }

    if ($is_editor && !$is_admin) {
        global $menu, $submenu;

        if (!empty($menu)) {
            foreach ($menu as $key => $item) {
                if (isset($item[2]) && $item[2] === 'mlang') {
                    $menu[$key][1] = 'edit_others_posts';
                    break;
                }
            }
        }

        if (!empty($submenu['mlang'])) {
            foreach ($submenu['mlang'] as $key => $item) {
                $submenu['mlang'][$key][1] = 'edit_others_posts';
            }
        }
    }
}

/**
 * Grant virtual capabilities to allow Editor access to Polylang.
 * Optimized: Early exit for non-editors and sanitize superglobals.
 *
 * @param array<string, bool> $allcaps     All capabilities.
 * @param array<string>       $caps        Required capabilities.
 * @param array<mixed>        $args        Arguments.
 * @param object              $user        User object.
 * @return array<string, bool>
 */
add_filter('user_has_cap', 'wataco_polylang_virtual_cap', 10, 4);
function wataco_polylang_virtual_cap($allcaps, $caps, $args, $user) {
    // Early exit if not an editor or already an admin.
    if (empty($allcaps['edit_others_posts']) || !empty($allcaps['activate_plugins'])) {
        return $allcaps;
    }

    $is_mlang_page = false;
    $is_mlang_ajax = false;

    // Only check in admin context.
    if (is_admin()) {
        if (!empty($_GET['page']) && strpos(sanitize_text_field(wp_unslash($_GET['page'])), 'mlang') === 0) {
            $is_mlang_page = true;
        }
    }

    // Check AJAX requests only if actually doing AJAX.
    if (wp_doing_ajax()) {
        if (!empty($_POST['action']) && strpos(sanitize_text_field(wp_unslash($_POST['action'])), 'pll_') !== false) {
            $is_mlang_ajax = true;
        }
    }

    if ($is_mlang_page || $is_mlang_ajax) {
        $allcaps['manage_options'] = true;
    }

    return $allcaps;
}

/**
 * Clean up unnecessary menus for Editor role.
 * Use priority 999 (sufficient for most cases, reduces overhead).
 */
add_action( 'admin_menu', 'wataco_force_hide_menus_on_polylang', 999 );
function wataco_force_hide_menus_on_polylang() {
    // Cache capability checks to avoid repeated database queries.
    static $is_editor, $is_admin;
    if ($is_editor === null) {
        $is_editor = current_user_can('edit_others_posts');
        $is_admin = current_user_can('activate_plugins');
    }

    // Early exit for non-editors or admins.
    if (!$is_editor || $is_admin) {
        return;
    }

    // Define menus to hide once (reduces memory allocation).
    static $menus_to_hide = [
        'edit.php?post_type=acf-field-group',
        'media-cloud',
        'ilab-media-cloud',
        'options-general.php',
        'themes.php',
    ];

    foreach ($menus_to_hide as $menu_slug) {
        remove_menu_page($menu_slug);
    }
}

/**
 * Remove Media Cloud menu items for Editor role.
 * Optimized: Use priority 999 (sufficient), cache checks, early exit.
 */
add_action( 'admin_menu', 'wataco_nuke_media_cloud_menu', 999 );
function wataco_nuke_media_cloud_menu() {
    // Cache capability checks.
    static $is_editor, $is_admin;
    if ($is_editor === null) {
        $is_editor = current_user_can('edit_others_posts');
        $is_admin = current_user_can('activate_plugins');
    }

    // Early exit for non-editors or admins.
    if (!$is_editor || $is_admin) {
        return;
    }

    global $menu;

    // Only process if menu array exists and is not empty.
    if (empty($menu) || !is_array($menu)) {
        return;
    }

    // Cache keywords to search for, reducing string comparisons.
    static $search_keywords = ['Media Cloud', 'MCS'];

    foreach ($menu as $index => $item) {
        // Skip if item title doesn't exist.
        if (empty($item[0])) {
            continue;
        }

        // Check if any keyword matches; remove if found.
        foreach ($search_keywords as $keyword) {
            if (strpos($item[0], $keyword) !== false) {
                unset($menu[$index]);
                break;
            }
        }
    }
}
