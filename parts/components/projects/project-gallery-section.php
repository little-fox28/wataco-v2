<?php
/**
 * Projects page — Filterable gallery section.
 *
 * Server-renders all project cards. Alpine.js handles:
 *   - Category filtering via x-show
 *   - Infinite scroll via x-intersect sentinel
 *   - "Showing X of Y" counter
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

// ─── Query all project posts (Polylang auto-filters by language) ───
$projects_cat = get_term_by('slug', 'projects', 'category');
$projects_cat_id = $projects_cat ? $projects_cat->term_id : 0;

$projects_query = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'cat'            => $projects_cat_id,
));

// ─── Build project data array for Alpine JSON + PHP card rendering ───
$projects = array();
if ($projects_query->have_posts()) {
    while ($projects_query->have_posts()) {
        $projects_query->the_post();
        $post_id = get_the_ID();

        // Determine category: Use slug-based matching (vietnam/international) for Alpine
        $post_categories = wp_get_post_terms($post_id, 'category');
        $category_slug = 'vietnam'; // Default
        foreach ($post_categories as $cat) {
            if (strpos($cat->slug, 'international') !== false) {
                $category_slug = 'international';
                break;
            }
            if (strpos($cat->slug, 'vietnam') !== false) {
                $category_slug = 'vietnam';
            }
        }

        // Resolve image: ACF Image field -> ACF Path -> Featured Image
        $img_array = get_field('project_img', $post_id);
        $img_path  = get_post_meta($post_id, 'project_img_path', true);
        $img_url   = '';

        if (!empty($img_array) && isset($img_array['url'])) {
            $img_url = $img_array['url'];
        } elseif (!empty($img_path)) {
            // Fallback to legacy path-based logic
            if (strpos($img_path, 'http') !== 0) {
                $img_url = esc_url(get_template_directory_uri() . '/assets/images/' . ltrim($img_path, '/'));
            } else {
                $img_url = esc_url($img_path);
            }
        } elseif (has_post_thumbnail($post_id)) {
            $img_url = get_the_post_thumbnail_url($post_id, 'large');
        }

        $projects[] = array(
            'id'            => $post_id,
            'title'         => get_the_title(),
            'permalink'     => get_permalink(),
            'category'      => $category_slug,
            'location'      => get_post_meta($post_id, 'project_location', true),
            'capacity'      => get_post_meta($post_id, 'project_capacity', true),
            'year'          => get_post_meta($post_id, 'project_year', true),
            'status'        => get_post_meta($post_id, 'project_status', true),
            'img'           => $img_url,
        );
    }
    wp_reset_postdata();
}

// Sort: "In Progress" projects first (ACF Select stores consistent English value)
usort($projects, function ($a, $b) {
    $a_ip = ($a['status'] === 'In Progress');
    $b_ip = ($b['status'] === 'In Progress');
    if ($a_ip === $b_ip) return 0;
    return $a_ip ? -1 : 1;
});

// ─── Translatable strings ───
$library_title     = pll__('Project Library');
$cat_vietnam       = pll__('Vietnam');
$cat_international = pll__('International');
$cat_all           = pll__('All Projects');
$no_projects       = pll__('No projects found.');
$showing_tpl       = pll__('Showing {current} of {total} projects');

// ─── Category tab config ───
$categories = array(
    array('id' => 'vietnam',       'label' => $cat_vietnam,       'has_icon' => true,  'icon' => 'factory'),
    array('id' => 'international', 'label' => $cat_international, 'has_icon' => true,  'icon' => 'building'),
    array('id' => 'all',           'label' => $cat_all,           'has_icon' => false,  'icon' => ''),
);

// ─── Precompute per-category counts for Alpine ───
$count_vietnam       = count(array_filter($projects, function ($p) { return $p['category'] === 'vietnam'; }));
$count_international = count(array_filter($projects, function ($p) { return $p['category'] === 'international'; }));
$count_all           = count($projects);
?>

<section class="py-20" id="project-grid-anchor">
    <div class="max-w-[1440px] mx-auto px-6"
         x-data="{
            activeCategory: 'vietnam',
            visibleCount: 6,
            counts: {
                vietnam: <?php echo esc_attr($count_vietnam); ?>,
                international: <?php echo esc_attr($count_international); ?>,
                all: <?php echo esc_attr($count_all); ?>
            },
            get totalFiltered() {
                return this.counts[this.activeCategory];
            },
            get currentVisible() {
                return Math.min(this.visibleCount, this.totalFiltered);
            },
            switchCategory(cat) {
                this.activeCategory = cat;
                this.visibleCount = 6;
            },
            loadMore() {
                this.visibleCount = Math.min(this.visibleCount + 3, this.totalFiltered);
            }
         }">

        <!-- Header: Title + Filter Tabs -->
        <div x-data="{ shown: false }"
             x-intersect.once="shown = true"
             class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 transition-all duration-700 ease-out"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">

            <h2 class="text-2xl font-black text-[#1A2B3C] uppercase tracking-tight font-heading">
                <?php echo esc_html($library_title); ?>
            </h2>

            <div class="flex flex-wrap justify-center gap-2">
                <?php foreach ($categories as $cat) : ?>
                    <button @click="switchCategory('<?php echo esc_attr($cat['id']); ?>')"
                            class="px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider flex items-center border transition-all duration-200"
                            :class="activeCategory === '<?php echo esc_attr($cat['id']); ?>'
                                ? 'bg-[#1A2B3C] text-white border-[#1A2B3C] shadow-md'
                                : 'bg-white text-gray-500 border-gray-200 hover:border-[#228B22] hover:text-[#228B22]'">
                        <?php if ($cat['icon'] === 'factory') : ?>
                            <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <?php elseif ($cat['icon'] === 'building') : ?>
                            <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0V10a1 1 0 011-1h2a1 1 0 011 1v11"></path></svg>
                        <?php endif; ?>
                        <?php echo esc_html($cat['label']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Project Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $card_index = 0;
            foreach ($projects as $project) :
                // Set variables for the card partial
                $project_index         = $card_index;
                $project_title         = $project['title'];
                $project_location      = $project['location'];
                $project_capacity      = $project['capacity'];
                $project_year          = $project['year'];
                $project_status        = $project['status'];
                $project_img_path      = $project['img'];
                $project_permalink     = $project['permalink'];
                $project_category_slug = $project['category'];

                include get_template_directory() . '/parts/components/projects/project-card.php';
                $card_index++;
            endforeach;
            ?>
        </div>

        <!-- Empty State -->
        <template x-if="totalFiltered === 0">
            <div class="text-center py-20 bg-white rounded-lg border border-gray-100 mt-8">
                <p class="text-gray-400"><?php echo esc_html($no_projects); ?></p>
            </div>
        </template>

        <!-- Sentinel for Infinite Scroll -->
        <div x-intersect.margin.300px="loadMore()" class="h-6"></div>

        <!-- Counter -->
        <div class="text-center mt-6 space-y-2">
            <p class="text-xs text-gray-400 font-medium"
               x-text="'<?php echo esc_js($showing_tpl); ?>'.replace('{current}', currentVisible).replace('{total}', totalFiltered)">
            </p>
        </div>
    </div>
</section>
