<?php
/**
 * Advanced Custom Fields Functions
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined("ABSPATH")) {
    exit();
}

/**
 * ACF Shortcode
 *
 * Display ACF field values using shortcode
 * Usage: [acf field="field_name"]
 *
 * @param array $atts Shortcode attributes
 * @return string Field value or empty string
 */
function sculpture_acf_shortcode($atts)
{
    // Default attributes
    $atts = shortcode_atts(
        [
            "field" => "",
            "post_id" => false,
        ],
        $atts,
        "acf",
    );

    // Return empty if no field specified
    if (empty($atts["field"])) {
        return "";
    }

    // Get field value
    $value = get_field($atts["field"], $atts["post_id"]);

    // Return empty if no value
    if (!$value) {
        return "";
    }

    // If value is array (gallery, repeater, etc.), don't display
    // These complex fields should be handled in templates
    if (is_array($value)) {
        return "";
    }

    // Security: Escape output - allows safe HTML
    return wp_kses_post($value);
}
add_shortcode("acf", "sculpture_acf_shortcode");

/**
 * ACF Options Page (optional)
 *
 * Creates a theme settings page in admin
 * Uncomment to enable
 */
/*
if (function_exists('acf_add_options_page')) {
    
    acf_add_options_page(array(
        'page_title' => __('Theme Settings', 'sculpture-theme'),
        'menu_title' => __('Theme Settings', 'sculpture-theme'),
        'menu_slug'  => 'sculpture-theme-settings',
        'capability' => 'edit_posts',
        'icon_url'   => 'dashicons-admin-generic',
        'position'   => 60,
    ));
}
*/

/**
 * Register ACF field groups programmatically (optional)
 *
 * Example of creating ACF fields via code instead of UI
 * Uncomment and modify as needed
 */
/*
function sculpture_register_acf_fields() {
    
    if (function_exists('acf_add_local_field_group')) {
        
        acf_add_local_field_group(array(
            'key' => 'group_sculpture_info',
            'title' => 'Sculpture Information',
            'fields' => array(
                array(
                    'key' => 'field_year',
                    'label' => 'Year',
                    'name' => 'година',
                    'type' => 'number',
                ),
                array(
                    'key' => 'field_material',
                    'label' => 'Material',
                    'name' => 'материал',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_dimensions',
                    'label' => 'Dimensions',
                    'name' => 'размери',
                    'type' => 'text',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'sculpture', // Your custom post type
                    ),
                ),
            ),
        ));
    }
}
add_action('acf/init', 'sculpture_register_acf_fields');
*/
