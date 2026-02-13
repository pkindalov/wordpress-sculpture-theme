<?php
/**
 * Enqueue Scripts and Styles
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue parent and child theme styles
 * 
 * Proper method for loading CSS files
 */
function sculpture_theme_enqueue_styles() {
    
    // Parent theme (Astra) stylesheet
    wp_enqueue_style(
        'astra-parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme('astra')->get('Version')
    );
    
    // Child theme main stylesheet
    wp_enqueue_style(
        'sculpture-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('astra-parent-style'),
        SCULPTURE_THEME_VERSION
    );
    
    // Custom CSS file (if you want separate custom styles)
    wp_enqueue_style(
        'sculpture-custom-style',
        SCULPTURE_THEME_URI . '/assets/css/custom.css',
        array('sculpture-child-style'),
        SCULPTURE_THEME_VERSION
    );
}
add_action('wp_enqueue_scripts', 'sculpture_theme_enqueue_styles');

/**
 * Enqueue custom JavaScript
 * 
 * Load in footer for better performance
 */
function sculpture_theme_enqueue_scripts() {
    
    // Custom JavaScript file
    wp_enqueue_script(
        'sculpture-custom-scripts',
        SCULPTURE_THEME_URI . '/assets/js/scripts.js',
        array('jquery'), // Dependencies
        SCULPTURE_THEME_VERSION,
        true // Load in footer
    );
    
    // Pass PHP variables to JavaScript (if needed)
    wp_localize_script('sculpture-custom-scripts', 'sculptureTheme', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('sculpture-theme-nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'sculpture_theme_enqueue_scripts');

/**
 * Enqueue admin styles (optional)
 * 
 * Custom styling for WordPress admin area
 */
function sculpture_theme_admin_styles() {
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
add_action('admin_enqueue_scripts', 'sculpture_theme_admin_styles');