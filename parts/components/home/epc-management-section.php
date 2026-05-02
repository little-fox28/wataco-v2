<?php
/**
 * EPC Management Section Component
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = wataco_get_home_data()['epc'];
?>

<section id="section-epc" class="min-h-screen flex flex-col items-center justify-center bg-white relative overflow-hidden py-12 sm:py-16 md:py-20" 
         x-data="{ shown: false, zoomedImage: null }" 
         x-intersect.once="shown = true">
    
    <!-- Lightbox Modal -->
    <template x-teleport="body">
        <div x-show="zoomedImage" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="zoomedImage = null"
             class="fixed inset-0 z-[100] bg-black/90 backdrop-blur-sm flex items-center justify-center p-4 cursor-zoom-out"
             style="display: none;">
            <button class="absolute top-6 right-6 text-white bg-white/10 hover:bg-white/20 p-3 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            <img :src="zoomedImage" 
                 class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl transform transition-transform duration-300"
                 @click.stop />
        </div>
    </template>

    <div class="absolute top-0 left-0 w-full h-1/2 bg-linear-to-b from-[#F8FAFC] to-white pointer-events-none"></div>

    <div class="max-w-360 mx-auto px-6 relative z-10 w-full">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-20 items-start">

            <!-- Left Column -->
            <div class="lg:col-span-5 lg:sticky lg:top-32 transform transition-all duration-1000"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'">
                
                <div class="mb-10">
                    <h3 class="text-[#228B22] font-black text-sm uppercase tracking-[0.5em] font-heading mb-4">
                        <?php echo esc_html($data['subtitle']); ?>
                    </h3>
                    <h2 class="text-3xl lg:text-5xl font-black text-[#1A2B3C] leading-tight font-heading mb-6">
                        <?php echo esc_html($data['title']); ?>
                    </h2>
                    <p class="text-gray-500 text-lg leading-relaxed mb-10 font-light border-l-4 border-[#FFD700] pl-4">
                        <?php echo esc_html($data['desc']); ?>
                    </p>
                </div>

                <div class="relative rounded-2xl overflow-hidden shadow-2xl group w-full h-70 lg:h-87.5 cursor-zoom-in mb-10"
                     @click="zoomedImage = '<?php echo esc_url($data['image']); ?>'">
                    <img src="<?php echo esc_url($data['image']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
                    <div class="absolute inset-0 bg-linear-to-t from-[#1A2B3C] via-[#1A2B3C]/30 to-transparent opacity-90"></div>
                    
                    <div class="absolute top-4 right-4 bg-black/40 backdrop-blur-sm p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>

                    <div class="absolute bottom-6 left-6 right-6 flex items-center space-x-4">
                        <div class="w-12 h-12 bg-[#228B22] rounded-full flex items-center justify-center text-white shrink-0 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-lg lg:text-xl leading-tight font-heading"><?php echo esc_html($data['quality']); ?></p>
                            <p class="text-[#FFD700] text-xs uppercase tracking-widest mt-1 font-bold"><?php echo esc_html($data['standard']); ?></p>
                        </div>
                    </div>
                </div>

                <a href="<?php echo esc_url(home_url('/news/')); ?>" class="bg-[#1A2B3C] hover:bg-[#228B22] text-white px-8 py-4 rounded-md font-black uppercase tracking-widest text-xs transition-colors shadow-lg inline-flex items-center group active:scale-95">
                    <?php echo esc_html($data['button']); ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2 group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-7 relative transform transition-all duration-1000 delay-200"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-10'">
                <div class="hidden sm:block absolute left-7.75 top-8 bottom-8 w-0.5 bg-gray-100"></div>

                <div class="space-y-8">
                    <?php foreach ($data['steps'] as $idx => $step) : ?>
                        <div class="relative pl-0 sm:pl-20">
                            <div class="hidden sm:flex absolute left-0 top-6 w-16 h-16 bg-white border-4 border-gray-50 rounded-full items-center justify-center shadow-sm z-10 text-[#1A2B3C] font-black font-tech text-xl">
                                0<?php echo $idx + 1; ?>
                            </div>
                            <div class="bg-[#F8FAFC] p-8 rounded-2xl border border-[#228B22] shadow-xl flex flex-col sm:flex-row gap-6 items-start relative overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#228B22]"></div>
                                <div class="w-14 h-14 bg-[#228B22] rounded-full flex items-center justify-center shrink-0 shadow-md text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-black text-[#228B22] font-heading mb-3">
                                        <span class="sm:hidden text-gray-300 font-tech mr-2">0<?php echo $idx + 1; ?>.</span>
                                        <?php echo esc_html($step['title']); ?>
                                    </h4>
                                    <p class="text-gray-500 leading-relaxed text-sm">
                                        <?php echo esc_html($step['desc']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>
