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
