<?php
/**
 * Main template file for displaying posts.
 *
 * @package TailPress
 */

get_header();
?>

<?php
$news_archive_slugs = array('news', 'tin-tuc', 'tin-tuc-vi', 'news-en', 'news-ja', 'ニュース');
$is_news_archive = is_home();

if (!$is_news_archive && is_category()) {
	$queried_term = get_queried_object();
	if ($queried_term instanceof WP_Term) {
		$term_slug = (string) $queried_term->slug;
		if (in_array($term_slug, $news_archive_slugs, true) || in_array(sanitize_title($term_slug), $news_archive_slugs, true)) {
			$is_news_archive = true;
		}
	}
}
?>

<?php if ($is_news_archive): ?>
	<?php get_template_part('parts/pages/news'); ?>
<?php else: ?>
<div class="container mx-auto space-y-24 lg:space-y-32">
	<?php if (!is_singular()): ?>
		<?php if (is_archive()): ?>
			<header class="mb-8">
				<h1 class="text-3xl font-semibold">
					<?php the_archive_title(); ?>
				</h1>
			</header>
		<?php elseif (is_category()): ?>
			<header class="mb-8">
				<h1 class="text-3xl font-semibold">
					<?php single_cat_title(); ?>
				</h1>
			</header>
		<?php elseif (is_tag()): ?>
			<header class="mb-8">
				<h1 class="text-3xl font-semibold">
					<?php single_tag_title(); ?>
				</h1>
			</header>
		<?php elseif (is_author()): ?>
			<header class="mb-8">
				<h1 class="text-3xl font-semibold">
					<?php printf(__('Posts by %s', 'tailpress'), get_the_author()); ?>
				</h1>
			</header>
		<?php elseif (is_day()): ?>
			<header class="mb-8">
				<h1 class="text-3xl font-semibold">
					<?php printf(__('Daily Archives: %s', 'tailpress'), get_the_date()); ?>
				</h1>
			</header>
		<?php elseif (is_month()): ?>
			<header class="mb-8">
				<h1 class="text-3xl font-semibold">
					<?php printf(__('Monthly Archives: %s', 'tailpress'), get_the_date('F Y')); ?>
				</h1>
			</header>
		<?php elseif (is_year()): ?>
			<header class="mb-8">
				<h1 class="text-3xl font-semibold">
					<?php printf(__('Yearly Archives: %s', 'tailpress'), get_the_date('Y')); ?>
				</h1>
			</header>
		<?php elseif (is_search()): ?>
			<header class="mb-8">
				<h1 class="text-3xl font-semibold">
					<?php printf(__('Search results for: %s', 'tailpress'), get_search_query()); ?>
				</h1>
			</header>
		<?php elseif (is_404()): ?>
			<header class="mb-8">
				<h1 class="text-3xl font-semibold">
					<?php _e('Page Not Found', 'tailpress'); ?>
				</h1>
			</header>
		<?php endif; ?>
	<?php endif; ?>

    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
            <?php get_template_part('template-parts/content', is_singular() ? 'single' : ''); ?>
        <?php endwhile; ?>

        <?php TailPress\Pagination::render(); ?>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php
get_footer();
