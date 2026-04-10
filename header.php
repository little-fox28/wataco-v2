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
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> x-data="{ mobileMenuOpen: false }">
    <?php wp_body_open(); ?>

    <!-- Header -->
    <header class="w-full z-50 transition-all duration-300 bg-[#228B22] border-b border-white/5 sticky top-0" 
            x-data="{ isSticky: false }"
            @scroll.window="isSticky = window.scrollY > 0"
            :class="isSticky ? 'fixed bg-[#228B22]/95 backdrop-blur-md shadow-lg' : 'relative'">
        
        <div class="max-w-[1440px] mx-auto px-6 h-16 lg:h-20 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<span class="text-white font-bold text-xl">' . esc_html(bloginfo('name')) . '</span>';
                    }
                    ?>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex space-x-10 items-center text-[11px] font-bold uppercase tracking-[0.2em] text-white/90">
                <?php
                wp_nav_menu(array(
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

            <!-- Mobile Hamburger Button -->
            <button class="lg:hidden text-white p-2"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    aria-label="Toggle menu"
                    :aria-expanded="mobileMenuOpen">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             class="fixed inset-0 z-[60] bg-[#1A2B3C] text-white flex flex-col p-6 lg:hidden"
             x-transition
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
                <button @click="mobileMenuOpen = false" 
                        class="p-2"
                        aria-label="Close menu">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <nav class="flex flex-col space-y-6 text-xl font-bold uppercase tracking-widest mb-auto">
                <?php
                wp_nav_menu(array(
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
            <div class="flex flex-col space-y-6">
                <!-- Language Switcher -->
                <div class="flex space-x-6 text-sm font-bold">
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
                   class="bg-[#228B22] text-white w-full py-4 rounded-md font-black uppercase tracking-widest min-h-[44px] flex items-center justify-center hover:bg-[#1a6b1a] transition-colors"
                   @click="mobileMenuOpen = false">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <?php echo esc_html(pll__('Get Quote')); ?>
                </a>
            </div>
        </div>
    </header>

    <div id="page" class="min-h-screen flex flex-col">
        <div id="content" class="site-content grow">
            <?php do_action('tailpress_content_start'); ?>
            <main>
