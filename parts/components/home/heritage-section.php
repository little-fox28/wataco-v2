<?php
/**
 * Heritage Section Component
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<section id="heritage-section" class="min-h-screen flex flex-col items-center justify-center bg-white relative overflow-hidden py-12 sm:py-16 md:py-20">
    <div class="max-w-360 mx-auto px-4 sm:px-6 relative z-10 w-full">
        <div class="grid lg:grid-cols-12 gap-8 sm:gap-12 lg:gap-20 items-center">
            
            <div class="lg:col-span-5 relative opacity-0 scale-75 transition-all duration-1000 ease-out heritage-animate" data-delay="0">
                <div class="relative group">
                    <div class="overflow-hidden rounded-[40px] lg:rounded-[100px/75px] border-8 lg:border-12 border-[#F4F7F6] shadow-2xl relative">
                        <img
                            src="https://images.unsplash.com/photo-1542051841857-5f90071e7989?auto=format&fit=crop&q=80&w=1200"
                            alt="<?php echo esc_attr(pll__('The Journey From Sendai to Vietnam')); ?>"
                            class="w-full aspect-4/3 object-cover"
                            loading="lazy"
                        />
                        <div class="absolute top-6 right-6 bg-[#FFD700] p-3 shadow-lg z-10 opacity-0 scale-75 transition-all duration-500 ease-out heritage-animate" data-delay="300">
                            <div class="text-[8px] lg:text-[10px] font-black uppercase tracking-widest text-[#1A2B3C] leading-none mb-1">
                                <?php pll_e('ESTABLISHED'); ?>
                            </div>
                            <div class="text-lg lg:text-xl font-black text-[#1A2B3C] leading-none">
                                <?php pll_e('2015'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                
                <div class="flex items-center space-x-4 mb-6 lg:mb-8 opacity-0 translate-y-8 transition-all duration-700 ease-out heritage-animate" data-delay="200">
                    <div class="p-3 bg-white border border-gray-100 rounded-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#228B22]"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <h3 class="text-[#228b22] font-black text-sm uppercase tracking-[0.5em] font-heading">
                        <?php pll_e('WATANABE CREATE HERITAGE'); ?>
                    </h3>
                </div>

                <div class="opacity-0 translate-y-8 transition-all duration-700 ease-out heritage-animate" data-delay="300">
                    <h2 class="text-3xl sm:text-4xl lg:text-7xl font-black text-[#1A2B3C] mb-6 sm:mb-8 lg:mb-12 tracking-tighter leading-none font-heading">
                        <?php pll_e('The Journey From Sendai to Vietnam'); ?>
                    </h2>
                </div>

                <div class="space-y-6 lg:space-y-8">
                    <div class="grid md:grid-cols-2 gap-6 lg:gap-10">
                        <div class="pl-6 py-1 relative">
                            <!-- Growing Border -->
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#FFD700] scale-y-0 origin-top transition-transform duration-700 ease-out heritage-animate" data-delay="400" data-animation="scale-y-100"></div>
                            
                            <p class="text-lg lg:text-xl text-gray-700 italic font-medium leading-relaxed opacity-0 translate-y-8 transition-all duration-700 ease-out heritage-animate" data-delay="400">
                                "<?php pll_e('WATACO was established on the foundation of WATANABE CREATE Group, Sendai, Japan. Founded on December 17, 2015, WATANABE CREATE has achieved numerous successes in consulting, design and construction of solar-power facilities in Japan, the forerunner nation in renewable-energy technology.'); ?>"
                            </p>
                        </div>
                        <div class="flex flex-col space-y-4 opacity-0 translate-y-8 transition-all duration-700 ease-out heritage-animate" data-delay="500">
                            <p class="text-sm text-gray-500 leading-relaxed font-light">
                                <?php pll_e('WATACO was founded in 2021 in Vietnam, operating in the fields of consulting, design and construction of solar-power projects with the motto "quality creates sustainable prestige". We are committed to delivering the most optimal solutions, tailored to every customer’s requirement down to the smallest detail.'); ?>
                            </p>
                            <p class="text-sm text-gray-500 leading-relaxed font-light">
                                <?php pll_e('In addition, WATACO is expanding into residential construction, renovation and interior finishing, bringing comfortable, modern living spaces to Vietnam. We always listen to our customers’ wishes, craft works worthy of them, and continually learn to be the first choice.'); ?>
                            </p>
                            <div class="flex items-center space-x-2 text-[#228B22] font-bold text-xs uppercase tracking-widest mt-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                <span><?php pll_e('Enterprises & Industrial'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const heritageSection = document.getElementById('heritage-section');
    if (!heritageSection) return;

    const animatedElements = heritageSection.querySelectorAll('.heritage-animate');
    
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animatedElements.forEach(el => {
                    const delay = parseInt(el.getAttribute('data-delay') || 0);
                    const animation = el.getAttribute('data-animation');
                    
                    // Store timeout ID to prevent collisions if scrolling fast
                    if (el.timeoutId) clearTimeout(el.timeoutId);
                    
                    el.timeoutId = setTimeout(() => {
                        if (animation === 'scale-y-100') {
                            el.classList.remove('scale-y-0');
                            el.classList.add('scale-y-100');
                        } else {
                            el.classList.remove('opacity-0', '-translate-x-8', 'translate-y-8', 'scale-75');
                            el.classList.add('opacity-100', 'translate-x-0', 'translate-y-0', 'scale-100');
                        }
                    }, delay);
                });
            } else {
                // Reset states when out of view
                animatedElements.forEach(el => {
                    if (el.timeoutId) clearTimeout(el.timeoutId);
                    const animation = el.getAttribute('data-animation');
                    
                    if (animation === 'scale-y-100') {
                        el.classList.add('scale-y-0');
                        el.classList.remove('scale-y-100');
                    } else {
                        el.classList.add('opacity-0');
                        el.classList.remove('opacity-100', 'translate-x-0', 'translate-y-0', 'scale-100');
                        
                        // Restore specific initial transform classes
                        if (el.classList.contains('lg:col-span-5')) {
                            el.classList.add('scale-75');
                        } else if (el.classList.contains('bg-[#FFD700]')) {
                            el.classList.add('scale-75');
                        } else {
                            el.classList.add('translate-y-8');
                        }
                    }
                });
            }
        });
    }, observerOptions);

    observer.observe(heritageSection);
});
</script>
