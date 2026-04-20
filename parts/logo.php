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
?>

<div class="shrink-0">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center space-x-3 hover:opacity-90 transition-opacity <?php echo esc_attr($class); ?>">
        <?php
        if (has_custom_logo()) {
            // Output custom logo with Tailwind styling
            $logo_id = get_theme_mod('custom_logo');
            if ($logo_id) {
                $logo_html = wp_get_attachment_image(
                    $logo_id,
                    array(130, 100),
                    false,
                    array(
                        'class' => 'h-10 w-15 lg:h-12 lg:w-16 object-contain'
                    )
                );
                echo wp_kses_post($logo_html);
            }
        } else {
            // Fallback: Display site name
            echo '<span class="text-white font-black text-lg lg:text-xl whitespace-nowrap">' . esc_html(bloginfo('name')) . '</span>';
        }
        ?>
        
        <div class="flex flex-col">
            <span class="text-lg lg:text-xl font-black tracking-tighter leading-none text-white font-heading">WATACO</span>
            <span class="text-[6px] lg:text-[8px] text-white font-bold tracking-[0.2em] uppercase mt-1">Member of Watanabe Create Group</span>
        </div>
    </a>
</div>