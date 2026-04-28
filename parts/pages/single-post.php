<?php
/**
 * Unified Single Post layout — Standard blog/news & Projects.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

// ─── Data Preparation ─────────────────────────────────────────────────
$post_id       = get_the_ID();
$title         = get_the_title();
$content       = apply_filters('the_content', get_the_content());
$excerpt       = get_the_excerpt();
$date          = get_the_date();
$author        = get_the_author();
$permalink     = get_the_permalink();
$categories    = get_the_category();



// ─── Project Context Detection ────────────────────────────────────────
$is_project = function_exists('wataco_is_project') && wataco_is_project($post_id);

// ─── ACF Project fields ───────────────────────────────────────────────
if ($is_project) {
    $location   = get_field('project_location', $post_id) ?: '';
    $capacity   = get_field('project_capacity', $post_id) ?: '';
    $production = get_field('project_production', $post_id) ?: '';
    $year       = get_field('project_year', $post_id) ?: '';
    $status     = get_field('project_status', $post_id) ?: '';
}

// ─── Hero image ───────────────────────────────────────────────────────
$hero_url = '';
if (has_post_thumbnail()) {
    $hero_url = get_the_post_thumbnail_url($post_id, 'full');
} else {
    if ($is_project) {
        $acf_img = get_field('project_img', $post_id);
        if (!empty($acf_img)) {
            $hero_url = is_array($acf_img) ? $acf_img['url'] : wp_get_attachment_url($acf_img);
        }
    }
    if (empty($hero_url)) {
        $xml_hero = get_post_meta($post_id, '_xml_hero_image', true);
        if (!empty($xml_hero)) {
            $hero_url = esc_url($xml_hero);
        }
    }
}

// ─── Polylang Translations ────────────────────────────────────────────
$pll = function_exists('pll__');
$t_home            = $pll ? pll__('Home') : 'Home';
$t_share           = $pll ? pll__('Share') : 'Share';
$t_related         = $pll ? pll__('Related Articles') : 'Related Articles';
$t_need_consult    = $pll ? pll__('Need Consultation?') : 'Need Consultation?';
$t_consult_desc    = $pll ? pll__('Our team of experts is ready to help you find the perfect solar energy solution.') : 'Our team of experts is ready to help you find the perfect solar energy solution.';
$t_call_hotline    = $pll ? pll__('Call Hotline') : 'Call Hotline';
$t_toc             = $pll ? pll__('Table of Contents') : 'Table of Contents';
$t_updating        = $pll ? pll__('Updating...') : 'Updating...';
$t_capacity        = $pll ? pll__('Capacity') : 'Capacity';
$t_year            = $pll ? pll__('Year') : 'Year';
$t_production      = $pll ? pll__('Production') : 'Production';
$t_location        = $pll ? pll__('Location') : 'Location';
$t_project_info    = $pll ? pll__('Project Information') : 'Project Information';
$t_status_label    = ($is_project && !empty($status)) ? ($pll ? pll__($status) : $status) : '';

$global_contact = wataco_get_global_contact_info();

$phone        = $global_contact['phone'] ?: '0359 959 831';
$phone_href   = $global_contact['phone_clean'];
$email        = $global_contact['email'] ?: 'info@wataco.com.vn';

$facebook_url = $global_contact['facebook'] ?: '#';
$linkedin_url = $global_contact['linkedin'] ?: '#';
$zalo_url     = $global_contact['zalo'] ?: '#';

// ─── TOC is now handled by inc/toc.php and parts/components/common/toc.php ───

?>

<!-- ═══ HERO SECTION ═══ -->
<section class="relative z-0 bg-[#1A2B3C] overflow-hidden pt-32 pb-16 lg:pt-48 lg:pb-24">
    <?php if (!empty($hero_url)) : ?>
        <div class="absolute inset-0 -z-10">
            <img src="<?php echo esc_url($hero_url); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover opacity-60 mix-blend-overlay" />
            <div class="absolute inset-0 bg-gradient-to-t from-[#F8FAFC] via-transparent to-transparent"></div>
        </div>
    <?php else : ?>
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#1A2B3C] to-[#0f1b27]"></div>
    <?php endif; ?>

    <div class="relative z-10 w-full max-w-[1440px] mx-auto px-6" x-data="{ shown: false }" x-intersect.once="shown = true">

        <!-- Semantic Breadcrumbs -->
        <?php get_template_part('parts/components/common/breadcrumbs'); ?>

        <!-- Title -->
        <h1 class="text-3xl sm:text-4xl lg:text-6xl font-black text-white leading-tight font-heading max-w-4xl drop-shadow-lg transition-all duration-500"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'" itemprop="headline">
            <?php echo esc_html($title); ?>
        </h1>

        <?php if ($is_project) : ?>
            <!-- Project Quick Stats (Hero) -->
            <?php if (!empty($location) || !empty($capacity) || !empty($year)) : ?>
                <div class="mt-6 flex flex-wrap items-center gap-4 text-white/80 text-xs font-bold uppercase tracking-widest transition-all duration-500 delay-100"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'">
                    <?php if (!empty($location)) : ?>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#FFD700]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <?php echo esc_html($location); ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($status)) : ?>
                        <span class="px-3 py-1 rounded-md text-[10px] font-black border bg-white/10 text-[#FFD700] border-[#FFD700]/30">
                            <?php echo esc_html($t_status_label); ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- ═══ MAIN CONTENT & SIDEBAR GRID ═══ -->
<section class="w-full max-w-[1440px] mx-auto px-6 mt-8 lg:mt-12 pb-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">

        <!-- Left Column: Article Body -->
        <article class="lg:col-span-8 bg-transparent"
                 x-data="{ shown: false }"
                 x-intersect.once="shown = true"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'"
                 style="transition: all 0.5s ease;"
                 itemscope itemtype="http://schema.org/Article">

            <?php if ($is_project && (!empty($capacity) || !empty($production) || !empty($year))) : ?>
                <!-- Project Specs Card -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-10 grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <?php if (!empty($capacity)) : ?>
                        <div>
                            <div class="text-[10px] text-gray-400 uppercase font-bold mb-1"><?php echo esc_html($t_capacity); ?></div>
                            <div class="text-[#1A2B3C] font-black text-lg font-mono tracking-tighter flex items-center">
                                <svg class="w-4 h-4 mr-1 fill-[#1A2B3C]" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <?php echo esc_html($capacity); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($production)) : ?>
                        <div>
                            <div class="text-[10px] text-gray-400 uppercase font-bold mb-1"><?php echo esc_html($t_production); ?></div>
                            <div class="text-[#1A2B3C] font-black text-lg font-mono tracking-tighter"><?php echo esc_html($production); ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($year)) : ?>
                        <div>
                            <div class="text-[10px] text-gray-400 uppercase font-bold mb-1"><?php echo esc_html($t_year); ?></div>
                            <div class="text-[#1A2B3C] font-black text-lg font-mono tracking-tighter"><?php echo esc_html($year); ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($location)) : ?>
                        <div>
                            <div class="text-[10px] text-gray-400 uppercase font-bold mb-1"><?php echo esc_html($t_location); ?></div>
                            <div class="text-[#1A2B3C] font-bold text-sm"><?php echo esc_html($location); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Abstract / Meta Description -->
            <?php if (!empty($excerpt)) : ?>
                <p class="text-xl text-gray-500 font-medium mb-10 leading-relaxed border-l-4 border-[#228B22] pl-6" itemprop="description">
                    <?php echo esc_html($excerpt); ?>
                </p>
            <?php endif; ?>

            <!-- Article Content -->
            <div class="article-prose" itemprop="articleBody">
                <?php echo $content; ?>
            </div>

            <!-- Social Share Footer -->
            <div class="mt-12 py-6 border-y border-gray-100 flex items-center justify-between"
                 x-data="{ copied: false }">
                <span class="text-sm font-bold text-gray-400 uppercase tracking-widest"><?php echo esc_html($t_share); ?></span>
                <div class="flex items-center gap-3">
                    <a  href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-colors" aria-label="Share on Facebook">
                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                    </a>
                    <a  href="<?php echo esc_url($linkedin_url); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-[#0A66C2]/10 text-[#0A66C2] flex items-center justify-center hover:bg-[#0A66C2] hover:text-white transition-colors" aria-label="Share on LinkedIn">
                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"></path></svg>
                    </a>
                    <button @click="navigator.clipboard.writeText('<?php echo esc_js($permalink); ?>'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="w-10 h-10 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-[#1A2B3C] hover:text-white transition-colors relative"
                            aria-label="Copy link">
                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"></path></svg>
                        <span x-show="copied" x-transition class="absolute -top-8 bg-[#1A2B3C] text-white text-[10px] px-2 py-1 rounded whitespace-nowrap">Copied!</span>
                    </button>
                </div>
            </div>
        </article>
                    
        <!-- Right Column: Sidebar -->
        <aside class="lg:col-span-4" role="complementary">
            <div class="sticky top-10 space-y-8">

                <?php if ($is_project && (!empty($capacity) || !empty($location))) : ?>
                    <!-- Project Info Widget -->
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="bg-[#F8FAFC] px-6 py-4 border-b border-gray-100">
                            <h2 class="text-sm font-black text-[#1A2B3C] uppercase tracking-widest m-0"><?php echo esc_html($t_project_info); ?></h2>
                        </div>
                        <div class="p-6 space-y-4 text-sm">
                            <?php if (!empty($location)) : ?>
                                <div class="flex justify-between"><span class="text-gray-400 font-bold"><?php echo esc_html($t_location); ?></span><span class="font-bold text-[#1A2B3C]"><?php echo esc_html($location); ?></span></div>
                            <?php endif; ?>
                            <?php if (!empty($capacity)) : ?>
                                <div class="flex justify-between"><span class="text-gray-400 font-bold"><?php echo esc_html($t_capacity); ?></span><span class="font-bold text-[#1A2B3C] font-mono"><?php echo esc_html($capacity); ?></span></div>
                            <?php endif; ?>
                            <?php if (!empty($production)) : ?>
                                <div class="flex justify-between"><span class="text-gray-400 font-bold"><?php echo esc_html($t_production); ?></span><span class="font-bold text-[#1A2B3C] font-mono"><?php echo esc_html($production); ?></span></div>
                            <?php endif; ?>
                            <?php if (!empty($year)) : ?>
                                <div class="flex justify-between"><span class="text-gray-400 font-bold"><?php echo esc_html($t_year); ?></span><span class="font-bold text-[#1A2B3C] font-mono"><?php echo esc_html($year); ?></span></div>
                            <?php endif; ?>
                            <?php if (!empty($status)) : ?>
                                <div class="flex justify-between items-center"><span class="text-gray-400 font-bold">Status</span><span class="px-3 py-1 rounded-md text-[10px] font-black border bg-white text-[#228B22] border-[#228B22]"><?php echo esc_html($t_status_label); ?></span></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Table of Contents Widget -->
                <?php get_template_part('parts/components/common/toc'); ?>

                <!-- Related Posts Widget -->
                <?php include get_template_directory() . '/parts/components/common/related-posts.php'; ?>

                <!-- CTA Contact Widget -->
                <div class="bg-[#1A2B3C] p-8 rounded-xl text-center text-white relative overflow-hidden shadow-xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#228B22] rounded-full blur-[50px] opacity-30 pointer-events-none"></div>
                    <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm border border-white/20">
                        <svg class="w-7 h-7 text-[#FFD700]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 16.92v3a2 2 0 01-2.18 2 19.78 19.78 0 01-8.63-3.07 19.48 19.48 0 01-6-6A19.78 19.78 0 012.08 4.18 2 2 0 014.06 2h3a2 2 0 012 1.72c.12.9.33 1.78.63 2.62a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.46-1.14a2 2 0 012.11-.45c.84.3 1.72.51 2.62.63A2 2 0 0122 16.92z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black font-heading mb-3 relative z-10 m-0"><?php echo esc_html($t_need_consult); ?></h3>
                    <p class="text-sm text-gray-300 mb-8 font-light relative z-10">
                        <?php echo esc_html($t_consult_desc); ?>
                    </p>
                    
                    <div class="space-y-4 relative z-10">
                        <a href="tel:<?php echo esc_attr($phone_href); ?>"
                           class="block w-full bg-[#228B22] hover:bg-[#FFD700] hover:text-[#1A2B3C] text-white py-4 rounded-md font-bold uppercase tracking-widest text-xs transition-colors shadow-lg text-center">
                            <?php echo esc_html($t_call_hotline); ?> <?php echo esc_html($phone); ?>
                        </a>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</section>
