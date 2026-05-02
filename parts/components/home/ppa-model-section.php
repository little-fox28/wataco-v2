<?php
/**
 * PPA Model Section Component
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$data = wataco_get_home_data()['ppa'];

// Diagram Translations
$ppa_diagram_translations = array(
    'vn' => array(
        'investor' => 'QUỸ ĐẦU TƯ',
        'client'   => 'KHÁCH HÀNG',
        'epc'      => 'TỔNG THẦU EPC',
        'payment'  => "Thanh toán tiền ĐMT\nsử dụng hàng tháng",
        'funding'  => "Cấp vốn thực hiện và\nduy trì hệ thống ĐMT",
        'process'  => array(
            "Thiết kế, Cung cấp vật tư, Thi công lắp đặt",
            "Hoàn tất các thủ tục cần thiết",
            "Vận hành và Bảo dưỡng"
        )
    ),
    'en' => array(
        'investor' => "INVESTMENT\nFUND",
        'client'   => "CLIENT",
        'epc'      => "EPC CONTRACTOR",
        'payment'  => "Monthly Solar Power\nUsage Payment",
        'funding'  => "Funding for Solar System\nImplementation & Maintenance",
        'process'  => array(
            "Design, Procurement, & Construction Installation",
            "Completion of Necessary Procedures",
            "Operation and Maintenance (O&M)"
        )
    ),
    'ja' => array(
        'investor' => "投資ファンド",
        'client'   => "顧客",
        'epc'      => "EPC元請け業者",
        'payment'  => "月々の太陽光発電\n使用料支払い",
        'funding'  => "太陽光発電システムの\n構築・維持資金調達",
        'process'  => array(
            "設計、調達、建設・設置",
            "必要な手続きの完了",
            "運転・保守 (O&M)"
        )
    )
);

$current_lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'en';
$dt = $ppa_diagram_translations[$current_lang] ?? $ppa_diagram_translations['en'];
?>

<section id="section-ppa" class="min-h-screen flex flex-col items-center justify-center bg-[#0B1120] text-white relative overflow-hidden py-12 sm:py-16 md:py-20" x-data="{ shown: false }" x-intersect.once="shown = true">
    <div class="absolute inset-0 z-0">
        <img
            src="https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?auto=format&fit=crop&q=80&w=2000"
            alt="Solar Panels Background"
            class="w-full h-full object-center"
        />
        <div class="absolute inset-0 bg-[#1A2B3C]/70"></div>
    </div>

    <div class="max-w-360 mx-auto px-6 relative z-10 w-full">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-20 items-center">

            <!-- Left Column: Diagram -->
            <div class="lg:col-span-6 flex justify-center lg:justify-start transform transition-all duration-1000"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'">
                <div class="relative w-[85%] max-w-225 mx-auto font-sans select-none">
                    <!-- Base Image -->
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/ppa.png'); ?>" alt="PPA Model Base" class="w-full block rounded-2xl" />

                    <!-- Text Overlay -->
                    <div class="absolute inset-0">
                        <!-- Investment Fund (Top) -->
                        <div class="absolute top-[33%] left-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-[clamp(8px,1.4vw,13px)] font-bold text-center">
                            <?php echo nl2br(esc_html($dt['investor'])); ?>
                        </div>

                        <!-- Client (Bottom Left) -->
                        <div class="absolute top-[66%] left-[34%] -translate-x-1/2 -translate-y-1/2 text-white text-[clamp(8px,1.4vw,14px)] text-center">
                            <div class="font-bold"><?php echo esc_html($dt['client']); ?></div>
                        </div>

                        <!-- EPC Contractor (Bottom Right) -->
                        <div class="absolute top-[66%] left-[66%] -translate-x-1/2 -translate-y-1/2 text-white text-[clamp(8px,1.4vw,14px)] text-center">
                            <div class="font-bold"><?php echo esc_html($dt['epc']); ?></div>
                        </div>

                        <!-- Payment Arrow Text (Left) -->
                        <div class="absolute top-[30%] left-[7%] w-[20%] -rotate-60 text-center font-bold text-gray-800 text-[clamp(8px,1.4vw,11px)] leading-tight">
                            <?php echo nl2br(esc_html($dt['payment'])); ?>
                        </div>

                        <!-- Funding Arrow Text (Right) -->
                        <div class="absolute top-[30%] left-[73%] w-[20%] rotate-62 text-center font-bold text-gray-800 text-[clamp(8px,1.4vw,11px)] leading-tight">
                            <?php echo nl2br(esc_html($dt['funding'])); ?>
                        </div>

                        <!-- Process (Bottom) -->
                        <div class="absolute bottom-[20%] left-1/2 -translate-x-1/2 w-[60%] text-center font-bold text-gray-800 text-[clamp(8px,1.4vw,10px)] leading-relaxed">
                            <?php foreach ($dt['process'] as $item) : ?>
                                <div><?php echo esc_html($item); ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Content -->
            <div class="lg:col-span-6 transform transition-all duration-1000 delay-200"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-10'">
                <div class="mb-10">
                    <h3 class="text-[#FFD700] font-black text-sm uppercase tracking-[0.5em] font-heading mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M13 2 L3 14 L12 14 L11 22 L21 10 L12 10 Z"/></svg>
                        <?php echo esc_html($data['subtitle']); ?>
                    </h3>
                    <h2 class="text-3xl lg:text-5xl font-black text-white leading-tight font-heading mb-6">
                        <?php echo esc_html($data['title']); ?>
                    </h2>
                    <p class="text-gray-300 text-lg leading-relaxed mb-10 font-light border-l-4 border-[#228B22] pl-4">
                        <?php echo esc_html($data['desc']); ?>
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 gap-x-6 gap-y-4">
                    <?php foreach ($data['benefits'] as $benefit) : ?>
                        <div class="flex items-start group">
                            <div class="mt-1 mr-3 w-5 h-5 rounded-full bg-[#228B22]/20 flex items-center justify-center shrink-0 group-hover:bg-[#228B22] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-[#228B22] group-hover:text-white"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <span class="text-gray-200 font-medium group-hover:text-white transition-colors text-sm lg:text-base">
                                <?php echo esc_html($benefit); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-12 pt-8 border-t border-white/10">
                    <a href="<?php echo esc_url(wataco_get_contact_page_url()); ?>" class="bg-[#228B22] hover:bg-[#FFD700] hover:text-[#1A2B3C] text-white px-8 py-4 rounded-md font-black uppercase tracking-widest text-xs transition-all shadow-lg shadow-[#228B22]/20 inline-block active:scale-95">
                        <?php echo esc_html($data['button']); ?>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
