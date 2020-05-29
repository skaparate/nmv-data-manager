<?php
/**
 * The plugin bootstrap file
 *
 * @link    https://nicomv.com/
 * @since   1.0.0
 * @package Nicomv/Data_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       NMV Data Manager
 * Plugin URI:        https://github.com/skaparate/nmv-wp-data-manager
 * Description:
 * Version:           1.0.0
 * Author:            Nicolas Mancilla
 * Author URI:        https://nicomv.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nmv-data-manager
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Defines the plugin base path.
 */
define( 'NMV_DATA_MANAGER', plugin_dir_path( __FILE__ ) );

/**
 * Defines the plugin base URL.
 */
define( 'NMV_DATA_MANAGER_URL', plugins_url( '/', __FILE__ ) );

/**
 * Executes the plugin.
 */
function nmv_data_manager_run() {
	error_log( 'DATA_MANAGER, nmv_data_manager_run - Plugins loaded' );
	require_once NMV_DATA_MANAGER . '/src/autoload.php';
	$main = \Nicomv\Data_Manager\Main::get_instance();
	$main->run();

	add_action( 'init', array( $main, 'on_init' ) );
	add_action( 'wp_enqueue_scripts', array( $main, 'on_enqueue_scripts' ) );
	add_action( 'admin_menu', array( $main, 'on_admin_menu' ) );
}

add_action( 'plugins_loaded', 'nmv_data_manager_run', 0 );
