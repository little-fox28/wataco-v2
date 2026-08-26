<?php

/**
 * Logo Component Template Part
 * 
 * Reusable logo component for header, footer, and other locations.
 * Uses WordPress Customizer for logo management.
 * Aligned with React WatacoLogo.tsx component.
 * 
 * @package Wataco
 * @param string $class Optional additional CSS classes for the wrapper link
 * @param bool $show_branding Optional. Whether to show branding text (default: true for header)
 */

// Don't load directly
if (!defined('ABSPATH')) {
    exit;
}

// Get parameters
$class = $args['class'] ?? '';
$show_branding = $args['show_branding'] ?? true;

// 1. Check Customizer logo
$custom_logo_id = get_theme_mod('custom_logo');

// 2. Check ACF Theme Settings logo (if configured)
if (!$custom_logo_id && function_exists('wataco_get_theme_settings_field')) {
    $custom_logo_id = wataco_get_theme_settings_field('global_logo');
}

$logo_url = '';
$logo_alt = '';

if ($custom_logo_id) {
    $logo_url = is_numeric($custom_logo_id) ? wp_get_attachment_image_url((int) $custom_logo_id, 'full') : $custom_logo_id;
    $logo_alt = is_numeric($custom_logo_id) ? get_post_meta((int) $custom_logo_id, '_wp_attachment_image_alt', true) : '';
}

if (empty($logo_url)) {
    $logo_url = get_theme_file_uri('assets/images/wataco-logo.webp');
}

if (empty($logo_alt)) {
    $logo_alt = get_bloginfo('name');
}
?>

<div class="shrink-0">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center space-x-3 hover:opacity-90 transition-opacity <?php echo esc_attr($class); ?>">
        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>" class="h-10 w-15 lg:h-12 lg:w-16 object-contain">

        <?php if ($show_branding) : ?>
            <div class="flex flex-col">
                <span class="text-lg lg:text-xl font-black tracking-tighter leading-none text-white font-heading">WATACO</span>
                <span class="text-[6px] lg:text-[8px] text-white font-bold tracking-[0.2em] uppercase mt-1">Member of Watanabe Create Group</span>
            </div>
        <?php endif; ?>
    </a>
</div>