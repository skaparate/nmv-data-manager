<?php
/**
 * The main shortcode for the plugin.
 *
 * @package Nicomv/Data_Manager/Shortcodes
 */

namespace Nicomv\Data_Manager\Shortcodes;

use Nicomv\Data_Manager\Includes\Template_Utils;
use Nicomv\Data_Manager\Main;

/**
 * Shortcode used to display data on the front end.
 *
 * @version 1.0.0
 */
final class Data_Manager {
	/**
	 * Setups the required scripts and styles.
	 */
	public function __construct() {
	}

	/**
	 * Runs the shortcode code.
	 *
	 * @param array $attributes The attributes on the shortcode tag.
	 */
	public function run( $attributes ) {
		error_log( 'DATA_MANAGER, SC_Data_Manager - Parsing' );
		ob_start();
		Template_Utils::get_template( 'frontend' );
		$html = ob_get_contents();
		ob_clean();
		$html = apply_filters( 'nicomv_data_manager_main_sc_html', $html );
		return $html;
	}

	/**
	 * Enqueues the required scripts for this shortcode.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			'nmv-data-manager',
			NMV_DATA_MANAGER_URL . 'src/assets/js/frontend.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);
		wp_localize_script(
			'nmv-data-manager',
			'nmvDataManager',
			array(
				'actionChallengeGet' => Main::ACTION_CHALLENGE_GET,
				'ajaxURL'            => admin_url(
					'admin-ajax.php'
				),
			)
		);
	}

	/**
	 * Enqueues the required styles for this shorcode.
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'nmv-data-manager',
			NMV_DATA_MANAGER_URL . 'src/assets/css/frontend.css',
			array(),
			'1.0.0',
			'all'
		);
	}
}
