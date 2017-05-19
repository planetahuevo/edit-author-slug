<?php
/**
 * Bootstrap the plugin unit testing environment.
 *
 * @package WordPress
 * @subpackage Edit Author Slug
 */

// Support for:
// 1. `WP_DEVELOP_DIR` environment variable.
// 2. Plugin installed inside of WordPress.org developer checkout.
// 3. WordPress.org developer checked out to /tmp.
// 4. Tests checked out to /tmp.
if ( false !== getenv( 'WP_DEVELOP_DIR' ) ) {
	$_tests_dir = getenv( 'WP_DEVELOP_DIR' ) . '/tests/phpunit';
} elseif ( file_exists( '../../../../tests/phpunit/includes/bootstrap.php' ) ) {
	$_tests_dir = '../../../../tests/phpunit';
} elseif ( file_exists( '/tmp/wordpress/tests/phpunit/includes/bootstrap.php' ) ) {
	$_tests_dir = '/tmp/wordpress/tests/phpunit';
} elseif ( file_exists( '/tmp/wordpress-tests-lib/includes/bootstrap.php' ) ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

require_once $_tests_dir . '/includes/functions.php';

/**
 * Compatibility with PHPUnit 6+
 */
$_needs_phpunit_back_compat = in_array(
	getenv( 'WP_VERSION' ),
	array( '4.6', '4.5', '4.4', '4.3' ),
	true
);
if ( class_exists( 'PHPUnit\Runner\Version' ) && $_needs_phpunit_back_compat ) {
	require_once dirname( __FILE__ ) . '/phpunit6-compat.php';
}

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( __FILE__ ) . '/../edit-author-slug.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $_tests_dir . '/includes/bootstrap.php';
