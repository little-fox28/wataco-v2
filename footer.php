<?php
/**
 * Footer Template
 * 
 * @package Wataco
 */

// Don't load directly
if (!defined('ABSPATH')) {
    exit;
}

$social_links = wataco_get_social_links();
$contact_info = wataco_get_contact_info();
?>
            </main>

            <?php do_action('tailpress_content_end'); ?>
        </div>

        <?php do_action('tailpress_content_after'); ?>

        <!-- Footer -->
        <footer class="bg-[#1A2B3C] text-white pt-24 pb-12 border-t border-white/10">
            <div class="max-w-[1440px] mx-auto px-6">
                <!-- Footer Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">
                    <!-- Column 1: Brand -->
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <?php
                            if (has_custom_logo()) {
                                the_custom_logo();
                            } else {
                                echo '<span class="text-white font-bold text-lg">' . esc_html(bloginfo('name')) . '</span>';
                            }
                            ?>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            <?php echo esc_html(bloginfo('description')); ?>
                        </p>
                        <!-- Social Links -->
                        <div class="flex space-x-4">
                            <?php if (!empty($social_links['linkedin'])) : ?>
                                <a href="<?php echo esc_url($social_links['linkedin']); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   aria-label="<?php esc_attr_e('Visit us on LinkedIn'); ?>"
                                   class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#228B22] transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($social_links['facebook'])) : ?>
                                <a href="<?php echo esc_url($social_links['facebook']); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   aria-label="<?php esc_attr_e('Visit us on Facebook'); ?>"
                                   class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#228B22] transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($social_links['youtube'])) : ?>
                                <a href="<?php echo esc_url($social_links['youtube']); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   aria-label="<?php esc_attr_e('Visit us on YouTube'); ?>"
                                   class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#228B22] transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Column 2: Solutions -->
                    <div>
                        <h3 class="text-lg font-bold text-white mb-6"><?php echo esc_html(pll__('Solutions')); ?></h3>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('Web Development')); ?></a></li>
                            <li><a href="#" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('Mobile Apps')); ?></a></li>
                            <li><a href="#" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('Cloud Services')); ?></a></li>
                            <li><a href="#" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('Consulting')); ?></a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Company -->
                    <div>
                        <h3 class="text-lg font-bold text-white mb-6"><?php echo esc_html(pll__('Company')); ?></h3>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li><a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('About Us')); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/careers/')); ?>" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('Careers')); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/news/')); ?>" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('News')); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/projects/')); ?>" class="hover:text-[#FFD700] transition-colors"><?php echo esc_html(pll__('Projects')); ?></a></li>
                        </ul>
                    </div>

                    <!-- Column 4: Contact -->
                    <div>
                        <h3 class="text-lg font-bold text-white mb-6"><?php echo esc_html(pll__('Contact')); ?></h3>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <?php if (!empty($contact_info['address_1'])) : ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-[#228B22] flex-shrink-0 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span><?php echo esc_html($contact_info['address_1']); ?></span>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($contact_info['address_2'])) : ?>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-[#228B22] flex-shrink-0 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span><?php echo esc_html($contact_info['address_2']); ?></span>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($contact_info['email'])) : ?>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-[#228B22] flex-shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <a href="<?php echo esc_url('mailto:' . $contact_info['email']); ?>" class="hover:text-white transition-colors"><?php echo esc_html($contact_info['email']); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($contact_info['phone'])) : ?>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-[#228B22] flex-shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <a href="<?php echo esc_url('tel:' . str_replace(array(' ', '-', '(', ')'), '', $contact_info['phone'])); ?>" class="hover:text-white transition-colors"><?php echo esc_html($contact_info['phone']); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                    <p>&copy; <?php echo esc_html(wataco_get_current_year()); ?> <?php bloginfo('name'); ?>. <?php echo esc_html(pll__('All rights reserved')); ?></p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="<?php echo esc_url(wataco_get_privacy_page_url()); ?>" class="hover:text-white transition-colors"><?php echo esc_html(pll__('Privacy')); ?></a>
                        <a href="<?php echo esc_url(wataco_get_terms_page_url()); ?>" class="hover:text-white transition-colors"><?php echo esc_html(pll__('Terms')); ?></a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Floating Contact Buttons -->
        <?php get_template_part('parts/floating-contact'); ?>
    </div>

    <?php wp_footer(); ?>
</body>
</html>
