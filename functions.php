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
    pll_register_string('wataco_header', 'Home');
    pll_register_string('wataco_header', 'Projects');
    pll_register_string('wataco_header', 'Careers');
    pll_register_string('wataco_header', 'News');
    pll_register_string('wataco_header', 'About Us');
    pll_register_string('wataco_header', 'Get Quote');

    // Footer Column Headers
    pll_register_string('wataco_footer', 'Solutions');
    pll_register_string('wataco_footer', 'Company');
    pll_register_string('wataco_footer', 'Contact');

    // Footer Solutions Items
    pll_register_string('wataco_footer', 'Web Development');
    pll_register_string('wataco_footer', 'Mobile Apps');
    pll_register_string('wataco_footer', 'Cloud Services');
    pll_register_string('wataco_footer', 'Consulting');

    // Footer Company Links
    pll_register_string('wataco_footer', 'About Us');
    pll_register_string('wataco_footer', 'Careers');
    pll_register_string('wataco_footer', 'News');
    pll_register_string('wataco_footer', 'Projects');

    // Footer Contact Labels
    pll_register_string('wataco_footer', 'Address');
    pll_register_string('wataco_footer', 'Email');
    pll_register_string('wataco_footer', 'Phone');

    // Footer Copyright and Legal
    pll_register_string('wataco_footer', 'All rights reserved');
    pll_register_string('wataco_footer', 'Privacy');
    pll_register_string('wataco_footer', 'Terms');

    // Footer Social Media Aria-Labels
    pll_register_string('wataco_footer', 'Visit us on LinkedIn');
    pll_register_string('wataco_footer', 'Visit us on Facebook');
    pll_register_string('wataco_footer', 'Visit us on YouTube');

    // Floating Contact Strings
    pll_register_string('wataco_floating', 'Facebook');
    pll_register_string('wataco_floating', 'Chat Zalo');
    pll_register_string('wataco_floating', 'Hotline: 078.678.8837');
    pll_register_string('wataco_floating', 'Call Us');
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
