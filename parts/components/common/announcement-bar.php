<?php
/**
 * Official Announcement Top Bar Component
 *
 * @package Wataco
 */

// Don't load directly
if (!defined('ABSPATH')) {
    exit;
}

$current_lang = function_exists('pll_current_language') ? (string) pll_current_language('slug') : 'vi';
if ($current_lang === '') {
    $current_lang = 'vi';
}

// Resolve the detailed announcement post URL by language (with safe fallback to localized News page).
$notice_detail_url = function_exists('wataco_get_localized_posts_page_url') ? wataco_get_localized_posts_page_url() : '';
$notice_category_map = array(
    'vi' => array('model-notice-vn', 'modal-thong-bao', 'tin-tuc', 'news'),
    'en' => array('model-notice-en', 'modal-thong-bao', 'news', 'news'),
    'ja' => array('model-notice-jp', 'modal-thong-bao', 'ニュース', 'news'),
);
$candidate_cat_slugs = $notice_category_map[$current_lang] ?? $notice_category_map['vi'];

$notice_post_query = new WP_Query(array(
    'post_type'              => 'post',
    'post_status'            => 'publish',
    'posts_per_page'         => 1,
    'no_found_rows'          => true,
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'lang'                   => $current_lang,
    'tax_query'              => array(
        array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $candidate_cat_slugs,
        ),
    ),
));

if (!empty($notice_post_query->posts) && $notice_post_query->posts[0] instanceof WP_Post) {
    $resolved_permalink = get_permalink($notice_post_query->posts[0]->ID);
    if (is_string($resolved_permalink) && $resolved_permalink !== '') {
        $notice_detail_url = $resolved_permalink;
    }
}

if ($notice_detail_url === '') {
    $notice_detail_url = home_url('/news/');
}

if ($current_lang === 'en') {
    $notice_badge_label = 'OFFICIAL NOTICE';
    $notice_cta_label   = 'Read full article';
} elseif ($current_lang === 'ja') {
    $notice_badge_label = '重要なお知らせ';
    $notice_cta_label   = '詳細記事を読む';
} else {
    $notice_badge_label = 'THÔNG BÁO CHÍNH THỨC';
    $notice_cta_label   = 'Xem bài viết chi tiết';
}
?>
<style>
    @keyframes wataco-marquee-scroll {
        0% { transform: translate3d(0, 0, 0); }
        100% { transform: translate3d(-50%, 0, 0); }
    }
    .wataco-marquee-track {
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
        width: max-content;
        animation: wataco-marquee-scroll 38s linear infinite;
        will-change: transform;
    }
    .wataco-marquee-viewport {
        mask-image: linear-gradient(to right, transparent 0%, black 2%, black 98%, transparent 100%);
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 2%, black 98%, transparent 100%);
    }
    .wataco-marquee-container:hover .wataco-marquee-track {
        animation-play-state: paused;
    }
    @media (prefers-reduced-motion: reduce) {
        .wataco-marquee-track {
            animation: none;
        }
    }
</style>

