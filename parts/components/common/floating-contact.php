<?php
/**
 * Floating Contact Buttons Template
 * 
 * @package Wataco
 */

// Don't load directly
if (!defined('ABSPATH')) {
    exit;
}

$contact_info = wataco_get_global_contact_info();

$facebook_url = $contact_info['facebook'];
$zalo_url     = $contact_info['zalo'];
$phone        = $contact_info['phone'];
$phone_href   = $contact_info['phone_clean'];

if (empty($facebook_url) && empty($zalo_url) && empty($phone_href)) {
    return;
}
?>

<div class="fixed bottom-6 right-6 z-50 flex flex-col gap-4"
     x-data="{ showButtons: true }"
     data-floating-contact>

    <!-- Facebook Button -->
    <?php if (!empty($facebook_url)) : ?>
        <a href="<?php echo esc_url($facebook_url); ?>"
           target="_blank"
           rel="noopener noreferrer"
            data-button="facebook"
           aria-label="<?php esc_attr_e(pll__('Facebook')); ?>"
           class="w-14 h-14 rounded-full bg-[#1877F2] flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-300 group relative">
            <span class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-gray-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-md pointer-events-none"
                  data-tooltip="facebook">
                <?php echo esc_html(pll__('Facebook')); ?>
                <span class="absolute -right-1 top-1/2 -translate-y-1/2 border-l-4 border-l-gray-900 border-y-4 border-y-transparent"></span>
            </span>
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
            </svg>
        </a>
    <?php endif; ?>

    <!-- Zalo Button -->
    <?php if (!empty($zalo_url)) : ?>
        <a href="<?php echo esc_url($zalo_url); ?>"
           target="_blank"
           rel="noopener noreferrer"
            data-button="zalo"
           aria-label="<?php esc_attr_e(pll__('Chat Zalo')); ?>"
           class="w-14 h-14 rounded-full bg-[#0068FF] flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-300 group relative">
            <span class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-gray-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-md pointer-events-none"
                  data-tooltip="zalo">
                <?php echo esc_html(pll__('Chat Zalo')); ?>
                <span class="absolute -right-1 top-1/2 -translate-y-1/2 border-l-4 border-l-gray-900 border-y-4 border-y-transparent"></span>
            </span>
            <span class="text-white font-black text-s font-heading no-underline">Zalo</span>
        </a>
    <?php endif; ?>

    <!-- Phone Button -->
    <?php if (!empty($phone) && !empty($phone_href)) : ?>
        <a href="tel:<?php echo esc_attr($phone_href); ?>"
           data-button="phone"
           aria-label="<?php esc_attr_e(sprintf(pll__('Call Us: %s'), $phone)); ?>"
            class="w-14 h-14 rounded-full bg-[#EA580C] flex items-center justify-center shadow-lg hover:scale-110 transition-transform duration-300 group relative">
            <div class="absolute inset-0 rounded-full bg-[#EA580C] animate-ping opacity-20"></div>
            <span class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-gray-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-md pointer-events-none"
                  data-tooltip="phone">
                <?php echo esc_html(sprintf(pll__('Hotline: %s'), $phone)); ?>
                <span class="absolute -right-1 top-1/2 -translate-y-1/2 border-l-4 border-l-gray-900 border-y-4 border-y-transparent"></span>
            </span>
            <svg class="w-6 h-6 text-white fill-white relative z-10" viewBox="0 0 24 24">
                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
        </a>
    <?php endif; ?>
</div>
