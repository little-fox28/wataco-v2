<?php
/**
 * Native WordPress Theme Settings page.
 *
 * @package Wataco
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register top-level admin menu for Contact Settings.
 *
 * @return void
 */
function wataco_register_settings_menu_page() {
    add_menu_page(
        __('Cotact Settings', 'wataco'),
        __('Cotact Settings', 'wataco'),
        'edit_others_posts',
        'wataco-settings',
        'wataco_render_settings_page',
        'dashicons-admin-generic',
        80
    );
}
add_action('admin_menu', 'wataco_register_settings_menu_page');

/**
 * Sanitize Zalo value that may be either URL or phone-like text.
 *
 * @param string $value Raw input value.
 * @return string
 */
function wataco_sanitize_zalo_value($value) {
    if (!is_string($value)) {
        return '';
    }

    $value = trim($value);
    if ($value === '') {
        return '';
    }

    if (filter_var($value, FILTER_VALIDATE_URL)) {
        return esc_url_raw($value);
    }

    return sanitize_text_field($value);
}

/**
 * Register settings, section, and fields for Contact Settings page.
 *
 * @return void
 */
function wataco_register_theme_settings() {
    register_setting(
        'wataco_theme_settings_group',
        'wataco_social_facebook',
        array(
            'type'              => 'string',
            'sanitize_callback' => 'esc_url_raw',
            'default'           => '',
        )
    );
    register_setting(
        'wataco_theme_settings_group',
        'wataco_social_linkedin',
        array(
            'type'              => 'string',
            'sanitize_callback' => 'esc_url_raw',
            'default'           => '',
        )
    );
    register_setting(
        'wataco_theme_settings_group',
        'wataco_social_zalo',
        array(
            'type'              => 'string',
            'sanitize_callback' => 'wataco_sanitize_zalo_value',
            'default'           => '',
        )
    );
    register_setting(
        'wataco_theme_settings_group',
        'wataco_contact_phone',
        array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        )
    );
    register_setting(
        'wataco_theme_settings_group',
        'wataco_contact_email',
        array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_email',
            'default'           => '',
        )
    );

    add_settings_section(
        'wataco_theme_settings_section',
        __('Global Social & Contact Links', 'wataco'),
        'wataco_render_theme_settings_section_description',
        'wataco-settings'
    );

    add_settings_field(
        'wataco_social_facebook',
        __('Facebook URL', 'wataco'),
        'wataco_render_theme_settings_field',
        'wataco-settings',
        'wataco_theme_settings_section',
        array(
            'option_name' => 'wataco_social_facebook',
            'type'        => 'url',
            'placeholder' => 'https://facebook.com/your-page',
        )
    );
    add_settings_field(
        'wataco_social_linkedin',
        __('LinkedIn URL', 'wataco'),
        'wataco_render_theme_settings_field',
        'wataco-settings',
        'wataco_theme_settings_section',
        array(
            'option_name' => 'wataco_social_linkedin',
            'type'        => 'url',
            'placeholder' => 'https://linkedin.com/company/your-company',
        )
    );
    add_settings_field(
        'wataco_social_zalo',
        __('Zalo Link/Phone', 'wataco'),
        'wataco_render_theme_settings_field',
        'wataco-settings',
        'wataco_theme_settings_section',
        array(
            'option_name' => 'wataco_social_zalo',
            'type'        => 'text',
            'placeholder' => 'https://zalo.me/your-id or 0359 959 831',
        )
    );
    add_settings_field(
        'wataco_contact_phone',
        __('Hotline Phone', 'wataco'),
        'wataco_render_theme_settings_field',
        'wataco-settings',
        'wataco_theme_settings_section',
        array(
            'option_name' => 'wataco_contact_phone',
            'type'        => 'text',
            'placeholder' => '0359 959 831',
        )
    );
    add_settings_field(
        'wataco_contact_email',
        __('Hotline Email', 'wataco'),
        'wataco_render_theme_settings_field',
        'wataco-settings',
        'wataco_theme_settings_section',
        array(
            'option_name' => 'wataco_contact_email',
            'type'        => 'email',
            'placeholder' => 'info@wataco.net',
        )
    );
}
add_action('admin_init', 'wataco_register_theme_settings');

/**
 * Render settings section helper description.
 *
 * @return void
 */
function wataco_render_theme_settings_section_description() {
    echo '<p>' . esc_html__('Manage global social media and contact links used across the website.', 'wataco') . '</p>';
}

/**
 * Render a single settings API field.
 *
 * @param array<string, string> $args Field configuration.
 * @return void
 */
function wataco_render_theme_settings_field($args) {
    $option_name = isset($args['option_name']) ? (string) $args['option_name'] : '';
    if ($option_name === '') {
        return;
    }

    $field_type = isset($args['type']) ? (string) $args['type'] : 'text';
    $placeholder = isset($args['placeholder']) ? (string) $args['placeholder'] : '';
    $value = (string) get_option($option_name, '');
    ?>
    <input
        type="<?php echo esc_attr($field_type); ?>"
        id="<?php echo esc_attr($option_name); ?>"
        name="<?php echo esc_attr($option_name); ?>"
        value="<?php echo esc_attr($value); ?>"
        class="regular-text"
        placeholder="<?php echo esc_attr($placeholder); ?>" />
    <?php
}

/**
 * Render Contact Settings page content.
 *
 * @return void
 */
function wataco_render_settings_page() {
    if (!current_user_can('edit_others_posts')) {
        wp_die(esc_html__('You do not have permission to access this page.', 'wataco'));
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Contact Settings', 'wataco'); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('wataco_theme_settings_group');
            do_settings_sections('wataco-settings');
            submit_button(__('Save Settings', 'wataco'));
            ?>
        </form>
    </div>
    <?php
}
