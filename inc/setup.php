<?php
/**
 * Theme Setup and Configuration
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 * 
 * Runs after WordPress has finished loading but before any headers are sent
 */
function sculpture_theme_setup() {
    
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Set content width (prevents images from being too large)
    if (!isset($content_width)) {
        $content_width = 1200;
    }
    
    // Register navigation menus (if needed in future)
    register_nav_menus(array(
        'footer-menu' => __('Footer Menu', 'sculpture-theme'),
    ));
    
    // Add custom image sizes (useful for galleries)
    add_image_size('sculpture-thumbnail', 400, 400, true);
    add_image_size('sculpture-medium', 800, 600, true);
    add_image_size('sculpture-large', 1200, 900, false);
}
add_action('after_setup_theme', 'sculpture_theme_setup');

/**
 * Custom excerpt length
 * 
 * Changes the default excerpt length from 55 to 30 words
 */
function sculpture_custom_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'sculpture_custom_excerpt_length');

/**
 * Custom excerpt more text
 * 
 * Changes the default [...] to custom text
 */
function sculpture_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'sculpture_excerpt_more');