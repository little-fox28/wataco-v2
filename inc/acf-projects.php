<?php
/**
 * Register ACF Free Fields for Project Details.
 * 
 * Includes dynamic location rules for Polylang translated categories.
 * 
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

function wataco_register_project_details_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // Define the parent categories to check against (Master slugs)
    $parent_slugs = array('projects', 'projects-vn', 'projects-ja', 'du-an', 'projects-en');
    
    $location_rules = array();
    foreach ($parent_slugs as $slug) {
        $location_rules[] = array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'post',
            ),
            array(
                'param'    => 'post_category',
                'operator' => '==',
                'value'    => 'category:' . $slug,
            ),
        );
    }

    acf_add_local_field_group(array(
        'key' => 'group_project_details',
        'title' => 'Project Details',
        'fields' => array(
            array(
                'key' => 'field_project_location',
                'label' => 'Location',
                'name' => 'project_location',
                'type' => 'text',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_capacity',
                'label' => 'Capacity',
                'name' => 'project_capacity',
                'type' => 'text',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_production',
                'label' => 'Production',
                'name' => 'project_production',
                'type' => 'text',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_year',
                'label' => 'Year',
                'name' => 'project_year',
                'type' => 'number',
                'required' => 0,
            ),
            array(
                'key' => 'field_project_status',
                'label' => 'Status',
                'name' => 'project_status',
                'type' => 'select',
                'required' => 0,
                'choices' => array(
                    'Completed'   => 'Completed',
                    'In Progress' => 'In Progress',
                ),
                'default_value' => 'In Progress',
                'return_format' => 'value',
            ),
            array(
                'key' => 'field_project_img',
                'label' => 'Project Image',
                'name' => 'project_img',
                'type' => 'image',
                'instructions' => 'Upload or select a project image. If empty, system will fallback to Featured Image or legacy Path.',
                'required' => 0,
                'return_format' => 'id',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
        ),
        'location' => $location_rules,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Project-specific metadata used for filtering and display in the Project Library.',
    ));
}
add_action('acf/init', 'wataco_register_project_details_fields');

/**
 * Note for Single Project Template:
 * Since the original data was imported into 'project_img_path' (Text), 
 * the frontend must use the following priority:
 * 1. get_field('project_img') (ACF Image ID/URL)
 * 2. get_post_thumbnail_id() (WP Featured Image)
 * 3. get_post_meta($id, 'project_img_path', true) (Legacy text path)
 */
