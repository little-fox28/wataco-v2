<?php
if (!defined('ABSPATH')) {
    exit;
}

$pll = function_exists('pll__');
$subtitle = $pll ? pll__('Join WATACO') : 'Join WATACO';
$title1 = $pll ? pll__('CREATE THE FUTURE') : 'CREATE THE FUTURE';
$title2 = $pll ? pll__('OF GREEN ENERGY') : 'OF GREEN ENERGY';
$desc = $pll ? pll__('We are looking for passionate and enthusiastic associates to build a sustainable energy foundation for Vietnam together.') : 'We are looking for passionate and enthusiastic associates to build a sustainable energy foundation for Vietnam together.';
$button = $pll ? pll__('View open positions') : 'View open positions';
$image_alt = $pll ? pll__('Professional working team') : 'Professional working team';
?>

<section class="relative h-[50vh] lg:h-[75vh] flex items-center justify-center overflow-hidden bg-[#F0FDF4]">
    <div class="absolute inset-0">
        <img
            src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&q=80&w=2000"
            class="w-full h-full object-cover opacity-90"
            alt="<?php echo esc_attr($image_alt); ?>"
        />
        <div class="absolute inset-0 bg-linear-to-r from-[#228B22]/20 to-[#228B22]/40 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative z-10 text-center px-6 max-w-4xl" x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="transition-all duration-700 delay-100 ease-out" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h3 class="text-[#FFD700] font-black text-xs lg:text-sm uppercase tracking-[0.5em] mb-4 font-heading drop-shadow-md">
                <?php echo esc_html($subtitle); ?>
            </h3>
            <h1 class="text-4xl lg:text-7xl font-black text-white leading-tight font-heading mb-6 tracking-tight drop-shadow-lg">
                <?php echo esc_html($title1); ?><br /><span class="text-white"><?php echo esc_html($title2); ?></span>
            </h1>
            <p class="text-white text-base lg:text-xl max-w-2xl mx-auto font-medium leading-relaxed mb-8 drop-shadow-md">
                <?php echo esc_html($desc); ?>
            </p>
            <button @click="document.getElementById('jobs').scrollIntoView({ behavior: 'smooth' })" class="bg-[#FFD700] text-[#1A2B3C] px-8 py-4 rounded-md font-black uppercase tracking-widest hover:bg-white hover:text-[#228B22] transition-all shadow-xl">
                <?php echo esc_html($button); ?>
            </button>
        </div>
    </div>
</section>
