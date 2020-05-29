<?php
/**
 * Includes the administration page and options.
 *
 * @package Nicomv/Data_Manager/Controllers
 */

namespace Nicomv\Data_Manager\Controllers;

use Nicomv\Data_Manager\Includes\Template_Utils;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Administration page and options.
 */
class Admin_Controller {
	/**
	 * Retrieves the administration page.
	 */
	public function admin_page() {
		Template_Utils::get_template( 'backend' );
	}
}
