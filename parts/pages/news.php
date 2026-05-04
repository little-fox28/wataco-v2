<?php
/**
 * News page content assembly.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

$pll = function_exists('pll__');
$lang = function_exists('pll_current_language') ? (string) pll_current_language('slug') : '';

$t_hero_badge         = $pll ? pll__('Featured News') : 'Featured News';
$t_read_more          = $pll ? pll__('Read More') : 'Read More';
$t_no_results         = $pll ? pll__('No results found.') : 'No results found.';
$t_clear_filter       = $pll ? pll__('Clear filter') : 'Clear filter';
$t_load_more          = $pll ? pll__('Load More') : 'Load More';
$t_search_placeholder = $pll ? pll__('Search news...') : 'Search news...';
$t_trending_title     = $pll ? pll__('Most Read') : 'Most Read';
$t_tags_title         = $pll ? pll__('Hot Topics') : 'Hot Topics';
$t_category_all       = $pll ? pll__('All News') : 'All News';
$t_category_project   = $pll ? pll__('Partnerships & Projects') : 'Partnerships & Projects';

$date_format     = in_array($lang, array('en', 'ja'), true) ? 'Y/m/d' : 'd/m/Y';
$trending_format = in_array($lang, array('en', 'ja'), true) ? 'Y/m' : 'd/m';

$news_term_candidates = array(
    'news',
    'tin-tuc',
    'news-en',
    'news-ja',
    'tin-tuc-vi',
);
$news_term = null;
foreach ($news_term_candidates as $candidate_slug) {
    $candidate_term = get_term_by('slug', $candidate_slug, 'category');
    if ($candidate_term instanceof WP_Term) {
        $news_term = $candidate_term;
        break;
    }
}

if ($news_term instanceof WP_Term && function_exists('pll_get_term')) {
    $translated_term_id = (int) pll_get_term((int) $news_term->term_id, $lang);
    if ($translated_term_id > 0) {
        $translated_term = get_term($translated_term_id, 'category');
        if ($translated_term instanceof WP_Term) {
            $news_term = $translated_term;
        }
    }
}

$query_args = array(
    'post_type'           => 'post',
    'posts_per_page'      => -1,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'orderby'             => 'date',
    'order'               => 'DESC',
    'no_found_rows'       => true,
    'meta_query'          => array(
        array(
            'key'     => '_wataco_news_source_id',
            'compare' => 'EXISTS',
        ),
    ),
);

if ($news_term instanceof WP_Term) {
    // Use exact term match; avoid pulling child categories (e.g. Careers under News tree).
    $query_args['category__in'] = array((int) $news_term->term_id);
}

$news_query = new WP_Query($query_args);

// Fallback for legacy/manual news posts if imported-source meta is not available.
if (!$news_query->have_posts()) {
    unset($query_args['meta_query']);
    $news_query = new WP_Query($query_args);
}

$news_items = array();
$category_counts = array();
$category_labels = array();
$all_tags = array();

if ($news_query->have_posts()) {
    while ($news_query->have_posts()) {
        $news_query->the_post();
        $post_id = get_the_ID();

        $post_categories = get_the_terms($post_id, 'category');
        if (is_wp_error($post_categories) || !is_array($post_categories)) {
            $post_categories = array();
        }

        $primary_category = null;
        if (!empty($post_categories)) {
            if ($news_term instanceof WP_Term) {
                foreach ($post_categories as $cat) {
                    if ((int) $cat->parent === (int) $news_term->term_id) {
                        $primary_category = $cat;
                        break;
                    }
                }
            }

            if (!$primary_category instanceof WP_Term) {
                $primary_category = $post_categories[0];
            }
        }

        $category_slug = $primary_category instanceof WP_Term ? sanitize_title((string) $primary_category->slug) : 'project';
        $category_name = $primary_category instanceof WP_Term ? html_entity_decode((string) $primary_category->name, ENT_QUOTES, 'UTF-8') : $t_category_project;

        if (!isset($category_counts[$category_slug])) {
            $category_counts[$category_slug] = 0;
            $category_labels[$category_slug] = $category_name;
        }
        $category_counts[$category_slug]++;

        $excerpt = get_the_excerpt();
        if ($excerpt === '') {
            $excerpt = wp_strip_all_tags(get_the_content());
        }
        $excerpt = wp_trim_words($excerpt, 28, '...');

        $views = (int) get_post_meta($post_id, 'views', true);
        if ($views <= 0) {
            $views = (int) get_post_meta($post_id, 'post_views_count', true);
        }

        $tags = wp_get_post_terms($post_id, 'post_tag', array('fields' => 'names'));
        if (!is_wp_error($tags) && is_array($tags)) {
            foreach ($tags as $tag_name) {
                if (!is_string($tag_name) || $tag_name === '') {
                    continue;
                }
                $all_tags[sanitize_title($tag_name)] = html_entity_decode($tag_name, ENT_QUOTES, 'UTF-8');
            }
        }

        $news_items[] = array(
            'id'            => $post_id,
            'title'         => html_entity_decode(get_the_title($post_id), ENT_QUOTES, 'UTF-8'),
            'summary'       => html_entity_decode($excerpt, ENT_QUOTES, 'UTF-8'),
            'category'      => $category_name,
            'category_slug' => $category_slug,
            'date'          => get_the_date($date_format, $post_id),
            'trending_date' => get_the_date($trending_format, $post_id),
            'views'         => $views,
            'image'         => wataco_get_news_image($post_id),
            'permalink'     => get_permalink($post_id),
        );
    }
    wp_reset_postdata();
}

$categories = array(
    array(
        'id'    => 'all',
        'label' => $t_category_all,
        'count' => count($news_items),
    ),
);
foreach ($category_counts as $category_slug => $count) {
    $categories[] = array(
        'id'    => $category_slug,
        'label' => isset($category_labels[$category_slug]) ? $category_labels[$category_slug] : $t_category_project,
        'count' => $count,
    );
}

$hero_slides = array_slice($news_items, 0, 3);
$trending_news = array_slice($news_items, 0, 3);
$tags_cloud = array_slice(array_values($all_tags), 0, 14);

if (empty($tags_cloud)) {
    $tags_cloud = array(
        'Solar Farm',
        'Rooftop Solar',
        'Inverter',
        'Energy Storage',
        'EPC',
        'ESCO',
        'Net Zero',
    );
}

$news_items_json = htmlspecialchars(wp_json_encode($news_items), ENT_QUOTES, 'UTF-8');
$categories_json = htmlspecialchars(wp_json_encode($categories), ENT_QUOTES, 'UTF-8');
$hero_slides_json = htmlspecialchars(wp_json_encode($hero_slides), ENT_QUOTES, 'UTF-8');
$trending_news_json = htmlspecialchars(wp_json_encode($trending_news), ENT_QUOTES, 'UTF-8');
$tags_cloud_json = htmlspecialchars(wp_json_encode($tags_cloud), ENT_QUOTES, 'UTF-8');
?>

<main
    class="min-h-screen bg-[#F8FAFC]"
    x-data="{
        activeCategory: 'all',
        searchQuery: '',
        visibleCount: 5,
        currentHero: 0,
        newsItems: <?php echo $news_items_json; ?>,
        categories: <?php echo $categories_json; ?>,
        heroSlides: <?php echo $hero_slides_json; ?>,
        trendingNews: <?php echo $trending_news_json; ?>,
        tagsCloud: <?php echo $tags_cloud_json; ?>,
        init() {
            if (this.heroSlides.length > 1) {
                setInterval(() => {
                    this.currentHero = (this.currentHero + 1) % this.heroSlides.length;
                }, 5000);
            }
        },
        get filteredNews() {
            return this.newsItems.filter((item) => {
                const matchCategory = this.activeCategory === 'all' || item.category_slug === this.activeCategory;
                const q = this.searchQuery.toLowerCase();
                const matchSearch = item.title.toLowerCase().includes(q) || item.summary.toLowerCase().includes(q);
                return matchCategory && matchSearch;
            });
        },
        get visibleNews() {
            return this.filteredNews.slice(0, this.visibleCount);
        },
        clearFilters() {
            this.activeCategory = 'all';
            this.searchQuery = '';
        },
        loadMore() {
            this.visibleCount += 3;
        }
    }"
>
    <section class="relative h-[26rem] lg:h-[38rem] overflow-hidden bg-[#040505] text-white" x-show="heroSlides.length > 0" style="display: none;">
        <template x-for="(slide, idx) in heroSlides" :key="slide.id">
            <div class="absolute inset-0 transition-opacity duration-700" :class="currentHero === idx ? 'opacity-100' : 'opacity-0 pointer-events-none'">
                <template x-if="slide.image">
                    <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover opacity-60" loading="lazy" />
                </template>
                <div class="absolute inset-0 bg-linear-to-t from-[#1A2B3C] via-transparent to-transparent opacity-90"></div>
            </div>
        </template>

        <div class="absolute bottom-0 left-0 w-full p-8 lg:p-16 z-10">
            <div class="max-w-360 mx-auto">
                <div class="max-w-3xl">
                    <span class="bg-[#228B22] text-white px-3 py-1 text-xs font-black uppercase tracking-widest rounded-sm mb-4 inline-block">
                        <?php echo esc_html($t_hero_badge); ?>
                    </span>
                    <a :href="heroSlides[currentHero] ? heroSlides[currentHero].permalink : '#'" class="no-underline">
                        <h1 class="text-3xl lg:text-5xl font-black font-heading leading-tight mb-4 hover:text-[#FFD700] transition-colors">
                            <span x-text="heroSlides[currentHero] ? heroSlides[currentHero].title : ''"></span>
                        </h1>
                    </a>
                    <p class="text-gray-300 text-lg line-clamp-2 mb-6 border-l-4 border-[#FFD700] pl-4">
                        <span x-text="heroSlides[currentHero] ? heroSlides[currentHero].summary : ''"></span>
                    </p>
                    <div class="flex items-center text-sm text-gray-300 font-mono">
                        <svg class="w-3.5 h-3.5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span x-text="heroSlides[currentHero] ? heroSlides[currentHero].date : ''"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-8 right-8 lg:right-16 flex space-x-2 z-20">
            <template x-for="(slide, idx) in heroSlides" :key="'dot-' + slide.id">
                <button type="button" @click="currentHero = idx" class="h-2 rounded-full transition-all" :class="currentHero === idx ? 'bg-[#FFD700] w-8' : 'bg-white/50 w-2'" :aria-label="'Slide ' + (idx + 1)"></button>
            </template>
        </div>
    </section>

    <section class="max-w-360 mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-8">
                <div class="flex overflow-x-auto no-scrollbar gap-2 mb-8 pb-2 border-b border-gray-200">
                    <template x-for="cat in categories" :key="cat.id">
                        <button
                            type="button"
                            @click="activeCategory = cat.id; visibleCount = 5"
                            class="px-5 py-2.5 rounded-t-lg text-xs font-bold uppercase tracking-wider transition-all whitespace-nowrap border-b-2"
                            :class="activeCategory === cat.id ? 'border-[#228B22] text-[#228B22] bg-white' : 'border-transparent text-gray-500 hover:text-[#1A2B3C]'"
                        >
                            <span x-text="cat.label"></span>
                            <span class="ml-1 text-[10px] opacity-60" x-text="'(' + cat.count + ')'"></span>
                        </button>
                    </template>
                </div>

                <div class="space-y-6">
                    <template x-if="visibleNews.length > 0">
                        <template x-for="item in visibleNews" :key="item.id">
                            <a :href="item.permalink" class="group bg-white rounded-lg border border-gray-100 p-4 hover:shadow-lg hover:border-[#228B22] transition-all duration-300 flex flex-col sm:flex-row gap-6 cursor-pointer no-underline">
                                <div class="sm:w-1/3 lg:w-1/4 h-48 sm:h-auto rounded-md overflow-hidden relative shrink-0 bg-gray-100">
                                    <template x-if="item.image">
                                        <img :src="item.image" :alt="item.title" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" loading="lazy" />
                                    </template>
                                    <div class="absolute top-2 left-2 bg-[#1A2B3C]/90 text-white text-[9px] font-bold px-2 py-1 uppercase rounded-sm" x-text="item.category"></div>
                                </div>

                                <div class="grow flex flex-col justify-center">
                                    <div class="flex items-center text-xs text-gray-400 mb-2 font-mono">
                                        <svg class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        <span x-text="item.date"></span>
                                        <template x-if="item.views > 0">
                                            <span class="inline-flex items-center">
                                                <span class="mx-2">•</span>
                                                <svg class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span x-text="item.views.toLocaleString()"></span>
                                            </span>
                                        </template>
                                    </div>
                                    <h2 class="text-xl font-bold text-[#1A2B3C] font-heading mb-3 group-hover:text-[#228B22] transition-colors leading-snug line-clamp-2" x-text="item.title"></h2>
                                    <p class="text-gray-500 text-sm line-clamp-2 mb-4 leading-relaxed" x-text="item.summary"></p>
                                    <div class="mt-auto flex items-center text-[#228B22] text-xs font-black uppercase tracking-wide">
                                        <?php echo esc_html($t_read_more); ?>
                                        <svg class="w-3.5 h-3.5 ml-1 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                    </div>
                                </div>
                            </a>
                        </template>
                    </template>

                    <div x-show="visibleNews.length === 0" class="text-center py-20 bg-white rounded-lg border border-gray-100 border-dashed" style="display: none;">
                        <p class="text-gray-400"><?php echo esc_html($t_no_results); ?></p>
                        <button type="button" @click="clearFilters()" class="text-[#228B22] font-bold mt-2 hover:underline"><?php echo esc_html($t_clear_filter); ?></button>
                    </div>
                </div>

                <div class="text-center mt-12" x-show="filteredNews.length > visibleCount" style="display: none;">
                    <button
                        type="button"
                        @click="loadMore()"
                        class="bg-white border border-[#1A2B3C] text-[#1A2B3C] px-8 py-3 rounded-md font-bold uppercase tracking-widest hover:bg-[#1A2B3C] hover:text-white transition-all shadow-sm active:scale-95"
                    >
                        <?php echo esc_html($t_load_more); ?>
                    </button>
                </div>
            </div>

            <aside class="lg:col-span-4 space-y-8" role="complementary">
                <div class="bg-white p-1 rounded-md border border-gray-200 shadow-sm flex items-center">
                    <input
                        type="text"
                        placeholder="<?php echo esc_attr($t_search_placeholder); ?>"
                        class="w-full pl-4 pr-2 py-2 bg-transparent text-sm focus:outline-none text-[#1A2B3C]"
                        x-model="searchQuery"
                    />
                    <button type="button" class="p-2 bg-[#228B22] text-white rounded-md hover:bg-[#1A2B3C] transition-colors" aria-label="<?php echo esc_attr($t_search_placeholder); ?>">
                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </div>

                <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-black text-[#1A2B3C] font-heading mb-6 flex items-center m-0">
                        <span class="w-1 h-6 bg-[#228B22] mr-3 rounded-full"></span>
                        <?php echo esc_html($t_trending_title); ?>
                    </h3>
                    <ul class="space-y-4 m-0 p-0 list-none">
                        <template x-for="(item, idx) in trendingNews" :key="item.id">
                            <li class="pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                                <a :href="item.permalink" class="group no-underline flex items-start gap-4">
                                    <span class="text-3xl font-black text-gray-200 group-hover:text-[#228B22] transition-colors leading-none -mt-1" x-text="'0' + (idx + 1)"></span>
                                    <span>
                                        <span class="block text-sm font-bold text-[#1A2B3C] group-hover:text-[#228B22] transition-colors line-clamp-2 mb-1" x-text="item.title"></span>
                                        <span class="text-xs text-gray-400 flex items-center">
                                            <svg class="w-2.5 h-2.5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            <span x-text="item.trending_date"></span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-black text-[#1A2B3C] font-heading mb-6 flex items-center m-0">
                        <span class="w-1 h-6 bg-[#228B22] mr-3 rounded-full"></span>
                        <?php echo esc_html($t_tags_title); ?>
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="(tag, index) in tagsCloud" :key="'tag-' + index">
                            <button type="button" @click="searchQuery = tag" class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full hover:bg-[#228B22] hover:text-white transition-colors cursor-pointer border border-gray-200">
                                <span x-text="'#' + tag"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</main>
