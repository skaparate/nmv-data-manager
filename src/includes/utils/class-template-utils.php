<?php
/**
 * Includes template utility functions.
 *
 * @package Nicomv/Data_Manager/Includes/Utils
 */

namespace Nicomv\Data_Manager\Includes\Utils;

/**
 * Template utility functions.
 */
class Template_Utils {
	// phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter
	/**
	 * Imports a template into the current context.
	 *
	 * @param string $name The name of the template to include.
	 * @param array  $context The context data that gets passed to the
	 *  templates.
	 */
	public static function get_template( $name, $context = array() ) {
		$file = NMV_DATA_MANAGER . 'src/templates/' . $name . '.php';

		if ( file_exists( $file ) ) {
			include $file;
		} else {
			error_log( "The requested template '$file' doesn't exist." );
		}
	}
	// phpcs:enable Generic.CodeAnalysis.UnusedFunctionParameter
}
