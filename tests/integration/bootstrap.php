<?php
/**
 * Bootstrap for the WordPress integration test suite.
 *
 * Boots the real WordPress test framework (wp-phpunit) against a dedicated test
 * database, loads ACF so get_field()/update_field() exist, registers the custom
 * post types the shortcodes query (normally provided by the CPT-UI plugin), and
 * loads the theme's helper module under test.
 *
 * @package Sculpture_Theme
 */

if (!defined('WP_TESTS_CONFIG_FILE_PATH')) {
    define('WP_TESTS_CONFIG_FILE_PATH', __DIR__ . '/wp-tests-config.php');
}

if (!file_exists(WP_TESTS_CONFIG_FILE_PATH)) {
    fwrite(
        STDERR,
        "Missing tests/integration/wp-tests-config.php.\n" .
        "Copy wp-tests-config.sample.php to wp-tests-config.php (or set the\n" .
        "WP_TESTS_* environment variables) before running the integration suite.\n"
    );
    exit(1);
}

// Composer autoload registers the Yoast polyfills and sets WP_PHPUNIT__DIR.
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$_tests_dir = getenv('WP_PHPUNIT__DIR');

if (!$_tests_dir || !file_exists($_tests_dir . '/includes/functions.php')) {
    fwrite(STDERR, "Could not locate the wp-phpunit test framework.\n");
    exit(1);
}

require_once $_tests_dir . '/includes/functions.php';

$theme_dir = dirname(__DIR__, 2);

// Load ACF early so the theme's get_field()/update_field() calls resolve.
tests_add_filter('muplugins_loaded', static function () {
    $acf = WP_CONTENT_DIR . '/plugins/advanced-custom-fields/acf.php';
    if (file_exists($acf)) {
        require_once $acf;
    }
});

// Register the CPTs the shortcodes/AJAX handler depend on. On the live site
// these come from CPT-UI (stored in the DB), which the fresh test DB lacks.
tests_add_filter('init', static function () {
    foreach (['sculpture', 'exhibition', 'publication', 'testimonial'] as $cpt) {
        register_post_type($cpt, [
            'public'      => true,
            'has_archive' => true,
            'supports'    => ['title', 'editor', 'thumbnail'],
            'label'       => ucfirst($cpt),
        ]);
    }
}, 5);

require $_tests_dir . '/includes/bootstrap.php';

// Resolve get_template_part() to the real theme without loading its
// functions.php (which would pull in the Astra parent). This lets the shortcode
// partials render during tests.
add_filter('stylesheet_directory', static function () use ($theme_dir) {
    return $theme_dir;
});
add_filter('template_directory', static function () use ($theme_dir) {
    return $theme_dir;
});

// The module under test: registers shortcodes and the testimonial AJAX handler.
require_once $theme_dir . '/inc/template-functions.php';
