<?php
/**
 * Handles the requests to the challenge API.
 *
 * @package Nicomv/Data_Manager/Controllers
 */

 namespace Nicomv\Data_Manager\Controllers;

use Nicomv\Data_Manager\Includes\Data_Result;
use Nicomv\Data_Manager\Includes\Data_Service;
use Nicomv\Data_Manager\Includes\Sortable;
use Nicomv\Data_Manager\Includes\Sorter;
use Nicomv\Data_Manager\Includes\Utils\Data_Result_Helper;
use Nicomv\Data_Manager\Includes\Utils\Template_Utils;

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
	 * Action name for retrieving the data.
	 *
	 * @var string
	 */
	const ACTION_GET = 'nmv_datamanager_get';

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
		$sortable = Sortable::from_get_request();
		error_log( 'DATA_MANAGER, Challenge_Controller#get - ' . $sortable );

		$data           = $this->data_service->get_data();
		$data           = $data->with_content( Sorter::sort_data( $sortable, $data->content ) );
		$header_urls    = Data_Result_Helper::build_headers(
			$sortable
		);
		$exclude_footer = true;
		Template_Utils::get_template(
			'table-results',
			compact(
				'header_urls',
				'data',
				'exclude_footer'
			)
		);

		wp_die();
	}
}
