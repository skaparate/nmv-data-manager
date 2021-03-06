<?php
/**
 * File that contains the plugin orchestrator class.
 *
 * @since 1.0.0
 * @package Nicomv/Data_Manager
 */

namespace Nicomv\Data_Manager;

use Commands;
use Nicomv\Data_Manager\Controllers\Admin_Controller;
use Nicomv\Data_Manager\Controllers\Challenge_Controller;
use Nicomv\Data_Manager\Includes\Data_Service;
use Nicomv\Data_Manager\Shortcodes\Data_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Main plugin class to orchestrate the work.
 *
 * @version 1.0.0
 */
class Main {

	/**
	 * The plugin slug.
	 */
	const PLUGIN_SLUG = 'nmv-data-manager';

	/**
	 * Current plugin version.
	 */
	const PLUGIN_VERSION = '1.0.0';

	/**
	 * Because of the features used, we require a version of
	 * PHP 7 or more to work properly.
	 *
	 * @since 1.0.0
	 */
	const MIN_PHP_VERSION = '7.0.0';

	/**
	 * Singleton instance.
	 *
	 * @since 1.0.0
	 * @var Nicomv/Data_Manager/Main
	 */
	private static $instance = null;

	/**
	 * Holds the instances to the provided plugin shortcodes.
	 *
	 * @var array
	 */
	private $shortcode_instances = array();

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	private function __construct() {
	}

	/**
	 * Gets a singleton instance.
	 *
	 * @return Main A singleton instance of this class.
	 */
	public static function get_instance(): Main {
		if ( null === self::$instance ) {
			error_log( 'DATA_MANAGER, Main - Creating instance' );
			self::$instance = new Main();
		} else {
			error_log( 'DATA_MANAGER, Main - Returning already created instance' );
		}

		return self::$instance;
	}

	/**
	 * Begins the plugin execution
	 */
	public function run() {
		if ( false === $this->is_php_version_requirement_met() ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			$commands = Commands::instance();
			$commands->register();
		} else {
			$this->load_text_domain();
			$this->register_controllers();
		}
	}

	/**
	 * Runs actions on the init WordPress hook.
	 */
	public function on_init() {
		$this->register_shortcodes();
	}

	/**
	 * Runs actions for the enqueue scripts WordPress hook.
	 */
	public function on_enqueue_scripts() {
		$this->register_scripts();
	}

	/**
	 * Runs action for the admin enqueue scripts WordPress hook.
	 */
	public function on_admin_enqueue_scripts() {
		$this->register_admin_scripts();
	}

	/**
	 * Runs actions for the enqueue styles WordPress hook.
	 */
	public function on_enqueue_styles() {
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_text_domain() {
		load_plugin_textdomain(
			self::PLUGIN_SLUG,
			false,
			NMV_DATA_MANAGER_URL . '/languages/'
		);
	}

	/**
	 * Registers the administration options.
	 */
	public function on_admin_menu() {
		error_log( 'DATA_MANAGER, Main - Administration page ' );
		$admin_controller = new Admin_Controller( new Data_Service() );
		$hook             = add_menu_page(
			__( 'NMV Data Manager', 'nmv-data-manager' ),
			__( 'Data Manager', 'nmv-data-manager' ),
			'manage_options',
			'nmv-data-manager',
			array( $admin_controller, 'admin_page' ),
			'',
			null
		);

		add_action( 'load-' . $hook, array( $admin_controller, 'load' ) );
	}

	/**
	 * Check if the PHP version is equal or higher than the required by the plugin.
	 */
	private function is_php_version_requirement_met() {
		return version_compare( PHP_VERSION, self::MIN_PHP_VERSION, '>=' );
	}

	/**
	 * Register controllers.
	 */
	private function register_controllers() {
		$data_service         = new Data_Service();
		$challenge_controller = new Challenge_Controller( $data_service );
		add_action( 'wp_ajax_' . Challenge_Controller::ACTION_GET, array( $challenge_controller, 'get' ) );

		if ( ! is_admin() ) {
			add_action( 'wp_ajax_nopriv_' . Challenge_Controller::ACTION_GET, array( $challenge_controller, 'get' ) );
		}
	}

	/**
	 * Registers the shortcodes for the plugin.
	 */
	private function register_shortcodes() {
		$this->shortcode_instances['nmv_data_manager'] = new Data_Manager();

		foreach ( $this->shortcode_instances as $name => $instance ) {
			add_shortcode( $name, array( $instance, 'run' ) );
		}
	}

	/**
	 * Register scripts.
	 */
	private function register_scripts() {
		$this->register_common_scripts();
		foreach ( $this->shortcode_instances as $name => $instance ) {
			$instance->enqueue_scripts();
			$instance->enqueue_styles();
		}
		wp_enqueue_script( 'nmv-data-manager-tablemgr' );
	}

	/**
	 * Registers admin side scripts and styles.
	 */
	private function register_admin_scripts() {
		$this->register_common_scripts();
		wp_enqueue_script(
			'nmv-data-manager-backend',
			NMV_DATA_MANAGER_URL . 'src/assets/js/backend.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);
		wp_enqueue_style(
			'nmv-data-manager',
			NMV_DATA_MANAGER_URL . 'src/assets/css/backend.css',
			array(),
			'1.0.0',
			'all'
		);
		wp_localize_script(
			'nmv-data-manager-backend',
			'nmvDataManager',
			array(
				'ajaxURL'       => admin_url( 'admin-ajax.php' ),
				'refreshAction' => Challenge_Controller::ACTION_GET,
				'nonce'         => 'nonce' . Challenge_Controller::ACTION_GET,
			)
		);
		wp_enqueue_script( 'nmv-data-manager-tablemgr' );
	}

	/**
	 * Registers common scripts and styles for the front and back end.
	 */
	private function register_common_scripts() {
		wp_enqueue_style(
			'nmv-data-manager-fontello',
			NMV_DATA_MANAGER_URL . 'src/assets/css/fontello.css',
			array(),
			'1.0.0',
			'all'
		);
		wp_enqueue_style(
			'nmv-data-manager-base',
			NMV_DATA_MANAGER_URL . 'src/assets/css/base.css',
			array(),
			'1.0.0',
			'all'
		);
	}
}
