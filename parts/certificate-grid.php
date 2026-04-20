<?php
/**
 * Certificate Grid Component
 * 
 * Displays a grid of ISO certification cards
 * 
 * @package Wataco Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$certificates = array(
    array(
        'src'   => get_template_directory_uri() . '/assets/images/iso/iso9001.svg',
        'title' => 'ISO 9001'
    ),
    array(
        'src'   => get_template_directory_uri() . '/assets/images/iso/iso14001.svg',
        'title' => 'ISO 14001'
    ),
    array(
        'src'   => get_template_directory_uri() . '/assets/images/iso/iso45001.svg',
        'title' => 'ISO 45001'
    ),
);
?>

<div class="grid grid-cols-3 gap-4 mt-6">
    <?php foreach ($certificates as $cert) : ?>
        <div class="bg-white rounded-lg border border-gray-100 overflow-hidden hover:shadow-xl hover:border-gray-200 transition-all duration-300 group flex flex-col items-center justify-center p-4 h-full">
            <div class="relative h-20 w-20">
                <img
                    src="<?php echo esc_url($cert['src']); ?>"
                    alt="<?php echo esc_attr($cert['title']); ?>"
                    class="h-full w-full object-contain group-hover:scale-110 transition-transform duration-300"
                    loading="lazy"
                />
            </div>
            <div class="text-center">
                <h4 class="text-[10px] font-semibold text-gray-600 font-heading tracking-wide uppercase mt-2" title="<?php echo esc_attr($cert['title']); ?>">
                    <?php echo esc_html($cert['title']); ?>
                </h4>
            </div>
        </div>
    <?php endforeach; ?>
</div>
