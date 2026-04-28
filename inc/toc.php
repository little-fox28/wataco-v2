<?php
/**
 * Table of Contents Engine
 *
 * Auto-parses headings, injects anchor IDs, and builds a hierarchical array
 * for the TOC widget.
 * 
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

// Global variable to store the TOC items for the current post
global $wataco_toc_items;

/**
 * Filter the content to inject IDs into headings and build the TOC array.
 */
function wataco_parse_content_for_toc($content) {
    if (!is_singular('post')) {
        return $content;
    }

    global $wataco_toc_items;
    $wataco_toc_items = array();

    // Regex to match h2 and h3 tags
    $pattern = '/<h([2-3])([^>]*)>(.*?)<\/h\1>/is';

    $content = preg_replace_callback($pattern, function($matches) {
        global $wataco_toc_items;

        $level = intval($matches[1]);
        $attributes = $matches[2];
        $inner_text = $matches[3];

        $clean_text = wp_strip_all_tags($inner_text);
        if (empty(trim($clean_text))) {
            return $matches[0];
        }

        // Check if ID already exists in attributes
        $id = '';
        if (preg_match('/id=["\']([^"\']+)["\']/i', $attributes, $id_match)) {
            $id = $id_match[1];
        }

        if (empty($id)) {
            // Generate a clean, URL-safe ID
            $id = sanitize_title($clean_text);

            // Ensure uniqueness
            $original_id = $id;
            $counter = 1;
            $existing_ids = array_column($wataco_toc_items, 'id');
            while (in_array($id, $existing_ids)) {
                $id = $original_id . '-' . $counter;
                $counter++;
            }

            $attributes .= ' id="' . esc_attr($id) . '"';
        }

        // Add to TOC array
        $wataco_toc_items[] = array(
            'id'    => $id,
            'label' => $clean_text,
            'level' => $level,
        );

        return sprintf('<h%d%s>%s</h%d>', $level, $attributes, $inner_text, $level);
    }, $content);

    return $content;
}
add_filter('the_content', 'wataco_parse_content_for_toc', 10);
