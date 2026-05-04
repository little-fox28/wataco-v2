<?php
/**
 * About page culture gallery section.
 * Uses WordPress Native get_post_meta() for ACF Free data retrieval.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define i18n fallback values
$fallback_subtitle = __('Working Environment', 'wataco');
$fallback_title = __('Life Rhythm At WATACO', 'wataco');
$fallback_description = __('Everyday moments, field trips, and smiles on-site are the most positive source of energy for us.', 'wataco');

// Retrieve culture section header data using WordPress Native function
$culture_subtitle_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), 'culture_subtitle', true) : '';
$culture_subtitle = (is_string($culture_subtitle_raw) && '' !== trim($culture_subtitle_raw))
    ? trim($culture_subtitle_raw)
    : $fallback_subtitle;

$culture_title_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), 'culture_title', true) : '';
$culture_title = (is_string($culture_title_raw) && '' !== trim($culture_title_raw))
    ? trim($culture_title_raw)
    : $fallback_title;

$culture_description_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), 'culture_description', true) : '';
$culture_description = (is_string($culture_description_raw) && '' !== trim($culture_description_raw))
    ? trim($culture_description_raw)
    : $fallback_description;

// Collect gallery items from incremental fields (ACF Free compatible)
$culture_items = array();
for ($i = 1; $i <= 6; $i++) {
    $item_title_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), "culture_item_${i}_title", true) : '';
    $item_category_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), "culture_item_${i}_category", true) : '';
    $item_image_id_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), "culture_item_${i}_image", true) : '';
    $item_span_raw = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), "culture_item_${i}_span", true) : '';

    $item_title = (is_string($item_title_raw) && '' !== trim($item_title_raw)) ? trim($item_title_raw) : '';
    $item_category = (is_string($item_category_raw) && '' !== trim($item_category_raw)) ? trim($item_category_raw) : '';
    $item_image_id = (!empty($item_image_id_raw) && is_numeric($item_image_id_raw)) ? intval($item_image_id_raw) : 0;
    $item_span = (is_string($item_span_raw) && '' !== trim($item_span_raw)) ? trim($item_span_raw) : 'md:col-span-1 md:row-span-1';

    // Only add item if at least title or image exists
    if (!empty($item_title) || !empty($item_image_id)) {
        $culture_items[] = array(
            'id'       => $i,
            'title'    => $item_title,
            'category' => $item_category,
            'image_id' => $item_image_id,
            'span'     => $item_span,
        );
    }
}

$culture_items = apply_filters('wataco_about_culture_template_items', $culture_items);
?>

<?php do_action('wataco_before_about_culture_section', $culture_items); ?>
<section class="py-20 lg:py-32 bg-white border-b border-gray-100 overflow-hidden">
    <div class="max-w-360 mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
            <div x-data="{ shown: false }"
                 x-intersect:enter="shown = true" x-intersect:leave="shown = false"
                 class="transition-all duration-700 ease-out"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <h3 class="text-[#228B22] font-black text-sm uppercase tracking-[0.5em] font-heading mb-3">
                    <?php echo esc_html($culture_subtitle); ?>
                </h3>
                <h2 class="text-3xl lg:text-5xl font-black text-[#1A2B3C] leading-tight font-heading">
                    <?php echo esc_html($culture_title); ?>
                </h2>
            </div>
            <p class="text-gray-500 max-w-md font-light transition-all duration-700 ease-out"
               x-data="{ shown: false }"
               x-intersect:enter="shown = true" x-intersect:leave="shown = false"
               :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
               style="transition-delay: 100ms;">
                <?php echo esc_html($culture_description); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 auto-rows-[250px] gap-4 lg:gap-6">
            <?php foreach ($culture_items as $i => $culture_item) : ?>
                <article
                    class="relative rounded-2xl overflow-hidden group cursor-pointer transition-all duration-700 ease-out <?php echo esc_attr((string) ($culture_item['span'] ?? 'md:col-span-1 md:row-span-1')); ?>"
                    x-data="{ shown: false }"
                    x-intersect:enter="shown = true" x-intersect:leave="shown = false"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                    style="transition-delay: <?php echo esc_attr((string) ($i * 100)); ?>ms;">
                    <?php
                    // Output image using WordPress Native function for CDN plugin interception
                    if (!empty($culture_item['image_id'])) {
                        echo wp_get_attachment_image(
                            $culture_item['image_id'],
                            'full',
                            false,
                            array(
                                'class' => 'w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700',
                                'alt'   => esc_attr((string) ($culture_item['title'] ?? '')),
                            )
                        );
                    } else {
                        echo '<div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">' . esc_html(__('No image', 'wataco')) . '</div>';
                    }
                    ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1A2B3C]/90 via-[#1A2B3C]/20 to-transparent flex flex-col justify-end p-6 md:p-8">
                        <div class="transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
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
