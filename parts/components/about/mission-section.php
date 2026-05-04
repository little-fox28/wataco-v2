<?php
/**
 * About page mission and vision section.
 * Uses WordPress Native get_post_meta() for ACF Free data retrieval.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get ACF values using WordPress Native function (get_post_meta)
$mission_title_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), 'mission_section_title', true) : '';
$mission_title = (is_string($mission_title_raw) && '' !== trim($mission_title_raw))
    ? trim($mission_title_raw)
    : __('Strategic Direction', 'wataco');

$vision_title_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), 'mission_vision_title', true) : '';
$vision_title = (is_string($vision_title_raw) && '' !== trim($vision_title_raw))
    ? trim($vision_title_raw)
    : __('Vision', 'wataco');

$vision_desc_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), 'mission_vision_desc', true) : '';
$vision_desc = (is_string($vision_desc_raw) && '' !== trim($vision_desc_raw))
    ? trim($vision_desc_raw)
    : '';

$mission_card_title_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), 'mission_mission_title', true) : '';
$mission_card_title = (is_string($mission_card_title_raw) && '' !== trim($mission_card_title_raw))
    ? trim($mission_card_title_raw)
    : __('Mission', 'wataco');

$mission_desc_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), 'mission_mission_desc', true) : '';
$mission_desc = (is_string($mission_desc_raw) && '' !== trim($mission_desc_raw))
    ? trim($mission_desc_raw)
    : '';

$core_values_title_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), 'mission_core_values_title', true) : '';
$core_values_title = (is_string($core_values_title_raw) && '' !== trim($core_values_title_raw))
    ? trim($core_values_title_raw)
    : __('Core Values', 'wataco');

// Collect core values from incremental fields
$core_values = array();
for ($i = 1; $i <= 6; $i++) {
    $value_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), "mission_core_value_$i", true) : '';
    if (is_string($value_raw) && '' !== trim($value_raw)) {
        $core_values[] = trim($value_raw);
    }
}
?>

<section class="py-24 lg:py-40 bg-white relative overflow-hidden border-t border-gray-100" data-parallax-root>
    <div class="absolute top-1/4 -right-32 w-[38rem] h-[38rem] bg-[#228B22]/5 rounded-full blur-[120px] pointer-events-none" data-parallax="100,-100"></div>
    <div class="absolute bottom-1/4 -left-32 w-[25rem] h-[25rem] bg-[#FFD700]/10 rounded-full blur-[100px] pointer-events-none" data-parallax="-50,50"></div>

    <div class="max-w-[1440px] mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row gap-16 lg:gap-24 items-start">
            <div class="lg:w-1/3 lg:sticky lg:top-32"
                 x-data="{ shown: false }"
                 x-intersect:enter="shown = true" x-intersect:leave="shown = false"
                 class="transition-all duration-700 ease-out"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-8'">
                <span class="text-[#228B22] font-black text-xs uppercase tracking-[0.3em] mb-4 block">
                    <?php echo esc_html(__('DEVELOPMENT ORIENTATION', 'wataco')); ?>
                </span>
                <h2 class="text-4xl lg:text-5xl font-black text-[#1A2B3C] font-heading leading-tight mb-6 tracking-tight">
                    <?php echo esc_html($mission_title); ?>
                </h2>
                <div class="w-16 h-1.5 bg-gradient-to-r from-[#228B22] to-[#FFD700] rounded-full"></div>
            </div>

            <div class="lg:w-2/3 flex flex-col gap-24 lg:gap-32 pb-10">
                <div class="relative"
                     x-data="{ shown: false }"
                     x-intersect:enter="shown = true" x-intersect:leave="shown = false"
                     class="transition-all duration-700 ease-out"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    <div class="absolute -left-4 lg:-left-12 -top-8 text-[120px] text-gray-50 font-black font-heading opacity-50 select-none z-0">
                        01
                    </div>
                    <div class="relative z-10 pl-6 border-l-4 border-transparent hover:border-[#228B22] transition-colors duration-500">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="p-3.5 bg-[#F0FDF4] text-[#228B22] rounded-full shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl lg:text-4xl font-black text-[#1A2B3C] font-heading"><?php echo esc_html($vision_title); ?></h3>
                        </div>
                        <?php if (!empty($vision_desc)) : ?>
                        <p class="text-gray-600 leading-relaxed text-lg lg:text-xl font-light">
                            <?php echo wp_kses_post($vision_desc); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="relative"
                     x-data="{ shown: false }"
                     x-intersect:enter="shown = true" x-intersect:leave="shown = false"
                     class="transition-all duration-700 ease-out"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 150ms;">
                    <div class="absolute -left-4 lg:-left-12 -top-8 text-[120px] text-gray-50 font-black font-heading opacity-50 select-none z-0">
                        02
                    </div>
                    <div class="relative z-10 pl-6 border-l-4 border-transparent hover:border-[#228B22] transition-colors duration-500">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="p-3.5 bg-[#F0FDF4] text-[#228B22] rounded-full shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl lg:text-4xl font-black text-[#1A2B3C] font-heading"><?php echo esc_html($mission_card_title); ?></h3>
                        </div>
                        <?php if (!empty($mission_desc)) : ?>
                        <p class="text-gray-600 leading-relaxed text-lg lg:text-xl font-light">
                            <?php echo wp_kses_post($mission_desc); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="relative"
                     x-data="{ shown: false }"
                     x-intersect:enter="shown = true" x-intersect:leave="shown = false"
                     class="transition-all duration-700 ease-out"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: 300ms;">
                    <div class="absolute -left-4 lg:-left-12 -top-8 text-[120px] text-gray-50 font-black font-heading opacity-50 select-none z-0">
                        03
                    </div>
                    <div class="relative z-10 pl-6 border-l-4 border-transparent hover:border-[#FFD700] transition-colors duration-500">
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="p-3.5 bg-[#FFFBEB] text-[#F59E0B] rounded-full shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.953a1 1 0 00.95.69h4.157c.969 0 1.371 1.24.588 1.81l-3.364 2.445a1 1 0 00-.364 1.118l1.286 3.953c.3.922-.755 1.688-1.539 1.118l-3.364-2.444a1 1 0 00-1.176 0l-3.364 2.444c-.784.57-1.838-.196-1.539-1.118l1.286-3.953a1 1 0 00-.364-1.118L2.98 9.38c-.783-.57-.38-1.81.588-1.81h4.157a1 1 0 00.95-.69l1.286-3.953z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl lg:text-4xl font-black text-[#1A2B3C] font-heading"><?php echo esc_html($core_values_title); ?></h3>
                        </div>

                        <?php if (!empty($core_values)) : ?>
                        <div class="grid sm:grid-cols-2 gap-x-8 gap-y-6">
                            <?php foreach ($core_values as $index => $core_value) : ?>
                                <div class="flex items-start space-x-3 group transition-all duration-500 ease-out"
                                     x-data="{ shown: false }"
                                     x-intersect:enter="shown = true" x-intersect:leave="shown = false"
                                     :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-8'"
                                     style="transition-delay: <?php echo esc_attr((string) ($index * 100)); ?>ms;">
                                    <svg class="w-5 h-5 text-gray-300 group-hover:text-[#228B22] transition-colors shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-600 group-hover:text-[#1A2B3C] transition-colors font-medium text-base lg:text-lg">
                                        <?php echo esc_html($core_value); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
