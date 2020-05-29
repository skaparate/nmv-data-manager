<?php
/**
 * File for the WP CLI command to refresh the data.
 *
 * @since 0.0.1
 * @package Nicomv\Data_Manager\Includes
 */

use Nicomv\Data_Manager\Includes\Data_Service;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

function purge_cache() {
}

/**
 * Provides the plugin WordPress CLI commands.
 */
class Commands {
	/**
	 * Defines the command name to purge the cache.
	 */
	const PURGE_CACHE = 'nmv data-manager purge-cache';

	/**
	 * Static instance of the class.
	 *
	 * @var Commands
	 */
	private static $instance = null;

	/**
	 * Retrieves the instance of this class.
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new Commands();
		}

		return self::$instance;
	}

	/**
	 * Registers the commands
	 */
	public function register() {
		error_log( 'DATA_MANAGER, Commands::register - Registering commands' );
		WP_CLI::add_command(
			self::PURGE_CACHE,
			array( $this, 'purge_cache' )
		);
	}

	/**
	 * Purges the cached data generated when contacting the REST API.
	 */
	public function purge_cache() {
		if ( delete_transient( esc_url( Data_Service::APIURI ) ) ) {
			WP_CLI::success( 'cache cleared.' );
		} else {
			WP_CLI::log( 'could not removed the data.' );
		}
	}
}
