<?php
if (!defined('ABSPATH')) {
    exit;
}

$pll = function_exists('pll__');

$title = $pll ? pll__('Open Positions') : 'Open Positions';
$desc = $pll ? pll__('Find the right opportunity for you.') : 'Find the right opportunity for you.';
$searchPlaceholder = $pll ? pll__('Search for jobs...') : 'Search for jobs...';
$noResults = $pll ? pll__('No suitable positions found.') : 'No suitable positions found.';
$viewAll = $pll ? pll__('View all jobs') : 'View all jobs';

// Query jobs
$base_cat_id = 1;
$translated_cat_id = $base_cat_id;
if ( function_exists('pll_get_term') ) {
    $maybe_translated_cat_id = pll_get_term( $base_cat_id, pll_current_language() );
    if ( !empty($maybe_translated_cat_id) ) {
        $translated_cat_id = $maybe_translated_cat_id;
    }
}

// Pre-fetch all child categories (departments), including empty ones.
$departments = [];
$department_terms = get_terms([
    'taxonomy'   => 'category',
    'parent'     => (int) $translated_cat_id,
    'hide_empty' => false,
]);
if ( !is_wp_error($department_terms) && !empty($department_terms) ) {
    foreach ( $department_terms as $term ) {
        $departments[] = [
            'slug' => $term->slug,
            'name' => html_entity_decode($term->name, ENT_QUOTES, 'UTF-8'),
        ];
    }
}

$jobs_query = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'no_found_rows'  => true,
    'cat'            => $translated_cat_id,
));


// Filter jobs
$jobs = [];
if ($jobs_query->have_posts()) {
    while ($jobs_query->have_posts()) {
        $jobs_query->the_post();
        $post_id = get_the_ID();
        $job_title = html_entity_decode(get_the_title($post_id), ENT_QUOTES, 'UTF-8');
        $raw_deadline = get_field('job_deadline', $post_id);
        $formatted_deadline = '';
        if ($raw_deadline) {
            $date_obj = DateTime::createFromFormat('Ymd', $raw_deadline);
            $formatted_deadline = $date_obj ? $date_obj->format('d/m/Y') : $raw_deadline;
        }

        $job_department = '';
        $job_department_slug = '';

        $categories = get_the_terms($post_id, 'category');
        if ( $categories && !is_wp_error($categories) ) {
            foreach ( $categories as $cat ) {
                if ( (int) $cat->parent === (int) $translated_cat_id ) {
                    $job_department = html_entity_decode($cat->name, ENT_QUOTES, 'UTF-8');
                    $job_department_slug = $cat->slug;
                    break;
                }
            }
        }

        $jobs[] = [
            'id'         => $post_id,
            'title'      => $job_title,
            'permalink'  => get_permalink(),
            'urgent'     => get_field('job_is_urgent', $post_id),
            'department_slug' => $job_department_slug,
            'department' => $job_department,
            'location'   => get_field('job_location', $post_id) ?: '',
            'type'       => get_field('job_type', $post_id) ?: '',
            'deadline'   => $formatted_deadline,
            'salary'     => get_field('job_salary', $post_id) ?: '',
        ];
    }
    wp_reset_postdata();
}

$all_depts_label = $pll ? pll__('All') : 'All';
?>

<section id="jobs" class="py-20 bg-[#F8FAFC] border-t border-gray-100">
    <div class="max-w-360 mx-auto px-6"
         x-data="{
             activeCategory: 'all',
             searchQuery: '',
             jobs: <?php echo htmlspecialchars(json_encode($jobs), ENT_QUOTES, 'UTF-8'); ?>,
             get filteredJobs() {
                  return this.jobs.filter(job => {
                      const matchCat = this.activeCategory === 'all' || job.department_slug === this.activeCategory;
                      const matchSearch = job.title.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                          (job.location && job.location.toLowerCase().includes(this.searchQuery.toLowerCase()));
                      return matchCat && matchSearch;
                 });
             }
         }">

        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-12 gap-6">
            <div>
                <h2 class="text-3xl font-black text-[#1A2B3C] font-heading mb-2"><?php echo esc_html($title); ?></h2>
                <p class="text-gray-500 text-sm"><?php echo esc_html($desc); ?></p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                <!-- Search -->
                <div class="relative">
                    <input
                        type="text"
                        placeholder="<?php echo esc_attr($searchPlaceholder); ?>"
                        class="pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 focus:outline-none focus:border-[#228B22] w-full sm:w-64 text-sm"
                        x-model="searchQuery"
                    />
                    <svg class="w-4.5 h-[18px] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>

                <!-- Filter Buttons -->
                <div class="flex overflow-x-auto no-scrollbar gap-2">
                    <button
                        @click="activeCategory = 'all'"
                        class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider whitespace-nowrap border transition-all"
                        :class="activeCategory === 'all'
                            ? 'bg-[#1A2B3C] text-white border-[#1A2B3C]'
                            : 'bg-white text-gray-500 border-gray-200 hover:border-[#228B22]'"
                    >
                        <?php echo esc_html($all_depts_label); ?>
                    </button>
                    <?php foreach ($departments as $dept) : ?>
                        <button
                            @click="activeCategory = '<?php echo esc_js($dept['slug']); ?>'"
                            class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider whitespace-nowrap border transition-all"
                            :class="activeCategory === '<?php echo esc_js($dept['slug']); ?>'
                                ? 'bg-[#1A2B3C] text-white border-[#1A2B3C]'
                                : 'bg-white text-gray-500 border-gray-200 hover:border-[#228B22]'"
                        >
                            <?php echo esc_html($dept['name']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="(job, index) in filteredJobs" :key="job.id">
                <?php get_template_part('parts/components/careers/job-card'); ?>
            </template>
        </div>

        <div x-show="filteredJobs.length === 0" class="text-center py-16 bg-white rounded-lg border border-dashed border-gray-300 mt-8" style="display: none;">
            <p class="text-gray-500 mb-4"><?php echo esc_html($noResults); ?></p>
            <button @click="activeCategory = 'all'; searchQuery = '';" class="text-[#228B22] font-bold underline"><?php echo esc_html($viewAll); ?></button>
        </div>

    </div>
</section>
