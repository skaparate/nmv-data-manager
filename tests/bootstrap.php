<?php
/**
 * Bootstrap the tests to include the autoloading plugin.
 *
 * @package Nicomv\Data_Manager\Tests
 */

$dotenv = Dotenv\Dotenv::createImmutable( NMV_DATA_MANAGER, '.env' );
$dotenv->load();

require_once NMV_DATA_MANAGER . '/src/autoload.php';
require_once NMV_DATA_MANAGER . '/vendor/autoload.php';

$wp_test_libs = NMV_DATA_MANAGER . DIRECTORY_SEPARATOR . $_ENV['WP_TEST_LIBS_DIR'];
require_once $wp_test_libs . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require NMV_DATA_MANAGER . '/test-plugin.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require_once $wp_test_libs . '/includes/bootstrap.php';
