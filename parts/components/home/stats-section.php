<?php
/**
 * Stats Section Component
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$stats = wataco_get_home_stats();
?>

<section id="section-stats" class="bg-[#1A2B3C] py-8 sm:py-12 lg:py-20 relative z-20 border-y border-white/10 shadow-2xl">
    <div class="max-w-360 mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-4 gap-2 sm:gap-8 lg:gap-12 divide-x divide-white/10">
            <?php foreach ($stats as $idx => $stat) : ?>
                <div class="text-center group px-3 sm:px-4 pt-6 sm:pt-0" 
                     x-data="{ 
                        current: 0, 
                        target: <?php echo esc_attr($stat['val']); ?>, 
                        duration: 2000,
                        started: false,
                        startCount() {
                            if (this.started) return;
                            this.started = true;
                            let startTimestamp = null;
                            const step = (timestamp) => {
                                if (!startTimestamp) startTimestamp = timestamp;
                                const progress = Math.min((timestamp - startTimestamp) / this.duration, 1);
                                this.current = (progress * this.target).toFixed(<?php echo strpos((string)$stat['val'], '.') !== false ? 1 : 0; ?>);
                                if (progress < 1) {
                                    window.requestAnimationFrame(step);
                                }
                            };
                            window.requestAnimationFrame(step);
                        }
                     }"
                     x-intersect.once="startCount()">
                    <div class="flex justify-center gap-1 text-sm sm:text-4xl lg:text-6xl font-bold text-[#FFD700] mb-2 lg:mb-4 font-tech tracking-tighter">
                        <span><?php echo esc_html($stat['prefix']); ?></span><span x-text="current">0</span><span><?php echo esc_html($stat['suffix']); ?></span>
                    </div>
                    <div class="text-[10px] text-white font-bold uppercase tracking-[0.2em] font-heading">
                        <?php echo esc_html($stat['label']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
