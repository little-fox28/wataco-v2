<?php
if (!defined('ABSPATH')) {
    exit;
}

$pll = function_exists('pll__');

$subtitle = $pll ? pll__('Core Values') : 'Core Values';
$title = $pll ? pll__('WATACO Culture') : 'WATACO Culture';
$desc = $pll ? pll__('The collective strength and sustainable development orientation of WATACO are built on 5 inseparable cultural pillars.') : 'The collective strength and sustainable development orientation of WATACO are built on 5 inseparable cultural pillars.';

$cultureValues = [
    [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 12 2 2 4-4"></path></svg>',
        'title' => $pll ? pll__('Honesty and Transparency') : 'Honesty and Transparency',
        'desc' => $pll ? pll__('We always uphold ethical values in our work, demonstrating clarity, integrity, and a commitment to following the principles, thereby building solid trust with customers and partners.') : 'We always uphold ethical values in our work, demonstrating clarity, integrity, and a commitment to following the principles, thereby building solid trust with customers and partners.',
    ],
    [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06 0l3.72 3.72a3.6 3.6 0 0 1-5.09 5.09l-3-3"></path><path d="m8 14 2 2"></path><path d="m7 21 3-3"></path><path d="m3 3 3 3"></path><path d="m21 21-3-3"></path></svg>',
        'title' => $pll ? pll__('Cooperation') : 'Cooperation',
        'desc' => $pll ? pll__('The spirit of cooperation and teamwork is the foundation of Wataco; we always aim to create a cohesive environment that helps everyone promote their strengths and achieve common success.') : 'The spirit of cooperation and teamwork is the foundation of Wataco; we always aim to create a cohesive environment that helps everyone promote their strengths and achieve common success.',
    ],
    [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.9 1.3 1.5 1.5 2.5"></path><path d="M9 18h6"></path><path d="M10 22h4"></path></svg>',
        'title' => $pll ? pll__('Innovation') : 'Innovation',
        'desc' => $pll ? pll__('Every member of the company is encouraged to be creative and continuously improve, contributing new ideas to enhance the quality of work and solutions for customers.') : 'Every member of the company is encouraged to be creative and continuously improve, contributing new ideas to enhance the quality of work and solutions for customers.',
    ],
    [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>',
        'title' => $pll ? pll__('Care and Respect') : 'Care and Respect',
        'desc' => $pll ? pll__('At Wataco, every individual is valued and listened to; we always focus on personal development and protecting the interests of the community, customers, and partners.') : 'At Wataco, every individual is valued and listened to; we always focus on personal development and protecting the interests of the community, customers, and partners.',
    ],
    [
        'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline></svg>',
        'title' => $pll ? pll__('Proactively Overcoming Challenges') : 'Proactively Overcoming Challenges',
        'desc' => $pll ? pll__('Wataco employees are always proactive in seeking creative solutions to overcome all difficulties, constantly learning and developing to face challenges with confidence and efficiency.') : 'Wataco employees are always proactive in seeking creative solutions to overcome all difficulties, constantly learning and developing to face challenges with confidence and efficiency.',
    ],
];
?>

<section class="py-20 bg-[#F8FAFC] border-t border-gray-100 relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-[800px] h-[800px] bg-[#228B22]/5 rounded-full blur-[100px] pointer-events-none -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-[800px] h-[800px] bg-[#FFD700]/10 rounded-full blur-[100px] pointer-events-none translate-x-1/2 translate-y-1/2"></div>

    <div class="max-w-[1440px] mx-auto px-6 relative z-10">
        <div class="text-center mb-16" x-data="{ shown: false }" x-intersect.once="shown = true">
            <div class="transition-all duration-700 ease-out" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <h3 class="text-[#228B22] font-black text-sm uppercase tracking-[0.5em] font-heading mb-4"><?php echo esc_html($subtitle); ?></h3>
                <h2 class="text-3xl lg:text-5xl font-black text-[#1A2B3C] font-heading mb-4 uppercase"><?php echo esc_html($title); ?></h2>
                <p class="text-gray-500 max-w-2xl mx-auto"><?php echo esc_html($desc); ?></p>
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-8">
            <?php foreach ($cultureValues as $idx => $item) : ?>
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-[#228B22] transition-all duration-700 group w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.4rem)] flex flex-col items-center text-center ease-out"
                     x-data="{ shown: false }" x-intersect.once="shown = true"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     style="transition-delay: <?php echo esc_attr($idx * 100); ?>ms;">
                    <!-- Hexagon shaped icon container -->
                    <div class="w-24 h-24 mb-6 relative flex items-center justify-center">
                        <svg viewBox="0 0 100 100" class="absolute inset-0 w-full h-full text-[#F0FDF4] drop-shadow-sm group-hover:text-[#228B22] transition-colors duration-500">
                            <polygon fill="currentColor" points="50 3, 93 25, 93 75, 50 97, 7 75, 7 25" />
                        </svg>
                        <div class="relative z-10 w-9 h-9 text-[#228B22] group-hover:text-white transition-colors duration-500">
                            <?php echo $item['icon']; ?>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-[#1A2B3C] mb-4 group-hover:text-[#228B22] transition-colors leading-tight"><?php echo esc_html($item['title']); ?></h4>
                    <p class="text-sm text-gray-500 leading-relaxed font-light"><?php echo esc_html($item['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
