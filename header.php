<?php
/**
 * Header Template
 * 
 * @package Wataco
 */

// Don't load directly
if (!defined('ABSPATH')) {
    exit;
}

$request_path = wp_parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
$is_post_page = is_singular('post') || (is_string($request_path) && strpos($request_path, '/posts/') === 0);
$back_fallback_url = wp_get_referer();
if (empty($back_fallback_url)) {
    $back_fallback_url = home_url('/news/');
}
$mobile_languages = array();
if (function_exists('pll_the_languages')) {
    $language_rows = pll_the_languages(array(
        'raw' => 1,
    ));
    if (is_array($language_rows)) {
        $mobile_languages = $language_rows;
    }
}
$language_labels = array(
    'vi' => 'VN',
    'en' => 'EN',
    'ja' => 'JP',
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- Header -->
    <header class="w-full z-50 transition-all duration-300 bg-[#228B22] border-b border-white/5 sticky top-0" 
            x-data="{ isSticky: false, mobileMenuOpen: false }"
            @scroll.window="isSticky = window.scrollY > 0"
            :class="isSticky ? 'fixed bg-[#228B22]/95 backdrop-blur-md shadow-lg' : 'relative'">
        
        <div class="max-w-[1440px] mx-auto px-4 lg:px-6 h-16 lg:h-20 flex items-center justify-between">
            <!-- Desktop Logo -->
            <div class="hidden lg:block">
                <?php
                get_template_part('parts/logo', null, array(
                    'show_branding' => true,
                    'class' => ''
                ));
                ?>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex space-x-10 items-center text-[12px] font-bold uppercase tracking-[0.2em] text-white/90">
                <?php
                echo wataco_get_cached_nav_menu_markup(array(
                    'theme_location'  => 'primary_menu',
                    'container'       => false,
                    'fallback_cb'     => false,
                    'items_wrap'      => '%3$s',
                    'depth'           => 1,
                    'link_before'     => '<span class="hover:text-[#FFD700] transition-colors cursor-pointer">',
                    'link_after'      => '</span>',
                ));
                ?>

                <!-- Divider -->
                <div class="h-4 w-px bg-white/20"></div>

                <!-- Language Switcher -->
                <div class="flex items-center space-x-3 text-xs">
                    <?php
                    if (function_exists('pll_the_languages')) {
                        pll_the_languages(array(
                            'display_names_as' => 'slug',
                            'dropdown'         => 0,
                        ));
                    }
                    ?>
                </div>

                <!-- CTA Button -->
                <a href="<?php echo esc_url(wataco_get_contact_page_url()); ?>" 
                   class="bg-white text-[#228B22] px-6 py-2.5 rounded-md text-[10px] font-black tracking-widest hover:scale-105 transition-all uppercase shadow-lg border border-transparent hover:bg-[#FFD700] hover:text-[#1A2B3C] flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <?php echo esc_html(pll__('Get Quote')); ?>
                </a>
            </nav>

            <!-- Mobile Header -->
            <?php if ($is_post_page) : ?>
                <div class="lg:hidden relative w-full flex items-center justify-between">
                    <button
                        type="button"
                        class="relative z-20 flex items-center justify-center w-9 h-9 rounded-full text-white/80 hover:text-[#FFD700] hover:bg-white/10 transition-all"
                        data-fallback-url="<?php echo esc_url($back_fallback_url); ?>"
                        @click="if (window.history.length > 1 && document.referrer !== '') { window.history.back(); } else { window.location.href = $el.dataset.fallbackUrl; }"
                        aria-label="<?php echo esc_attr__('Go back', 'wataco'); ?>">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 18l-6-6 6-6"></path>
                        </svg>
                    </button>

                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="pointer-events-none">
                            <?php
                            get_template_part('parts/logo', null, array(
                                'show_branding' => true,
                                'class' => ''
                            ));
                            ?>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="relative z-20 text-white p-2"
                        data-mobile-menu-open
                        @click.prevent="mobileMenuOpen = true"
                        aria-label="Toggle menu"
                        :aria-expanded="mobileMenuOpen">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            <?php else : ?>
                <div class="lg:hidden w-full flex items-center justify-between">
                    <?php
                    get_template_part('parts/logo', null, array(
                        'show_branding' => true,
                        'class' => ''
                    ));
                    ?>
                    <button
                        type="button"
                        class="text-white p-2"
                        data-mobile-menu-open
                        @click.prevent="mobileMenuOpen = true"
                        aria-label="Toggle menu"
                        :aria-expanded="mobileMenuOpen">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu-panel"
             x-show="mobileMenuOpen"
             x-cloak
             class="fixed inset-0 z-[60] bg-[#1A2B3C] text-white flex flex-col p-6 lg:hidden transform-gpu"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-full"
             style="display: none;">
            
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<span class="text-white font-bold text-xl">' . esc_html(bloginfo('name')) . '</span>';
                    }
                    ?>
                </div>
                <button type="button"
                        data-mobile-menu-close
                        @click.prevent="mobileMenuOpen = false" 
                        class="p-2"
                        aria-label="Close menu">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <nav class="flex flex-col space-y-6 text-xl font-bold uppercase tracking-widest">
                <?php
                echo wataco_get_cached_nav_menu_markup(array(
                    'theme_location'  => 'primary_menu',
                    'container'       => false,
                    'fallback_cb'     => false,
                    'items_wrap'      => '%3$s',
                    'depth'           => 1,
                    'link_before'     => '<span class="hover:text-[#FFD700] border-b border-white/10 pb-4 block cursor-pointer" @click="mobileMenuOpen = false">',
                    'link_after'      => '</span>',
                ));
                ?>
            </nav>

            <!-- Mobile Footer -->
            <div class="mt-auto flex flex-col space-y-6">
                <!-- Language Switcher -->
                <div class="flex space-x-6 text-sm font-bold">
                    <?php if (!empty($mobile_languages)) : ?>
                        <?php foreach ($mobile_languages as $language) : ?>
                            <?php
                            $slug = sanitize_key((string) ($language['slug'] ?? ''));
                            $label = $language_labels[$slug] ?? strtoupper($slug);
                            $is_current = !empty($language['current_lang']);
                            ?>
                            <a
                                href="<?php echo esc_url((string) ($language['url'] ?? '#')); ?>"
                                class="<?php echo esc_attr($is_current ? 'text-[#FFD700]' : 'text-gray-400 hover:text-white transition-colors'); ?>">
                                <?php echo esc_html($label); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- CTA Button -->
                <a href="<?php echo esc_url(wataco_get_contact_page_url()); ?>"
                   class="bg-[#228B22] text-white w-full py-4 rounded-md font-black uppercase tracking-widest min-h-11 flex items-center justify-center hover:bg-[#1a6b1a] transition-colors"
                   @click="mobileMenuOpen = false">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <?php echo esc_html(pll__('Get Quote')); ?>
                </a>
            </div>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.Alpine) {
                return;
            }

            var panel = document.getElementById('mobile-menu-panel');
            if (!panel) {
                return;
            }

            var openButtons = document.querySelectorAll('[data-mobile-menu-open]');
            var closeButtons = document.querySelectorAll('[data-mobile-menu-close]');

            openButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    panel.style.display = 'flex';
                });
            });

            closeButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    panel.style.display = 'none';
                });
            });
        });
    </script>

    <div id="page" class="min-h-screen flex flex-col">
        <div id="content" class="site-content grow">
            <?php do_action('tailpress_content_start'); ?>
            <main>
