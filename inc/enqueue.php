<?php
/**
 * Enqueue Scripts and Styles
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined("ABSPATH")) {
    exit();
}

/**
 * Enqueue parent and child theme styles
 *
 * Proper method for loading CSS files
 */
function sculpture_theme_enqueue_styles()
{
    $css_dir = get_stylesheet_directory() . "/assets/css/";
    $css_uri = get_stylesheet_directory_uri() . "/assets/css/";
    
    // Base - винаги зарежда
    wp_enqueue_style(
        "sculpture-base",
        $css_uri . "base.css",
        [],
        filemtime($css_dir . "base.css"),
    );
    
    // Components - винаги зареждат
    $components = ["cards", "filters", "footer", "promotions", "exhibitions", "publications", "testimonials", "contact-form", "homepage-sculptures"];
    foreach ($components as $component) {
        wp_enqueue_style(
            "sculpture-" . $component,
            $css_uri . "components/" . $component . ".css",
            ["sculpture-base"],
            filemtime($css_dir . "components/" . $component . ".css"),
        );
    }
    
    // Pages - зареждат само на нужната страница
    if (is_singular("sculpture")) {
        wp_enqueue_style(
            "sculpture-single",
            $css_uri . "pages/single.css",
            ["sculpture-base"],
            filemtime($css_dir . "pages/single.css"),
        );
    }
    
    if (is_post_type_archive("sculpture")) {
        wp_enqueue_style(
            "sculpture-archive",
            $css_uri . "pages/archive.css",
            ["sculpture-base"],
            filemtime($css_dir . "pages/archive.css"),
        );
    }
    
    if (is_front_page() || is_home()) {
        wp_enqueue_style(
            "sculpture-homepage",
            $css_uri . "pages/homepage.css",
            ["sculpture-base"],
            filemtime($css_dir . "pages/homepage.css"),
        );
    }

    if (is_page(['privacy-policy', 'terms', 'privacy-policy-2', 'terms-2'])) {
        wp_enqueue_style(
            "sculpture-legal",
            $css_uri . "pages/legal.css",
            ["sculpture-base"],
            filemtime($css_dir . "pages/legal.css"),
        );
    }
    
    wp_enqueue_style(
        "sculpture-mobile",
        $css_uri . "responsive/mobile.css",
        ["sculpture-base"],
        filemtime($css_dir . "responsive/mobile.css"),
    );
}
add_action("wp_enqueue_scripts", "sculpture_theme_enqueue_styles");



/**
 * Enqueue custom JavaScript
 *
 * Load in footer for better performance
 */
function sculpture_theme_enqueue_scripts()
{
    $js_dir = get_stylesheet_directory() . "/assets/js/";

    // Custom JavaScript file
    wp_enqueue_script(
        "sculpture-custom-scripts",
        SCULPTURE_THEME_URI . "/assets/js/scripts.js",
        ["jquery"], // Dependencies
        filemtime($js_dir . "scripts.js"),
        true, // Load in footer
    );

    // Pass PHP variables to JavaScript (if needed)
    wp_localize_script("sculpture-custom-scripts", "sculptureTheme", [
        "ajaxUrl" => admin_url("admin-ajax.php"),
        "nonce" => wp_create_nonce("sculpture-theme-nonce"),
    ]);

    // Testimonials JavaScript
    wp_enqueue_script(
        'sculpture-testimonials',
        SCULPTURE_THEME_URI . '/assets/js/testimonials.js',
        array(),
        filemtime($js_dir . "testimonials.js"),
        true
    );

    if (is_page(['privacy-policy', 'terms', 'privacy-policy-2', 'terms-2'])) {
        wp_enqueue_script(
            'sculpture-legal-progress',
            SCULPTURE_THEME_URI . '/assets/js/legal-progress.js',
            [],
            filemtime($js_dir . 'legal-progress.js'),
            true
        );
    }
}
add_action("wp_enqueue_scripts", "sculpture_theme_enqueue_scripts");

/**
 * Enqueue admin styles (optional)
 *
 * Custom styling for WordPress admin area
 */
function sculpture_theme_admin_styles()
{
    // Uncomment if you need custom admin CSS
    /*
    wp_enqueue_style(
        'sculpture-admin-style',
        SCULPTURE_THEME_URI . '/assets/css/admin.css',
        array(),
        SCULPTURE_THEME_VERSION
    );
    */
}
add_action("admin_enqueue_scripts", "sculpture_theme_admin_styles");
