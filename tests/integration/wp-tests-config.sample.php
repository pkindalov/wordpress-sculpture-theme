<?php
/**
 * Sample WordPress integration test configuration.
 *
 * Copy this file to wp-tests-config.php (which is gitignored) and adjust for
 * your machine, or set the matching WP_TESTS_* environment variables. No real
 * credentials are committed — they come from the environment or your local copy.
 *
 * IMPORTANT: DB_NAME must point at a DEDICATED, disposable test database. The
 * WordPress test bootstrap DROPS AND RECREATES ALL TABLES in this database on
 * every run, so it must never be the live site database (stan-bronze-stone-2).
 *
 * @package Sculpture_Theme
 */

// Path to the existing WordPress core install (must contain wp-settings.php).
define('ABSPATH', getenv('WP_TESTS_ABSPATH') ?: 'C:/wamp64/www/stan-bronze-stone-2/');

// Dedicated, disposable test database.
define('DB_NAME', getenv('WP_TESTS_DB_NAME') ?: 'sculpture_tests');
define('DB_USER', getenv('WP_TESTS_DB_USER') ?: 'root');
define('DB_PASSWORD', getenv('WP_TESTS_DB_PASSWORD') ?: '');
define('DB_HOST', getenv('WP_TESTS_DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$table_prefix = 'wptests_';

define('WP_TESTS_DOMAIN', 'example.org');
define('WP_TESTS_EMAIL', 'admin@example.org');
define('WP_TESTS_TITLE', 'Sculpture Theme Tests');

define('WP_PHP_BINARY', 'php');

define('WP_DEBUG', true);
