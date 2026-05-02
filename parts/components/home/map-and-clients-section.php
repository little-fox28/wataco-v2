<?php
/**
 * Map and Clients Section Component
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = wataco_get_home_data()['map'];
?>

<section id="section-2" class="min-h-screen flex flex-col items-center justify-center bg-white relative overflow-hidden py-12 sm:py-16 md:py-20" x-data="{ shown: false }" x-intersect.once="shown = true">
    <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] bg-size-[20px_20px] opacity-30"></div>

    <div class="max-w-360 mx-auto px-4 sm:px-6 relative z-10 w-full">
        <div class="grid lg:grid-cols-12 gap-8 sm:gap-12 items-center mb-12 sm:mb-20">
            <!-- Left: Stats -->
            <div class="lg:col-span-4 space-y-8 transform transition-all duration-1000" :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'">
                <div class="mb-8">
                    <h3 class="text-[#228B22] font-bold text-sm uppercase tracking-widest mb-3"><?php echo esc_html($data['subtitle']); ?></h3>
                    <h2 class="text-4xl lg:text-5xl font-black text-[#1A2B3C] leading-tight font-heading whitespace-pre-line"><?php echo esc_html($data['title']); ?></h2>
                    <p class="text-gray-500 mt-4 leading-relaxed font-light"><?php echo esc_html($data['description']); ?></p>
                </div>

                <?php foreach ($data['stats'] as $idx => $stat) : ?>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center space-x-5 hover:shadow-md transition-all hover:-translate-y-1">
                        <div class="p-3 rounded-full bg-gray-50 shadow-sm shrink-0" style="color: <?php echo esc_attr($stat['color']); ?>">
                            <?php if ($stat['icon'] === 'file-text') : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <?php elseif ($stat['icon'] === 'zap') : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            <?php elseif ($stat['icon'] === 'bar-chart') : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
                            <?php endif; ?>
                        </div>
                        <div x-data="{ 
                            current: 0, 
                            target: <?php echo $stat['val']; ?>, 
                            duration: 2000,
                            startCount() {
                                let start = null;
                                const step = (ts) => {
                                    if(!start) start = ts;
                                    const progress = Math.min((ts - start) / this.duration, 1);
                                    this.current = Math.floor(progress * this.target);
                                    if(progress < 1) requestAnimationFrame(step);
                                };
                                requestAnimationFrame(step);
                            }
                        }" x-intersect.once="startCount()">
                            <div class="text-3xl font-black text-[#1A2B3C] font-tech leading-none mb-1">
                                <span x-text="current">0</span><?php echo esc_html($stat['suffix']); ?>
                            </div>
                            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider"><?php echo esc_html($stat['label']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Right: Map -->
            <div class="lg:col-span-8 relative h-87.5 sm:h-112.5 lg:h-150 flex items-center justify-center transform transition-all duration-1000 delay-200" :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-95'">
                <div class="relative grow flex items-center justify-center p-0 lg:p-8 w-full h-full">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/vietnam-maps.png'); ?>" class="h-full w-auto object-contain" />

                    <?php foreach ($data['locations'] as $loc) : ?>
                        <div class="absolute flex items-center justify-center group/dot" style="top: <?php echo $loc['top']; ?>; left: <?php echo $loc['left']; ?>; transform: translate(-50%, -50%);">
                            <div class="absolute w-4 h-4 bg-[#228B22] rounded-full opacity-75 animate-ping" style="z-index: 5;"></div>
                            <div class="w-3 h-3 bg-[#228B22] rounded-full z-10 cursor-pointer hover:scale-125 transition-transform"></div>
                            <div class="absolute opacity-0 group-hover/dot:opacity-100 transition-opacity bg-[#1A2B3C] text-white text-[10px] px-2 py-1 rounded shadow-lg -top-8 whitespace-nowrap z-20 pointer-events-none font-bold">
                                <?php echo esc_html($loc['name']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Marquee -->
        <div class="w-full border-t border-gray-100 pt-20 mt-20 transform transition-all duration-1000 delay-400" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            <div class="text-center mb-10">
                <h5 class="text-sm font-bold text-gray-400 uppercase tracking-widest"><?php echo esc_html($data['clientTitle']); ?></h5>
            </div>

            <div class="relative z-10 flex overflow-hidden">
                <div class="marquee-content flex items-center space-x-16 py-4">
                    <?php 
                    // Repeat 4 times for smooth infinite effect
                    $all_clients = array_merge($data['clients'], $data['clients'], $data['clients'], $data['clients']);
                    foreach ($all_clients as $client) : 
                    ?>
                        <div class="shrink-0 flex items-center justify-center min-w-[100px] lg:min-w-[150px]">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/client-logo/' . $client['logo']); ?>" 
                                 alt="<?php echo esc_attr($client['name']); ?>" 
                                 class="h-10 lg:h-16 w-auto object-contain grayscale hover:grayscale-0 transition-all duration-500 opacity-60 hover:opacity-100" />
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.marquee-content {
    animation: marquee 40s linear infinite;
    width: max-content;
}
.marquee-content:hover {
    animation-play-state: paused;
}
</style>
