<?php
/**
 * Projects page — Process Flow section.
 *
 * 8-step U-shaped diagram showing the project implementation lifecycle.
 * Desktop: 3-col × 3-row CSS Grid with directional SVG arrows.
 * Mobile: Stacked 1-col (phone) / 2-col (tablet) layout.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$process_steps = array(
    array('id' => 1, 'title' => pll__('PROJECT SURVEY'),                                     'arrow' => 'down',  'highlight' => false, 'col' => 1, 'row' => 1),
    array('id' => 2, 'title' => pll__('PRELIMINARY DESIGN, SIMULATION & ANALYSIS'),            'arrow' => 'down',  'highlight' => false, 'col' => 1, 'row' => 2),
    array('id' => 3, 'title' => pll__('FEASIBILITY ASSESSMENT'),                               'arrow' => 'right', 'highlight' => false, 'col' => 1, 'row' => 3),
    array('id' => 4, 'title' => pll__('SYSTEM DESIGN'),                                        'arrow' => 'up',    'highlight' => false, 'col' => 2, 'row' => 3),
    array('id' => 5, 'title' => pll__('CONSTRUCTION & INSTALLATION'),                          'arrow' => 'up',    'highlight' => false, 'col' => 2, 'row' => 2),
    array('id' => 6, 'title' => pll__('TESTING & COMMISSIONING'),                              'arrow' => 'right', 'highlight' => false, 'col' => 2, 'row' => 1),
    array('id' => 7, 'title' => pll__('COMMERCIAL OPERATION & HANDOVER'),                      'arrow' => 'down',  'highlight' => true,  'col' => 3, 'row' => 1),
    array('id' => 8, 'title' => pll__('OPERATION & MAINTENANCE (O&M)'),                        'arrow' => null,    'highlight' => false, 'col' => 3, 'row' => 2),
);
?>

<section class="relative pt-20 pb-24 lg:pt-28 lg:pb-32 bg-white overflow-hidden border-b border-gray-200">
    <!-- Subtle dot background pattern -->
    <div class="absolute inset-0 opacity-50" style="background-image: radial-gradient(#e5e7eb 1px, transparent 1px); background-size: 20px 20px;"></div>

    <div class="relative z-10 max-w-[1200px] mx-auto px-6">
        <!-- Section Heading -->
        <div x-data="{ shown: false }"
             x-intersect.once="shown = true"
             class="text-center mb-20 lg:mb-28 transition-all duration-700 ease-out"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h2 class="text-3xl lg:text-5xl font-black text-[#228B22] leading-tight font-heading uppercase tracking-tight drop-shadow-sm">
                <?php echo esc_html(pll__('Project Implementation')); ?><br class="hidden md:block"><?php echo esc_html(pll__('Process Flow')); ?>
            </h2>
        </div>

        <!-- Desktop Grid Layout (lg+) — U-shape 3×3 -->
        <div class="hidden lg:grid grid-cols-3 gap-x-16 gap-y-20 relative">
            <?php foreach ($process_steps as $step) :
                $is_gold = $step['highlight'];
                $delay_ms = $step['id'] * 100;
            ?>
                <div style="grid-column-start: <?php echo esc_attr($step['col']); ?>; grid-row-start: <?php echo esc_attr($step['row']); ?>;"
                     class="relative flex justify-center items-center h-full">

                    <!-- Process Card -->
                    <div x-data="{ shown: false }"
                         x-intersect.once="shown = true"
                         class="w-full h-full flex items-center justify-center mt-6 transition-all duration-700 ease-out"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         style="transition-delay: <?php echo esc_attr($delay_ms); ?>ms;">
                        <div class="relative w-full h-[6.25rem] rounded-full border-[3px] px-6 py-2 flex items-center justify-center text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl <?php echo $is_gold
                            ? 'bg-[#FFD700] border-[#EAB308] text-[#1A2B3C] shadow-[0_10px_25px_rgba(234,179,8,0.4)]'
                            : 'bg-white border-[#228B22] text-[#1A2B3C] shadow-[0_10px_25px_rgba(34,139,34,0.15)]'; ?>">
                            <!-- Number Badge -->
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 w-14 h-14 rounded-full flex items-center justify-center border-4 border-white shadow-md <?php echo $is_gold ? 'bg-[#1A2B3C] text-[#FFD700]' : 'bg-[#228B22] text-white'; ?>">
                                <span class="font-black text-xl"><?php echo esc_html($step['id']); ?></span>
                            </div>
                            <span class="font-black text-xs lg:text-sm uppercase tracking-widest leading-snug mt-2 text-[#1A2B3C]">
                                <?php echo esc_html($step['title']); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Directional Arrows -->
                    <?php if ($step['arrow'] === 'down') : ?>
                        <div class="absolute -bottom-14 left-1/2 -translate-x-1/2 text-[#228B22]">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                        </div>
                    <?php elseif ($step['arrow'] === 'up') : ?>
                        <div class="absolute -top-12 left-1/2 -translate-x-1/2 text-[#228B22]">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        </div>
                    <?php elseif ($step['arrow'] === 'right') : ?>
                        <div class="absolute top-[60%] -right-12 -translate-y-1/2 text-[#228B22]">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Mobile & Tablet Layout (< lg) — Stacked -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-10 lg:hidden">
            <?php foreach ($process_steps as $idx => $step) :
                $is_gold = $step['highlight'];
                $delay_ms = $idx * 100;
            ?>
                <div class="relative flex flex-col items-center">
                    <div x-data="{ shown: false }"
                         x-intersect.once="shown = true"
                         class="w-full h-full flex items-center justify-center mt-6 transition-all duration-700 ease-out"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         style="transition-delay: <?php echo esc_attr($delay_ms); ?>ms;">
                        <div class="relative w-[95%] lg:w-full h-[5.625rem] lg:h-[6.25rem] rounded-full border-[3px] px-6 py-2 flex items-center justify-center text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl <?php echo $is_gold
                            ? 'bg-[#FFD700] border-[#EAB308] text-[#1A2B3C] shadow-[0_10px_25px_rgba(234,179,8,0.4)]'
                            : 'bg-white border-[#228B22] text-[#1A2B3C] shadow-[0_10px_25px_rgba(34,139,34,0.15)]'; ?>">
                            <div class="absolute -top-7 left-1/2 -translate-x-1/2 w-14 h-14 rounded-full flex items-center justify-center border-4 border-white shadow-md <?php echo $is_gold ? 'bg-[#1A2B3C] text-[#FFD700]' : 'bg-[#228B22] text-white'; ?>">
                                <span class="font-black text-xl"><?php echo esc_html($step['id']); ?></span>
                            </div>
                            <span class="font-black text-xs lg:text-sm uppercase tracking-widest leading-snug mt-2 text-[#1A2B3C]">
                                <?php echo esc_html($step['title']); ?>
                            </span>
                        </div>
                    </div>
                    <!-- Simple down arrow between cards (1-col only) -->
                    <?php if ($idx < count($process_steps) - 1) : ?>
                        <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-[#228B22] sm:hidden z-10">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
