<?php
/**
 * Theme setup and core bootstrapping.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

if (is_file(__DIR__ . '/../vendor/autoload_packages.php')) {
    require_once __DIR__ . '/../vendor/autoload_packages.php';
}

function tailpress(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance()
        ->assets(fn($manager) => $manager
            ->withCompiler(new TailPress\Framework\Assets\ViteCompiler, fn($compiler) => $compiler
                ->registerAsset('resources/css/app.css')
                ->registerAsset('resources/js/app.js')
                ->editorStyleFile('resources/css/editor-style.css')
            )
            ->enqueueAssets()
        )
        ->features(fn($manager) => $manager->add(TailPress\Framework\Features\MenuOptions::class))
        ->menus(fn($manager) => $manager->add('primary', __('Primary Menu', 'tailpress')))
        ->themeSupport(fn($manager) => $manager->add([
            'title-tag',
            'custom-logo',
            'post-thumbnails',
            'align-wide',
            'wp-block-styles',
            'responsive-embeds',
            'html5' => [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        ]));
}

tailpress();

/**
 * Ensure Vite-compiled scripts are loaded as ES modules.
 * This resolves the "Cannot use import statement outside a module" error.
 */
add_filter('script_loader_tag', function($tag, $handle, $src) {
    if (strpos($handle, 'tailpress-') === 0 || 'vite-client' === $handle) {
        return '<script type="module" src="' . esc_url($src) . '" id="' . $handle . '-js"></script>';
    }
    return $tag;
}, 10, 3);

/**
 * Keep generated image sizes lean for constrained storage environments.
 *
 * @param array<string, array<string, int|string>> $sizes Generated intermediate sizes.
 * @return array<string, array<string, int|string>>
 */
function wataco_limit_intermediate_image_sizes($sizes) {
    $allowed_sizes = array(
        'thumbnail' => true,
        'medium'    => true,
        'large'     => true,
    );

    return array_intersect_key($sizes, $allowed_sizes);
}
add_filter('intermediate_image_sizes_advanced', 'wataco_limit_intermediate_image_sizes');
add_filter('big_image_size_threshold', '__return_false');

/**
 * Register Navigation Menus
 *
 * Registers custom menu locations for use in theme.
 */
function wataco_register_menus() {
    register_nav_menus(
        array(
            'primary_menu'          => __('Primary Navigation Menu', 'wataco'),
            'footer_menu'           => __('Footer Navigation Menu', 'wataco'),
            'footer_solutions_menu' => __('Footer Solutions Menu', 'wataco'),
            'footer_about_menu'     => __('Footer About Menu', 'wataco'),
        )
    );
}
add_action('after_setup_theme', 'wataco_register_menus');
