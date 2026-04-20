<?php
if (!defined('ABSPATH')) {
    exit;
}

$footer_data = function_exists('wataco_get_footer_data') ? wataco_get_footer_data() : array();

$linkedin_url = (string) ($footer_data['linkedin'] ?? '');
$facebook_url = (string) ($footer_data['facebook'] ?? '');
$zalo_url = (string) ($footer_data['zalo'] ?? '');
$tiktok_url = (string) ($footer_data['tiktok'] ?? '');
$youtube_url = (string) ($footer_data['youtube'] ?? '');
$email = (string) ($footer_data['email'] ?? '');
$phone = (string) ($footer_data['phone'] ?? '');
$footer_description = (string) ($footer_data['company_description'] ?? (function_exists('pll__') ? pll__('Company Description') : ''));
$address_1 = function_exists('pll__') ? pll__('Address 1 (HQ)') : 'Address 1 (HQ)';
$address_2 = function_exists('pll__') ? pll__('Address 2 (Branch)') : 'Address 2 (Branch)';
$title_solutions = function_exists('pll__') ? pll__('Tiêu đề footer cột 2') : 'Tiêu đề footer cột 2';
$title_about = function_exists('pll__') ? pll__('Tiêu đề footer cột 3') : 'Tiêu đề footer cột 3';
$title_contact = function_exists('pll__') ? pll__('Tiêu đề footer cột 4') : 'Tiêu đề footer cột 4';
?>
    </main>

            <?php do_action('tailpress_content_end'); ?>
        </div>

            <?php do_action('tailpress_content_after'); ?>

        <footer class="bg-[#1A2B3C] text-white pt-24 pb-12 border-t border-white/10 relative overflow-hidden font-jp-style" role="contentinfo">
            <!-- Watermark Logo -->
            <div class="absolute top-0 right-0 p-12 opacity-5 pointer-events-none transform scale-120 origin-top-right">
                <?php get_template_part('parts/logo', null, array('class' => 'pointer-events-none scale-150 origin-top-right')); ?>
            </div>

            <div class="max-w-[1440px] mx-auto px-6 relative z-10">
                <!-- Footer Grid - 4 Columns Responsive -->
                <div class="grid lg:grid-cols-4 gap-12 mb-20">
                    
                    <!-- Column 1: Brand -->
                    <div class="space-y-6">
                        <?php get_template_part('parts/logo', null, array('class' => 'h-10 w-auto')); ?>

                        <?php if (!empty($footer_description)) : ?>
                            <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                                <?php echo esc_html($footer_description); ?>
                            </p>
                        <?php endif; ?>
                        
                        <ul class="inline-flex space-x-3 text-sm text-gray-300">
                            <?php if (!empty($linkedin_url)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($linkedin_url); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 transition-colors" aria-label="LinkedIn">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" role="img" aria-hidden="true">
                                            <rect x="2" y="9" width="4" height="12"></rect>
                                            <circle cx="4" cy="4" r="2"></circle>
                                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                        </svg>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($facebook_url)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 transition-colors" aria-label="Facebook">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" role="img" aria-hidden="true">
                                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                                        </svg>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($zalo_url)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($zalo_url); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 transition-colors" aria-label="Zalo">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" role="img" aria-hidden="true">
                                            <circle cx="12" cy="12" r="9"></circle>
                                            <path d="M9 9h6l-6 6h6"></path>
                                        </svg>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($tiktok_url)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($tiktok_url); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 transition-colors" aria-label="TikTok">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" role="img" aria-hidden="true">
                                            <path d="M14 4v10a4 4 0 11-2-3.46"></path>
                                            <path d="M14 4a6 6 0 006 6"></path>
                                        </svg>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($phone)) : ?>
                                <li>
                                    <a href="<?php echo esc_url('tel:' . preg_replace('/[^0-9+]/', '', $phone)); ?>" class="flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 transition-colors" aria-label="Phone">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" role="img" aria-hidden="true">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.78 19.78 0 0 1-8.63-3.07 19.48 19.48 0 0 1-6-6A19.78 19.78 0 0 1 2.08 4.18 2 2 0 0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.63 2.62a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.46-1.14a2 2 0 0 1 2.11-.45c.84.3 1.72.51 2.62.63A2 2 0 0 1 22 16.92z"></path>
                                        </svg>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- Column 2: Solutions -->
                    <div>
                        <h3 class="text-lg font-bold text-white mb-6"><?php echo esc_html($title_solutions); ?></h3>
                        <?php
                        echo wataco_get_cached_nav_menu_markup(
                            wataco_get_footer_nav_menu_args(
                                'footer_solutions_menu',
                                false
                            )
                        );
                        ?>
                        
                        <!-- Certificates Grid -->
                        <div class="mt-8">
                            <h4 class="text-sm font-semibold text-gray-300 mb-4"><?php echo esc_html(pll__('Certifications')); ?></h4>
                            <?php get_template_part('parts/certificate-grid'); ?>
                        </div>
                    </div>

                    <!-- Column 3: About -->
                    <div>
                        <h3 class="text-lg font-bold text-white mb-6"><?php echo esc_html($title_about); ?></h3>
                        <?php
                        echo wataco_get_cached_nav_menu_markup(
                            wataco_get_footer_nav_menu_args(
                                'footer_about_menu',
                                false
                            )
                        );
                        ?>
                    </div>

                    <!-- Column 4: Contact -->
                    <div class="relative">
                        <div class="relative z-10">
                            <h3 class="text-lg font-bold text-white mb-6"><?php echo esc_html($title_contact); ?></h3>
                            <ul class="space-y-4 text-sm text-gray-400">
                            <?php if (!empty($address_1)) : ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-[#228B22] flex-shrink-0 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" role="img" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span><?php echo esc_html($address_1); ?></span>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($address_2)) : ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-[#228B22] flex-shrink-0 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" role="img" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span><?php echo esc_html($address_2); ?></span>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($email)) : ?>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-[#228B22] flex-shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" role="img" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <a href="<?php echo esc_url('mailto:' . antispambot($email)); ?>" class="hover:text-white transition-colors">
                                        <?php echo esc_html(antispambot($email)); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($phone)) : ?>
                                <li>
                                    <a href="<?php echo esc_url('tel:' . preg_replace('/[^0-9+]/', '', $phone)); ?>" class="inline-flex items-center gap-3 hover:text-white transition-colors">
                                        <svg class="w-5 h-5 text-[#228B22] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" role="img" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 16.92v3a2 2 0 01-2.18 2 19.78 19.78 0 01-8.63-3.07 19.48 19.48 0 01-6-6A19.78 19.78 0 012.08 4.18 2 2 0 014.06 2h3a2 2 0 012 1.72c.12.9.33 1.78.63 2.62a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.46-1.14a2 2 0 012.11-.45c.84.3 1.72.51 2.62.63A2 2 0 0122 16.92z"></path>
                                        </svg>
                                        <span><?php echo esc_html($phone); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                    <p><?php echo esc_html(sprintf(pll__('© %1$s %2$s. All rights reserved'), wataco_get_current_year(), get_bloginfo('name'))); ?></p>
                    <nav class="flex space-x-6 mt-4 md:mt-0">
                        <a href="<?php echo esc_url(wataco_get_privacy_page_url()); ?>" class="hover:text-white transition-colors">
                            <?php echo esc_html(pll__('Privacy')); ?>
                        </a>
                        <a href="<?php echo esc_url(wataco_get_terms_page_url()); ?>" class="hover:text-white transition-colors">
                            <?php echo esc_html(pll__('Terms')); ?>
                        </a>
                    </nav>
                </div>
            </div>

            <?php
            /**
             * RankMath JSON-LD Schema
             * Outputs Organization and WebSite schema for SEO
             */
            wataco_output_footer_schema();
            ?>
        </footer>

        <!-- Floating Contact Buttons -->
        <?php get_template_part('parts/floating-contact'); ?>
    </div>

    <?php wp_footer(); ?>
</body>
</html>
