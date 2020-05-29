<?php
/**
 * Handles the requests to the challenge API.
 *
 * @package Nicomv/Data_Manager/Controllers
 */

 namespace Nicomv\Data_Manager\Controllers;

use Nicomv\Data_Manager\Includes\Data_Service;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Handles the requests to the challenge API.
 *
 * @version 1.0.0
 */
class Challenge_Controller {
	/**
	 * An instance of the Data_Service.
	 *
	 * @var Data_Service
	 */
	private $data_service = '';

	/**
	 * Builds an instance of this controller.
	 *
	 * @param Data_Service $data_service The service used that handles the
	 * interaction with the API.
	 */
	public function __construct( Data_Service $data_service ) {
		$this->data_service = $data_service;
	}

	/**
	 * Performs the retrieval of the data.
	 */
	public function get() {
		error_log( 'DATA_MANAGER, Challenge_Controller - Get action' );
		$data = $this->data_service->get_data();
		echo wp_json_encode( array( 'data' => $data ) );
		wp_die();
	}
}
