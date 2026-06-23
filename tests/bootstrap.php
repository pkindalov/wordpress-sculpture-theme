<?php
/**
 * PHPUnit bootstrap.
 *
 * Loads Composer's autoloader (which activates Patchwork, used by Brain Monkey
 * to redefine WordPress functions), then loads the theme's helper module so its
 * functions are available to the test suite.
 *
 * @package Sculpture_Theme
 */

// Activate Patchwork before any code under test is included, so calls inside
// it can be intercepted by Brain Monkey.
require_once dirname(__DIR__) . '/vendor/autoload.php';

// The helper module guards on ABSPATH and registers hooks at include time.
// Define the constant and stub the load-time hook functions so the file can be
// required outside of WordPress. These are not the functions under test.
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__DIR__) . '/');
}

if (!function_exists('add_shortcode')) {
    function add_shortcode($tag, $callback)
    {
    }
}

if (!function_exists('add_filter')) {
    function add_filter($hook, $callback, $priority = 10, $accepted_args = 1)
    {
    }
}

if (!function_exists('add_action')) {
    function add_action($hook, $callback, $priority = 10, $accepted_args = 1)
    {
    }
}

require_once dirname(__DIR__) . '/inc/template-functions.php';
