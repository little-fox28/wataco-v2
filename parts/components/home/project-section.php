<?php
/**
 * Project Section Component
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = wataco_get_home_data()['projects'];
?>

<section id="section-3" class="min-h-screen flex flex-col items-center justify-center bg-[#F8FAFC] text-[#1A2B3C] relative overflow-hidden py-12 sm:py-16 md:py-20"
         x-data="{ 
            activeTab: 'vietnam',
            currentIndex: 0,
            projectData: <?php echo esc_attr((string) wp_json_encode($data['data'])); ?>,
            get currentProjects() { return this.projectData[this.activeTab] || [] },
            next() { this.currentIndex = (this.currentIndex + 1) % this.currentProjects.length },
            prev() { this.currentIndex = (this.currentIndex - 1 + this.currentProjects.length) % this.currentProjects.length },
            getCardStyle(index) {
                let total = this.currentProjects.length;
                let offset = index - this.currentIndex;
                if (offset > total / 2) offset -= total;
                if (offset < -total / 2) offset += total;
                
                if (offset === 0) return 'z-10 opacity-100 scale-100 translate-x-0 brightness-100';
                if (offset === -1 || (this.currentIndex === 0 && index === total - 1)) return 'z-5 opacity-60 scale-85 -translate-x-[70%] brightness-50 blur-[1px] pointer-events-none';
                if (offset === 1 || (this.currentIndex === total - 1 && index === 0)) return 'z-5 opacity-60 scale-85 translate-x-[70%] brightness-50 blur-[1px] pointer-events-none';
                return 'z-0 opacity-0 scale-50 translate-x-0 pointer-events-none';
            }
         }">
    
    <div class="max-w-360 mx-auto px-4 sm:px-6 relative z-10 w-full">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between mb-8 sm:mb-12 lg:mb-16 gap-6 sm:gap-8">
            <div>
                <h3 class="text-[#228B22] font-black text-xs sm:text-sm uppercase tracking-[0.5em] font-heading mb-2"><?php echo esc_html($data['subtitle']); ?></h3>
                <h2 class="text-2xl sm:text-3xl lg:text-6xl font-black tracking-tighter leading-none text-[#1A2B3C] font-heading"><?php echo esc_html($data['title']); ?></h2>
            </div>
            <div class="flex items-center gap-2">
                <?php foreach ($data['tabs'] as $tab) : ?>
                    <button @click="activeTab = '<?php echo $tab['id']; ?>'; currentIndex = 0"
                            class="px-5 py-2.5 text-sm font-semibold rounded-full transition-all duration-300"
                            :class="activeTab === '<?php echo $tab['id']; ?>' ? 'bg-[#1A2B3C] text-white shadow-lg transform scale-105' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'">
                        <?php echo esc_html($tab['label']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Carousel -->
        <div class="relative w-full h-100 sm:h-125 lg:h-125 flex items-center justify-center">
            <template x-for="(project, idx) in currentProjects" :key="activeTab + idx">
                <div class="absolute top-0 w-[85%] lg:w-[65%] h-full bg-[#111] rounded-md shadow-2xl overflow-hidden border border-white/10 transition-all duration-500 ease-out transform"
                     :class="getCardStyle(idx)">
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 z-10">
                        <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-md shadow-md border bg-white text-[#228B22] border-[#228B22]" x-text="project.status"></span>
                    </div>

                    <img :src="project.img" class="w-full h-full object-cover" loading="lazy" />
                    <div class="absolute inset-0 bg-linear-to-t from-[#1A2B3C] via-transparent to-transparent opacity-90"></div>

                    <!-- Content -->
                    <div class="absolute bottom-0 left-0 w-full p-6 lg:p-12 transition-opacity duration-300"
                         :style="currentIndex === idx ? 'opacity: 1' : 'opacity: 0'">
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="text-[#FFD700] text-[10px] font-bold tracking-widest uppercase font-heading flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span x-text="project.location"></span>
                            </span>
                        </div>
                        <h3 class="text-2xl lg:text-5xl font-black text-white leading-tight mb-6 font-heading" x-text="project.name"></h3>
                        
                        <div class="flex flex-wrap items-center gap-4 lg:gap-6 border-t border-white/20 pt-6">
                            <div class="flex items-center text-[#FFD700]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 opacity-80"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <span class="text-sm font-bold font-tech" x-text="project.year"></span>
                            </div>
                            <div class="flex items-center text-[#FFD700]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 opacity-80"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                <span class="text-sm font-bold font-tech" x-text="project.capacity"></span>
                            </div>
                            <a :href="'<?php echo esc_url(home_url('/projects/')); ?>' + project.slug" class="ml-auto bg-white/10 hover:bg-[#228b22] text-white px-6 py-2 text-[9px] font-black uppercase tracking-widest transition-colors border border-white/20 hover:border-[#228b22] rounded-md min-h-[44px] flex items-center">
                                <?php echo esc_html($data['viewMore']); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Controls -->
            <button @click="prev()" class="absolute left-2 lg:left-4 z-30 w-10 h-10 lg:w-12 lg:h-12 flex items-center justify-center border border-white/20 bg-black/50 text-white rounded-full backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button @click="next()" class="absolute right-2 lg:right-4 z-30 w-10 h-10 lg:w-12 lg:h-12 flex items-center justify-center border border-white/20 bg-black/50 text-white rounded-full backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <!-- Indicators -->
            <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
                <template x-for="(_, idx) in currentProjects" :key="idx">
                    <button @click="currentIndex = idx" 
                            class="h-1 transition-all duration-300"
                            :class="idx === currentIndex ? 'bg-[#FFD700] w-8' : 'bg-[#1A2B3C]/30 w-4 hover:bg-[#1A2B3C]'"></button>
                </template>
            </div>
        </div>
    </div>
</section>
