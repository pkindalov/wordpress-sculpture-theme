<?php
/**
 * Sculpture Theme - Functions and definitions
 *
 * @package Sculpture_Theme
 * @since   1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme version
 */
define('SCULPTURE_THEME_VERSION', '1.0.0');

/**
 * Theme directory path
 */
define('SCULPTURE_THEME_DIR', get_stylesheet_directory());

/**
 * Theme directory URI
 */
define('SCULPTURE_THEME_URI', get_stylesheet_directory_uri());

/**
 * Load theme modules
 * 
 * Organized approach: each functionality in its own file
 */

// Theme setup and configuration
require_once SCULPTURE_THEME_DIR . '/inc/setup.php';

// Enqueue styles and scripts
require_once SCULPTURE_THEME_DIR . '/inc/enqueue.php';

// ACF functions (only if ACF is active)
if (function_exists('get_field')) {
    require_once SCULPTURE_THEME_DIR . '/inc/acf-functions.php';
}

// Template helper functions
require_once SCULPTURE_THEME_DIR . '/inc/template-functions.php';

/**
 * Theme initialization hook
 * 
 * Use this hook for any initialization that needs to happen
 * after all modules are loaded
 */
do_action('sculpture_theme_init');

// KILL Astra completely for sculptures
add_action('template_redirect', 'sculpture_kill_astra');
function sculpture_kill_astra() {
    if (is_singular('sculpture')) {
        remove_all_actions('astra_header');
        remove_all_actions('astra_content_top');
        remove_all_actions('astra_entry_top');
        remove_all_actions('astra_entry_content_before');
        remove_all_actions('astra_entry_content_after');
        remove_all_actions('astra_entry_bottom');
        remove_all_actions('astra_content_bottom');
        
        add_filter('theme_mod_ast-container-width', function() { return 100; });
        add_filter('astra_page_layout', function() { return 'no-sidebar'; });
        add_filter('astra_content_layout', function() { return 'plain-container'; });
    }
}