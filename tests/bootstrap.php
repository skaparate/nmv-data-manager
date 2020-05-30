<?php
/**
 * Bootstrap the tests to include the autoloading plugin.
 *
 * @package Nicomv\Data_Manager\Tests
 */

define( 'NMV_TEST_ROOT', dirname( dirname( __FILE__ ) ) );

$dotenv = Dotenv\Dotenv::createImmutable( NMV_TEST_ROOT, '.env' );
$dotenv->load();

require_once NMV_TEST_ROOT . '/vendor/autoload.php';

$wp_test_libs = NMV_TEST_ROOT . DIRECTORY_SEPARATOR . $_ENV['WP_TEST_LIBS_DIR'];
require_once $wp_test_libs . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require NMV_TEST_ROOT . '/nmv-data-manager.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require_once $wp_test_libs . '/includes/bootstrap.php';
