<?php
if (!defined('ABSPATH')) {
    exit;
}

status_header(404);
nocache_headers();

$not_found_title = function_exists('pll__') ? pll__('PAGE NOT FOUND') : 'PAGE NOT FOUND';
$not_found_desc = function_exists('pll__') ? pll__('The page you are looking for does not exist, has been removed, or is temporarily unavailable.') : 'The page you are looking for does not exist, has been removed, or is temporarily unavailable.';
$back_home_label = function_exists('pll__') ? pll__('BACK TO HOMEPAGE') : 'BACK TO HOMEPAGE';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('min-h-screen bg-[#1A2B3C] selection:bg-[#228B22] selection:text-white'); ?>>
    <?php wp_body_open(); ?>

    <main class="min-h-screen flex flex-col items-center justify-center px-6 text-center">
        <div class="flex flex-col items-center">
            <h1 class="text-[100px] md:text-[150px] font-black text-white leading-none tracking-tighter mt-8 mb-2 drop-shadow-md select-none">404</h1>
            <h2 class="text-xl md:text-2xl font-bold text-[#FFD700] uppercase tracking-widest mb-6"><?php echo esc_html($not_found_title); ?></h2>
            <p class="text-gray-400 text-sm md:text-base font-light max-w-md mx-auto mb-10 leading-relaxed">
                <?php echo esc_html($not_found_desc); ?>
            </p>

            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full font-black uppercase tracking-widest text-xs transition-all duration-300 bg-white text-[#1A2B3C] hover:bg-[#228B22] hover:text-white shadow-lg group">
                <svg class="w-4 h-4 mr-3 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 18l-6-6 6-6"></path>
                </svg>
                <?php echo esc_html($back_home_label); ?>
            </a>
        </div>
    </main>

    <?php wp_footer(); ?>
</body>
</html>
