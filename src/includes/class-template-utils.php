<?php
/**
 * Includes template utility functions.
 *
 * @package Nicomv/Data_Manager/Includes
 */

namespace Nicomv\Data_Manager\Includes;

/**
 * Template utility functions.
 */
class Template_Utils {
	/**
	 * Imports a template into the current context.
	 *
	 * @param string $name The name of the template to include.
	 */
	public static function get_template( $name ) {
		$file = NMV_DATA_MANAGER . 'src/templates/' . $name . '.php';

		if ( file_exists( $file ) ) {
			include $file;
		} else {
			error_log( "The requested template '$file' doesn't exist." );
		}
	}
}
