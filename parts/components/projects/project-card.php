<?php
/**
 * Single project card component.
 *
 * Expects the following variables set before include:
 * @var int    $project_index  — 0-based index for stagger delay
 * @var string $project_title
 * @var string $project_location
 * @var string $project_capacity
 * @var string $project_year
 * @var string $project_status
 * @var string $project_img_path
 * @var string $project_permalink
 * @var string $project_category_slug — 'vietnam' or 'international'
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$delay_ms = (isset($project_index) ? intval($project_index) : 0) * 100;
$capacity_label = function_exists('pll__') ? pll__('Capacity') : 'Capacity';
$year_label     = function_exists('pll__') ? pll__('Year') : 'Year';
?>

<a href="<?php echo esc_url($project_permalink); ?>"
   class="block"
   data-category="<?php echo esc_attr($project_category_slug); ?>"
   x-show="activeCategory === 'all' || activeCategory === '<?php echo esc_attr($project_category_slug); ?>'"
   x-transition:enter="transition ease-out duration-300"
   x-transition:enter-start="opacity-0 scale-95"
   x-transition:enter-end="opacity-100 scale-100"
   x-transition:leave="transition ease-in duration-200"
   x-transition:leave-start="opacity-100 scale-100"
   x-transition:leave-end="opacity-0 scale-95">

    <div class="group relative bg-white rounded-lg overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl hover:border-[#228B22] transition-all duration-300 h-full"
         x-data="{ shown: false }"
         x-intersect.once="shown = true"
         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
         style="transition-delay: <?php echo esc_attr($delay_ms); ?>ms;">

        <!-- Status Badge -->
        <div class="absolute top-4 right-4 z-10">
            <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-md shadow-md border bg-white text-[#228B22] border-[#228B22]">
                <?php echo esc_html(pll__($project_status)); ?>
            </span>
        </div>

        <!-- Image -->
        <div class="h-64 overflow-hidden relative">
            <img src="<?php echo esc_url($project_img_path); ?>"
                 alt="<?php echo esc_attr($project_title); ?>"
                 class="w-full h-full object-cover"
                 loading="lazy" />
            <div class="absolute inset-0 bg-gradient-to-t from-[#1A2B3C] via-transparent to-transparent opacity-60 group-hover:opacity-40 transition-opacity duration-300"></div>

            <!-- Overlay Content (Bottom) -->
            <div class="absolute bottom-0 left-0 w-full p-6 text-white">
                <div class="flex items-center space-x-2 text-[#FFD700] text-xs font-bold uppercase tracking-widest mb-1">
                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span><?php echo esc_html($project_location); ?></span>
                </div>
                <h3 class="text-xl font-bold font-heading leading-tight group-hover:text-[#FFD700] transition-colors duration-300">
                    <?php echo esc_html($project_title); ?>
                </h3>
            </div>
        </div>

        <!-- Footer Details -->
        <div class="p-6 bg-white flex justify-between items-center border-t border-gray-100">
            <div class="flex items-center space-x-6">
                <div>
                    <div class="text-[10px] text-gray-400 uppercase font-bold"><?php echo esc_html($capacity_label); ?></div>
                    <div class="flex items-center text-[#1A2B3C] font-black text-lg font-mono tracking-tighter">
                        <svg class="w-4 h-4 mr-1 text-[#1A2B3C] fill-[#1A2B3C]" viewBox="0 0 24 24" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <?php echo esc_html($project_capacity); ?>
                    </div>
                </div>
                <div>
                    <div class="text-[10px] text-gray-400 uppercase font-bold"><?php echo esc_html($year_label); ?></div>
                    <div class="flex items-center text-[#1A2B3C] font-bold font-mono tracking-tighter">
                        <svg class="w-3.5 h-3.5 mr-1 text-[#1A2B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <?php echo esc_html($project_year); ?>
                    </div>
                </div>
            </div>
            <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-[#1A2B3C] group-hover:bg-[#1A2B3C] group-hover:text-white border border-gray-100 transition-all duration-300">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
        </div>
    </div>
</a>