<div class="wataco-marquee-container relative bg-[#1A2B3C] text-white border-b border-white/10 w-full z-50">
    <div class="max-w-360 mx-auto px-4 lg:px-6 h-10 flex items-center justify-between gap-3">

        <!-- Left Brand Badge (Luôn hiển thị flex trên cả mobile & desktop) -->
        <div class="inline-flex items-center gap-1.5 bg-[#FFD700] text-[#1A2B3C] px-3 py-1 rounded-sm text-[10px] font-black uppercase tracking-[0.15em] shrink-0 shadow-xs">
            <svg class="w-3.5 h-3.5 text-[#1A2B3C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <span><?php echo esc_html($notice_badge_label); ?></span>
        </div>

        <!-- Marquee Viewport -->
        <div class="wataco-marquee-viewport relative flex-1 overflow-hidden">
            <div class="wataco-marquee-track text-xs sm:text-[13px] text-white/90 tracking-wide">
                <?php for ($loop_i = 0; $loop_i < 2; $loop_i++) : ?>
                    <div class="inline-flex items-center gap-3 pr-24 sm:pr-32" style="padding-right: 6rem;" <?php echo $loop_i === 1 ? 'aria-hidden="true"' : ''; ?>>
                        <?php if ($current_lang === 'en') : ?>
                            <strong class="font-bold text-[#FFD700] uppercase tracking-wider mr-2">OFFICIAL DOMAIN &amp; SECURITY NOTICE:</strong>
                            <span>
                                WATACO Co., Ltd. currently uses EXCLUSIVELY the domain 
                                <a href="https://wataco.com.vn" class="text-[#FFD700] font-bold underline decoration-[#FFD700]/60 hover:decoration-[#FFD700] mx-1">wataco.com.vn</a>. 
                                The old domain (<code class="text-white/80 bg-white/10 px-1 py-0.5 rounded-xs text-[11px]">wataco.net</code>) has ceased operations and is no longer under the management of WATACO. Valued Clients &amp; Partners, please only access the new domain.
                            </span>
                            <a href="<?php echo esc_url($notice_detail_url); ?>" class="inline-flex items-center gap-1 ml-3 text-[#FFD700] hover:text-white font-black uppercase tracking-widest text-[11px] transition-colors underline underline-offset-4">
                                <span><?php echo esc_html($notice_cta_label); ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>

                        <?php elseif ($current_lang === 'ja') : ?>
                            <strong class="font-bold text-[#FFD700] tracking-wider mr-2">【公式ドメインおよびセキュリティに関する重要なお知らせ】</strong>
                            <span>
                                WATACO有限会社は現在、公式ドメイン 
                                <a href="https://wataco.com.vn" class="text-[#FFD700] font-bold underline decoration-[#FFD700]/60 hover:decoration-[#FFD700] mx-1">wataco.com.vn</a> 
                                のみを使用しております。旧ドメイン（<code class="text-white/80 bg-white/10 px-1 py-0.5 rounded-xs text-[11px]">wataco.net</code>）は運用を停止しており、弊社の管理下にはございません。お取引先様および関係者の皆様におかれましては、新ドメインのみへアクセスいただきますようお願いいたします。
                            </span>
                            <a href="<?php echo esc_url($notice_detail_url); ?>" class="inline-flex items-center gap-1 ml-3 text-[#FFD700] hover:text-white font-bold text-[11px] transition-colors underline underline-offset-4">
                                <span><?php echo esc_html($notice_cta_label); ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>

                        <?php else : ?>
                            <strong class="font-bold text-[#FFD700] uppercase tracking-wider mr-2">THÔNG BÁO BẢO MẬT &amp; TÊN MIỀN CHÍNH THỨC:</strong>
                            <span>
                                Công ty TNHH WATACO hiện tại chỉ sử dụng DUY NHẤT tên miền 
                                <a href="https://wataco.com.vn" class="text-[#FFD700] font-bold underline decoration-[#FFD700]/60 hover:decoration-[#FFD700] mx-1">wataco.com.vn</a>. 
                                Tên miền cũ (<code class="text-white/80 bg-white/10 px-1 py-0.5 rounded-xs text-[11px]">wataco.net</code>) đã ngưng hoạt động và không còn thuộc quyền quản lý của WATACO. Quý Khách hàng &amp; Đối tác vui lòng chỉ truy cập tên miền mới.
                            </span>
                            <a href="<?php echo esc_url($notice_detail_url); ?>" class="inline-flex items-center gap-1 ml-3 text-[#FFD700] hover:text-white font-black uppercase tracking-widest text-[11px] transition-colors underline underline-offset-4">
                                <span><?php echo esc_html($notice_cta_label); ?></span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Right Quick Action Link (Luôn hiển thị flex trên desktop, không dùng class hidden) -->
        <a href="<?php echo esc_url($notice_detail_url); ?>"
           class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest text-[#FFD700] hover:text-white transition-colors shrink-0 pl-3 border-l border-white/15 whitespace-nowrap">
            <span><?php echo esc_html($notice_cta_label); ?></span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

    </div>
</div>
