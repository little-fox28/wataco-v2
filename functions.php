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
 * Register Navigation Menus
 * 
 * Registers custom menu locations for use in theme.
 */
function wataco_register_menus() {
    register_nav_menu('primary_menu', __('Primary Navigation Menu', 'wataco'));
    register_nav_menu('footer_menu', __('Footer Navigation Menu', 'wataco'));
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

    // Header Navigation Strings
    pll_register_string('wataco_header', 'Home', 'en_US|vi|ja');
    pll_register_string('wataco_header', 'Projects', 'en_US|vi|ja');
    pll_register_string('wataco_header', 'Careers', 'en_US|vi|ja');
    pll_register_string('wataco_header', 'News', 'en_US|vi|ja');
    pll_register_string('wataco_header', 'About Us', 'en_US|vi|ja');
    pll_register_string('wataco_header', 'Get Quote', 'en_US|vi|ja');

    // Footer Strings
    pll_register_string('wataco_footer', 'Solutions', 'en_US|vi|ja');
    pll_register_string('wataco_footer', 'Company', 'en_US|vi|ja');
    pll_register_string('wataco_footer', 'Contact', 'en_US|vi|ja');
    pll_register_string('wataco_footer', 'Address', 'en_US|vi|ja');
    pll_register_string('wataco_footer', 'Email', 'en_US|vi|ja');
    pll_register_string('wataco_footer', 'Phone', 'en_US|vi|ja');
    pll_register_string('wataco_footer', 'Privacy', 'en_US|vi|ja');
    pll_register_string('wataco_footer', 'Terms', 'en_US|vi|ja');
    pll_register_string('wataco_footer', 'All rights reserved', 'en_US|vi|ja');
    pll_register_string('wataco_footer', 'Follow Us', 'en_US|vi|ja');

    // Floating Contact Strings
    pll_register_string('wataco_floating', 'Facebook', 'en_US|vi|ja');
    pll_register_string('wataco_floating', 'Chat Zalo', 'en_US|vi|ja');
    pll_register_string('wataco_floating', 'Hotline: 078.678.8837', 'en_US|vi|ja');
    pll_register_string('wataco_floating', 'Call Us', 'en_US|vi|ja');
}
add_action('init', 'wataco_register_polylang_strings', 5);

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
    return get_option('wataco_social_links', array());
}

/**
 * Helper: Get Contact Information
 * 
 * @return array Contact info array with address_1, address_2, email, and phone keys
 */
function wataco_get_contact_info() {
    return get_option('wataco_contact_info', array());
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
