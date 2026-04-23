<?php
/**
 * About page culture gallery section.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$culture_fallbacks = function_exists('wataco_get_about_culture_fallbacks')
    ? wataco_get_about_culture_fallbacks()
    : array(
        'subtitle'    => function_exists('pll__') ? pll__('Working Environment') : 'Working Environment',
        'title'       => function_exists('pll__') ? pll__('Life Rhythm At WATACO') : 'Life Rhythm At WATACO',
        'description' => function_exists('pll__') ? pll__('Everyday moments, field trips, and smiles on-site are the most positive source of energy for us.') : 'Everyday moments, field trips, and smiles on-site are the most positive source of energy for us.',
    );

$culture_subtitle_raw = function_exists('get_field') ? get_field('culture_subtitle') : '';
$culture_title_raw = function_exists('get_field') ? get_field('culture_title') : '';
$culture_description_raw = function_exists('get_field') ? get_field('culture_description') : '';

$culture_subtitle = (is_string($culture_subtitle_raw) && '' !== trim($culture_subtitle_raw))
    ? trim($culture_subtitle_raw)
    : $culture_fallbacks['subtitle'];
$culture_title = (is_string($culture_title_raw) && '' !== trim($culture_title_raw))
    ? trim($culture_title_raw)
    : $culture_fallbacks['title'];
$culture_description = (is_string($culture_description_raw) && '' !== trim($culture_description_raw))
    ? trim($culture_description_raw)
    : $culture_fallbacks['description'];

$culture_items = function_exists('wataco_get_about_culture_items') ? wataco_get_about_culture_items() : array();
$culture_items = apply_filters('wataco_about_culture_template_items', $culture_items);
?>

<?php do_action('wataco_before_about_culture_section', $culture_items); ?>
<section class="py-20 lg:py-32 bg-white border-b border-gray-100 overflow-hidden">
    <div class="max-w-[1440px] mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8" data-about-stagger-container>
            <div data-about-stagger-item>
                <h3 class="text-[#228B22] font-black text-sm uppercase tracking-[0.5em] font-heading mb-3">
                    <?php echo esc_html($culture_subtitle); ?>
                </h3>
                <h2 class="text-3xl lg:text-5xl font-black text-[#1A2B3C] leading-tight font-heading">
                    <?php echo esc_html($culture_title); ?>
                </h2>
            </div>
            <p class="text-gray-500 max-w-md font-light" data-about-stagger-item>
                <?php echo esc_html($culture_description); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 auto-rows-[250px] gap-4 lg:gap-6" data-about-stagger-container>
            <?php foreach ($culture_items as $culture_item) : ?>
                <article class="relative rounded-2xl overflow-hidden group cursor-pointer focus-within:ring-2 focus-within:ring-[#FFD700] <?php echo esc_attr((string) ($culture_item['span'] ?? 'md:col-span-1 md:row-span-1')); ?>" data-about-stagger-item>
                    <img
                        src="<?php echo esc_url((string) ($culture_item['img'] ?? '')); ?>"
                        alt="<?php echo esc_attr((string) ($culture_item['title'] ?? '')); ?>"
                        class="w-full h-full object-cover transform group-hover:scale-105 group-focus-within:scale-105 transition-transform duration-700"
                        loading="lazy" />
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1A2B3C]/90 via-[#1A2B3C]/20 to-transparent flex flex-col justify-end p-6 md:p-8">
                        <div class="transform translate-y-2 group-hover:translate-y-0 group-focus-within:translate-y-0 transition-transform duration-300">
                            <span class="text-[#FFD700] text-[10px] font-black uppercase tracking-widest mb-2 block drop-shadow-md">
                                <?php echo esc_html((string) ($culture_item['category'] ?? '')); ?>
                            </span>
                            <h4 class="text-white text-xl lg:text-2xl font-bold font-heading drop-shadow-lg">
                                <?php echo esc_html((string) ($culture_item['title'] ?? '')); ?>
                            </h4>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php do_action('wataco_after_about_culture_section', $culture_items); ?>
