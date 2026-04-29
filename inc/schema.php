<?php
/**
 * Structured data schema output.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
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
