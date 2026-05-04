<?php
/**
 * Investment Solutions Section Component
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = wataco_get_home_data()['solutions'];
?>

<section id="section-solutions" class="py-20 lg:py-32 bg-[#F8FAFC] relative overflow-hidden border-t border-gray-100"
         x-data="{ 
            activeTab: '<?php echo esc_js($data['data'][0]['id']); ?>',
            mobileIndex: 0,
            solutions: <?php echo esc_attr((string) wp_json_encode($data['data'])); ?>,
            next() { this.mobileIndex = (this.mobileIndex + 1) % this.solutions.length },
            prev() { this.mobileIndex = (this.mobileIndex - 1 + this.solutions.length) % this.solutions.length },
            init() {
                setInterval(() => {
                    this.next();
                }, 6000);
            }
         }">
    <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] bg-size-[20px_20px] opacity-50"></div>

    <div class="max-w-360 mx-auto px-6 relative z-10">
        <div class="text-center mb-16" x-data="{ shown: false }" x-intersect.once="shown = true">
            <h3 class="text-[#228B22] font-black text-sm uppercase tracking-[0.5em] font-heading mb-4 transform transition-all duration-700"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                <?php echo esc_html($data['subtitle']); ?>
            </h3>
            <h2 class="text-3xl lg:text-5xl font-black text-[#1A2B3C] leading-tight font-heading transform transition-all duration-700 delay-100"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                <?php echo esc_html($data['title']); ?>
            </h2>
        </div>

        <!-- Desktop Layout -->
        <div class="hidden lg:flex flex-row gap-16">
            <!-- Left: Navigation -->
            <div class="lg:w-1/3 flex flex-col gap-3 relative z-20">
                <?php foreach ($data['data'] as $sol) : ?>
                    <button
                        @click="activeTab = '<?php echo esc_js($sol['id']); ?>'"
                        class="text-left px-6 py-5 rounded-2xl transition-all duration-300 border cursor-pointer"
                        :class="activeTab === '<?php echo esc_js($sol['id']); ?>' ? 'bg-white border-[#228B22] shadow-[0_10px_30px_rgba(34,139,34,0.15)] transform scale-105 z-10' : 'bg-transparent border-transparent hover:bg-white/50 text-gray-500'"
                    >
                        <h4 class="text-lg font-bold font-heading mb-1"
                            :class="activeTab === '<?php echo esc_js($sol['id']); ?>' ? 'text-[#228B22]' : 'text-gray-700'">
                            <?php echo esc_html($sol['shortTitle']); ?>
                        </h4>
                        <p class="text-xs" :class="activeTab === '<?php echo esc_js($sol['id']); ?>' ? 'text-gray-600' : 'text-gray-400'">
                            <?php echo esc_html($data['labels']['chooseSolution']); ?>
                        </p>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Right: Content -->
            <div class="lg:w-2/3">
                <?php foreach ($data['data'] as $sol) : ?>
                    <div x-show="activeTab === '<?php echo esc_js($sol['id']); ?>'"
                         x-transition:enter="transition ease-out duration-400"
                         x-transition:enter-start="opacity-0 translate-x-5"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         class="h-full">
                        
                        <?php 
                        $link_url = isset($sol['linkSlug']) ? home_url($sol['linkSlug']) : '#';
                        $has_link = isset($sol['linkSlug']);
                        ?>

                        <div class="bg-white mb-10 rounded-3xl p-8 lg:p-12 shadow-xl border border-gray-100 h-full flex flex-col transition-all duration-300 <?php echo $has_link ? 'hover:shadow-2xl hover:scale-[1.01] hover:border-[#228B22]/30 group' : ''; ?>">
                            <?php if ($has_link) : ?><a href="<?php echo esc_url($link_url); ?>" class="block no-underline h-full flex flex-col"><?php endif; ?>
                            
                            <h3 class="text-xl lg:text-3xl font-black text-[#1A2B3C] mb-6 font-heading leading-snug <?php echo $has_link ? 'group-hover:text-[#228B22]' : ''; ?> transition-colors">
                                <?php echo esc_html($sol['title']); ?>
                            </h3>
                            <p class="text-gray-600 text-sm lg:text-lg mb-10 leading-relaxed font-light border-l-4 border-[#228B22] pl-5 bg-[#F8FAFC] py-3 rounded-r-lg">
                                <?php echo esc_html($sol['desc']); ?>
                            </p>

                            <!-- Diagram -->
                            <div class="bg-[#F8FAFC] rounded-2xl p-6 border border-gray-100 flex flex-col justify-center items-center relative overflow-hidden flex-1">
                                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-8 text-center w-full">
                                    <?php echo esc_html($data['labels']['modelTitle']); ?>
                                </h4>

                                <?php if ($sol['diagramType'] === 'three-party') : ?>
                                    <div class="relative w-full max-w-75 aspect-square">
                                        <svg class="absolute inset-0 w-full h-full text-gray-200">
                                            <polygon points="150,40 250,220 50,220" fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4" />
                                        </svg>
                                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-20 h-20 bg-white rounded-full shadow-lg border border-gray-100 flex flex-col items-center justify-center z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#FFD700] mb-1"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                                            <span class="text-[9px] font-black text-[#1A2B3C]">WATACO</span>
                                        </div>
                                        <div class="absolute bottom-4 left-0 w-20 h-20 bg-white rounded-full shadow-lg border border-gray-100 flex flex-col items-center justify-center z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500 mb-1"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                            <span class="text-[9px] font-black text-[#1A2B3C] text-center leading-tight px-1"><?php echo esc_html($sol['roles']['client']); ?></span>
                                        </div>
                                        <div class="absolute bottom-4 right-0 w-20 h-20 bg-white rounded-full shadow-lg border border-gray-100 flex flex-col items-center justify-center z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#228B22] mb-1"><line x1="3" y1="21" x2="21" y2="21"/><line x1="3" y1="7" x2="21" y2="7"/><path d="M9 21V11"/><path d="M15 21V11"/><path d="M18 21V11"/><path d="M6 21V11"/><path d="M10 7V3h4v4"/></svg>
                                            <span class="text-[9px] font-black text-[#1A2B3C] text-center leading-tight px-1"><?php echo esc_html($sol['roles']['partner'] ?? ''); ?></span>
                                        </div>
                                        <div class="absolute top-[40%] left-[10%] text-[8px] text-gray-500 text-center w-20 rotate-[-60deg] bg-[#F8FAFC] px-1"><?php echo esc_html($sol['flows']['watacoToClient'] ?? ''); ?></div>
                                        <div class="absolute top-[40%] right-[10%] text-[8px] text-gray-500 text-center w-20 rotate-60 bg-[#F8FAFC] px-1"><?php echo esc_html($sol['flows']['partnerToWataco'] ?? ''); ?></div>
                                        <div class="absolute bottom-[0%] left-1/2 -translate-x-1/2 text-[8px] text-gray-500 text-center w-20 bg-[#F8FAFC] px-1"><?php echo esc_html($sol['flows']['clientToPartner'] ?? ''); ?></div>
                                    </div>
                                <?php else : ?>
                                    <div class="relative w-full max-w-62.5 aspect-video flex items-center justify-between">
                                        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-0.5 bg-gray-200 border-t-2 border-dashed border-gray-300"></div>
                                        <div class="relative w-20 h-20 bg-white rounded-full shadow-lg border border-gray-100 flex flex-col items-center justify-center z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500 mb-1"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                            <span class="text-[9px] font-black text-[#1A2B3C] text-center leading-tight px-1"><?php echo esc_html($sol['roles']['client']); ?></span>
                                        </div>
                                        <div class="absolute top-0 left-1/2 -translate-x-1/2 text-[9px] text-[#228B22] font-bold bg-[#F8FAFC] px-2 text-center w-full"><?php echo esc_html($sol['flows']['clientToWataco'] ?? ''); ?></div>
                                        <div class="relative w-20 h-20 bg-white rounded-full shadow-lg border border-gray-100 flex flex-col items-center justify-center z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#FFD700] mb-1"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                                            <span class="text-[9px] font-black text-[#1A2B3C]">WATACO</span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($sol['note'])) : ?>
                                    <div class="mt-8 text-[10px] text-gray-400 italic text-center max-w-[80%]"><?php echo esc_html($sol['note']); ?></div>
                                <?php endif; ?>
                            </div>

                            <?php if ($has_link) : ?>
                                <div class="mt-6 flex items-center justify-end gap-2 text-[#228B22] opacity-60 group-hover:opacity-100 transition-opacity">
                                    <span class="text-xs font-bold uppercase tracking-widest"><?php echo esc_html($data['labels']['detailCta']); ?></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Mobile Layout -->
        <div class="lg:hidden relative">
            <?php foreach ($data['data'] as $idx => $sol) : ?>
                <div x-show="mobileIndex === <?php echo $idx; ?>"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                    
                    <?php 
                    $link_url = isset($sol['linkSlug']) ? home_url($sol['linkSlug'], '') : '#';
                    $has_link = isset($sol['linkSlug']);
                    ?>

                    <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 flex flex-col min-h-[500px]">
                        <?php if ($has_link) : ?><a href="<?php echo esc_url($link_url); ?>" class="block no-underline h-full flex flex-col"><?php endif; ?>
                        
                        <h3 class="text-xl font-black text-[#1A2B3C] mb-4 font-heading">
                            <?php echo esc_html($sol['title']); ?>
                        </h3>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed border-l-4 border-[#228B22] pl-4 bg-[#F8FAFC] py-2">
                            <?php echo esc_html($sol['desc']); ?>
                        </p>

                        <!-- Diagram -->
                        <div class="bg-[#F8FAFC] rounded-2xl p-4 border border-gray-100 flex flex-col items-center flex-1">
                             <h4 class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-4">
                                <?php echo esc_html($data['labels']['modelTitle']); ?>
                            </h4>
                            
                            <?php if ($sol['diagramType'] === 'three-party') : ?>
                                <div class="relative w-full max-w-60 aspect-square">
                                    <svg class="absolute inset-0 w-full h-full text-gray-200">
                                        <polygon points="120,30 200,180 40,180" fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4" />
                                    </svg>
                                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-14 h-14 bg-white rounded-full shadow-md border border-gray-100 flex flex-col items-center justify-center z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#FFD700] mb-0.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                                        <span class="text-[7px] font-black text-[#1A2B3C]">WATACO</span>
                                    </div>
                                    <div class="absolute bottom-2 left-0 w-14 h-14 bg-white rounded-full shadow-md border border-gray-100 flex flex-col items-center justify-center z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500 mb-0.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                        <span class="text-[7px] font-black text-[#1A2B3C] text-center leading-tight"><?php echo esc_html($sol['roles']['client']); ?></span>
                                    </div>
                                    <div class="absolute bottom-2 right-0 w-14 h-14 bg-white rounded-full shadow-md border border-gray-100 flex flex-col items-center justify-center z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#228B22] mb-0.5"><line x1="3" y1="21" x2="21" y2="21"/><line x1="3" y1="7" x2="21" y2="7"/><path d="M9 21V11"/><path d="M15 21V11"/><path d="M18 21V11"/><path d="M6 21V11"/><path d="M10 7V3h4v4"/></svg>
                                        <span class="text-[7px] font-black text-[#1A2B3C] text-center leading-tight"><?php echo esc_html($sol['roles']['partner'] ?? ''); ?></span>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="relative w-full max-w-50 aspect-video flex items-center justify-between">
                                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-0.5 bg-gray-200 border-t-2 border-dashed border-gray-300"></div>
                                    <div class="relative w-14 h-14 bg-white rounded-full shadow-md border border-gray-100 flex flex-col items-center justify-center z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500 mb-0.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                        <span class="text-[7px] font-black text-[#1A2B3C] text-center leading-tight"><?php echo esc_html($sol['roles']['client']); ?></span>
                                    </div>
                                    <div class="relative w-14 h-14 bg-white rounded-full shadow-md border border-gray-100 flex flex-col items-center justify-center z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#FFD700] mb-0.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                                        <span class="text-[7px] font-black text-[#1A2B3C]">WATACO</span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($sol['note'])) : ?>
                                <div class="mt-4 text-[8px] text-gray-400 italic text-center max-w-[90%]">*<?php echo esc_html($sol['note']); ?></div>
                            <?php endif; ?>
                        </div>

                        <?php if ($has_link) : ?>
                            <div class="mt-4 flex items-center justify-end gap-2 text-[#228B22] opacity-80">
                                <span class="text-[10px] font-bold uppercase tracking-widest"><?php echo esc_html($data['labels']['detailCta']); ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Mobile Controls -->
            <div class="flex items-center justify-center gap-4 mt-8">
                <button @click="prev()" class="w-10 h-10 rounded-full bg-white shadow-md border border-gray-100 flex items-center justify-center text-[#228B22]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <div class="flex gap-2">
                    <?php foreach ($data['data'] as $idx => $sol) : ?>
                        <div @click="mobileIndex = <?php echo $idx; ?>" 
                             class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                             :class="mobileIndex === <?php echo $idx; ?> ? 'w-8 bg-[#228B22]' : 'w-2 bg-gray-300'"></div>
                    <?php endforeach; ?>
                </div>
                <button @click="next()" class="w-10 h-10 rounded-full bg-white shadow-md border border-gray-100 flex items-center justify-center text-[#228B22]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
        </div>
    </div>
</section>
