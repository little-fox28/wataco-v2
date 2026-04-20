<?php

if (is_file(__DIR__.'/vendor/autoload_packages.php')) {
    require_once __DIR__.'/vendor/autoload_packages.php';
}

function tailpress(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance()
        ->assets(fn($manager) => $manager
            ->withCompiler(new TailPress\Framework\Assets\ViteCompiler, fn($compiler) => $compiler
                ->registerAsset('resources/css/app.css')
                ->registerAsset('resources/js/app.js')
                ->editorStyleFile('resources/css/editor-style.css')
            )
            ->enqueueAssets()
        )
        ->features(fn($manager) => $manager->add(TailPress\Framework\Features\MenuOptions::class))
        ->menus(fn($manager) => $manager->add('primary', __( 'Primary Menu', 'tailpress')))
        ->themeSupport(fn($manager) => $manager->add([
            'title-tag',
            'custom-logo',
            'post-thumbnails',
            'align-wide',
            'wp-block-styles',
            'responsive-embeds',
            'html5' => [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        ]));
}

tailpress();

/**
 * Keep generated image sizes lean for constrained storage environments.
 *
 * @param array<string, array<string, int|string>> $sizes Generated intermediate sizes.
 * @return array<string, array<string, int|string>>
 */
function wataco_limit_intermediate_image_sizes($sizes) {
    $allowed_sizes = array(
        'thumbnail' => true,
        'medium'    => true,
        'large'     => true,
    );

    return array_intersect_key($sizes, $allowed_sizes);
}
add_filter('intermediate_image_sizes_advanced', 'wataco_limit_intermediate_image_sizes');
add_filter('big_image_size_threshold', '__return_false');

/**
 * Register Navigation Menus
 * 
 * Registers custom menu locations for use in theme.
 */
function wataco_register_menus() {
    register_nav_menus(
        array(
            'primary_menu'          => __('Primary Navigation Menu', 'wataco'),
            'footer_menu'           => __('Footer Navigation Menu', 'wataco'),
            'footer_solutions_menu' => __('Footer Solutions Menu', 'wataco'),
            'footer_about_menu'     => __('Footer About Menu', 'wataco'),
        )
    );
}
add_action('after_setup_theme', 'wataco_register_menus');

/**
 * Register Polylang Translatable Strings
 * 
 * Registers UI strings for translation across multiple languages.
 * Requires Polylang plugin to be active.
 */
function wataco_register_polylang_strings() {
    if (!function_exists('pll_register_string')) {
        return;
    }
    $polylang_languages = 'en_US|vi|ja';

    $header_strings = array(
        'Home',
        'Projects',
        'Careers',
        'News',
        'About Us',
        'Get Quote',
    );

    $footer_strings = array(
        'Tiêu đề footer cột 2',
        'Tiêu đề footer cột 3',
        'Tiêu đề footer cột 4',
        'Company Description',
        'Address 1 (HQ)',
        'Address 2 (Branch)',
        'About Us',
        'Careers',
        'News',
        'Projects',
        'Address',
        'Email',
        'Phone',
        'All rights reserved',
        'Privacy',
        'Terms',
        '© %1$s %2$s. All rights reserved',
    );

    $floating_strings = array(
        'Facebook',
        'Chat Zalo',
        'Call Us',
    );

    foreach ($header_strings as $string) {
        pll_register_string('wataco_header_' . sanitize_title($string), $string, $polylang_languages);
    }

    foreach ($footer_strings as $string) {
        pll_register_string('wataco_footer_' . sanitize_title($string), $string, $polylang_languages);
    }

    foreach ($floating_strings as $string) {
        pll_register_string('wataco_floating_' . sanitize_title($string), $string, $polylang_languages);
    }
}
add_action('init', 'wataco_register_polylang_strings', 5);

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
                    'value' => 'template-theme-settings.php',
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
 * Register Theme Settings options page for ACF.
 *
 * @return void
 */
function wataco_register_theme_settings_options_page() {
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page(array(
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ));
}
add_action('acf/init', 'wataco_register_theme_settings_options_page', 5);

/**
 * Initialize Theme Options
 * 
 * Stores default contact and social information in wp_options.
 * Values can be overridden in WordPress admin or programmatically.
 */
function wataco_init_theme_options() {
    // Floating Contact Information
    if (!get_option('wataco_floating_contacts')) {
        $floating_contacts = array(
            'facebook' => 'https://www.facebook.com/wataco',
            'zalo'     => 'https://zalo.me/0786788837',
            'phone'    => '0786788837'
        );
        add_option('wataco_floating_contacts', $floating_contacts);
    }

    // Social Links (Footer)
    if (!get_option('wataco_social_links')) {
        $social_links = array(
            'linkedin'  => 'https://linkedin.com/company/wataco',
            'facebook'  => 'https://www.facebook.com/wataco',
            'zalo'      => 'https://zalo.me/0786788837',
            'tiktok'    => '',
            'youtube'   => 'https://youtube.com/@wataco'
        );
        add_option('wataco_social_links', $social_links);
    }

    // Contact Information (Footer)
    if (!get_option('wataco_contact_info')) {
        $contact_info = array(
            'address_1' => '123 Main Street, Ho Chi Minh City, Vietnam',
            'address_2' => '456 Tech Boulevard, District 1, HCM City',
            'email'     => 'info@wataco.dev',
            'phone'     => '0786788837'
        );
        add_option('wataco_contact_info', $contact_info);
    }
}
add_action('init', 'wataco_init_theme_options', 1);

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

    $footer_data = array(
        'global_logo_id'            => (int) wataco_get_theme_settings_field('global_logo', 0),
        'faded_background_logo_id'  => (int) wataco_get_theme_settings_field('faded_background_logo', 0),
        'email'                     => (string) wataco_get_theme_settings_option_field('email', wataco_get_theme_settings_field('email', '')),
        'phone'                     => (string) wataco_get_theme_settings_option_field('phone', wataco_get_theme_settings_field('phone', '')),
        'linkedin'                  => (string) wataco_get_theme_settings_option_field('linkedin', wataco_get_theme_settings_field('linkedin', '')),
        'facebook'                  => (string) wataco_get_theme_settings_option_field('facebook', wataco_get_theme_settings_field('facebook', '')),
        'zalo'                      => (string) wataco_get_theme_settings_option_field('zalo', wataco_get_theme_settings_field('zalo', '')),
        'tiktok'                    => (string) wataco_get_theme_settings_option_field('tiktok', wataco_get_theme_settings_field('tiktok', '')),
        'youtube'                   => (string) wataco_get_theme_settings_option_field('youtube', wataco_get_theme_settings_field('youtube', '')),
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
 * Get first available Theme Settings value from candidate field names.
 *
 * @param array<mixed>  $field_names Candidate field names.
 * @param mixed|string  $default_value Optional default value.
 * @return mixed|string
 */
function wataco_get_theme_settings_value(array $field_names, $default_value = '') {
    foreach ($field_names as $field_name) {
        $value = wataco_get_theme_settings_field((string) $field_name, null);
        if (null !== $value && false !== $value && '' !== $value) {
            return $value;
        }
    }

    return $default_value;
}

/**
 * Helper: Get Floating Contact Information
 * 
 * @return array Contact information array with facebook, zalo, and phone keys
 */
function wataco_get_floating_contacts() {
    return get_option('wataco_floating_contacts', array());
}

/**
 * Helper: Get Social Links
 * 
 * @return array Social links array with linkedin, facebook, and youtube keys
 */
function wataco_get_social_links() {
    $default_social_links = get_option('wataco_social_links', array());
    $linkedin_option = (string) wataco_get_theme_settings_option_field('linkedin', '');
    $facebook_option = (string) wataco_get_theme_settings_option_field('facebook', '');
    $zalo_option = (string) wataco_get_theme_settings_option_field('zalo', '');
    $tiktok_option = (string) wataco_get_theme_settings_option_field('tiktok', '');
    $youtube_option = (string) wataco_get_theme_settings_option_field('youtube', '');

    return array(
        'linkedin' => $linkedin_option !== '' ? $linkedin_option : wataco_get_theme_settings_value(
            array('social_linkedin', 'footer_social_linkedin', 'linkedin_url', 'linkedin'),
            $default_social_links['linkedin'] ?? ''
        ),
        'facebook' => $facebook_option !== '' ? $facebook_option : wataco_get_theme_settings_value(
            array('social_facebook', 'footer_social_facebook', 'facebook_url', 'facebook'),
            $default_social_links['facebook'] ?? ''
        ),
        'zalo'     => $zalo_option !== '' ? $zalo_option : wataco_get_theme_settings_value(
            array('social_zalo', 'footer_social_zalo', 'zalo_url', 'zalo'),
            $default_social_links['zalo'] ?? ''
        ),
        'tiktok'   => $tiktok_option !== '' ? $tiktok_option : wataco_get_theme_settings_value(
            array('social_tiktok', 'footer_social_tiktok', 'tiktok_url', 'tiktok'),
            $default_social_links['tiktok'] ?? ''
        ),
        'youtube'  => $youtube_option !== '' ? $youtube_option : wataco_get_theme_settings_value(
            array('social_youtube', 'footer_social_youtube', 'youtube_url', 'youtube'),
            $default_social_links['youtube'] ?? ''
        ),
    );
}

/**
 * Helper: Get Contact Information
 * 
 * @return array Contact info array with address_1, address_2, email, and phone keys
 */
function wataco_get_contact_info() {
    $default_contact_info = get_option('wataco_contact_info', array());
    $address_1 = function_exists('pll__') ? pll__('Address 1 (HQ)') : '';
    $address_2 = function_exists('pll__') ? pll__('Address 2 (Branch)') : '';
    $email_option = (string) wataco_get_theme_settings_option_field('email', '');
    $phone_option = (string) wataco_get_theme_settings_option_field('phone', '');

    return apply_filters('wataco_contact_info', array(
        'address_1' => $address_1,
        'address_2' => $address_2,
        'email'     => $email_option !== '' ? $email_option : wataco_get_theme_settings_value(
            array('contact_email', 'footer_email', 'email'),
            $default_contact_info['email'] ?? ''
        ),
        'phone'     => $phone_option !== '' ? $phone_option : wataco_get_theme_settings_value(
            array('contact_phone', 'footer_phone', 'phone'),
            $default_contact_info['phone'] ?? ''
        ),
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
    return home_url('/contact/');
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

/**
 * Output RankMath JSON-LD Schema
 * 
 * Generates Organization and WebSite schema with:
 * - Company name, logo, and description
 * - Contact information
 * - Social media profiles
 * - SEO-optimized structure for RankMath
 * 
 * @return void
 */
function wataco_output_footer_schema() {
    if (!function_exists('wp_kses_post')) {
        return;
    }

    $social_links = wataco_get_social_links();
    $contact_info = wataco_get_contact_info();
    
    $logo_id = get_theme_mod('custom_logo');
    $logo_url = $logo_id ? wp_get_attachment_url($logo_id) : '';
    
    $schema = array(
        '@context'      => 'https://schema.org',
        '@type'         => 'Organization',
        'name'          => get_bloginfo('name'),
        'url'           => esc_url(home_url('/')),
        'description'   => get_bloginfo('description'),
    );

    if ($logo_url) {
        $schema['logo'] = esc_url($logo_url);
    }

    if (!empty($contact_info['email']) || !empty($contact_info['phone'])) {
        $contact_point = array(
            '@type' => 'ContactPoint',
            'contactType' => 'Customer Support',
        );
        
        if (!empty($contact_info['email'])) {
            $contact_point['email'] = esc_attr($contact_info['email']);
        }
        
        if (!empty($contact_info['phone'])) {
            $contact_point['telephone'] = esc_attr($contact_info['phone']);
        }

        $schema['contactPoint'] = $contact_point;
    }

    if (!empty($contact_info['address_1'])) {
        $schema['address'] = array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => $contact_info['address_1'],
            'addressCountry'  => 'VN',
        );
    }

    $same_as = array();
    if (!empty($social_links['linkedin'])) {
        $same_as[] = esc_url($social_links['linkedin']);
    }
    if (!empty($social_links['facebook'])) {
        $same_as[] = esc_url($social_links['facebook']);
    }
    if (!empty($social_links['youtube'])) {
        $same_as[] = esc_url($social_links['youtube']);
    }

    if (!empty($same_as)) {
        $schema['sameAs'] = $same_as;
    }

    // Output JSON-LD script tag
    echo '<script type="application/ld+json">';
    echo wp_json_encode($schema);
    echo '</script>';
}

/**
 * Hook into wp_head to output footer schema in document head
 * 
 * Adds Organization schema to <head> for better SEO recognition
 */
function wataco_add_footer_schema_to_head() {
    wataco_output_footer_schema();
}
add_action('wp_head', 'wataco_add_footer_schema_to_head', 99);
