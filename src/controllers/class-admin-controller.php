<?php
/**
 * Includes the administration page and options.
 *
 * @package Nicomv/Data_Manager/Controllers
 */

namespace Nicomv\Data_Manager\Controllers;

use Nicomv\Data_Manager\Includes\Sortable;
use Nicomv\Data_Manager\Includes\Utils\Template_Utils;
use Nicomv\Data_Manager\Includes\Data_Service;
use Nicomv\Data_Manager\Includes\Sorter;
use Nicomv\Data_Manager\Includes\Utils\Data_Result_Filter;
use Nicomv\Data_Manager\Includes\Utils\Data_Result_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Administration page and options.
 */
class Admin_Controller {
	/**
	 * An instance of the data service class.
	 *
	 * @var Data_Service
	 */
	private $data_service;

	/**
	 * Default constructor.
	 *
	 * @param Data_Service $data_service A data service instance.
	 */
	public function __construct( Data_Service $data_service ) {
		$this->data_service = $data_service;
	}
	/**
	 * Retrieves the administration page.
	 */
	public function admin_page() {
		$current_url = menu_page_url( 'nmv-data-manager', false );
		$sortable    = Sortable::from_get_request();
		$header_urls = Data_Result_Helper::build_headers( $sortable, $current_url );
		$data        = $this->data_service->get_data();
		$data        = Data_Result_Filter::filter_data( $data );
		$data        = $data->with_content( Sorter::sort_data( $sortable, $data->content ) );
		Template_Utils::get_template(
			'backend',
			compact(
				'header_urls',
				'sortable',
				'data'
			)
		);
	}

	/**
	 * Trigered when the page is submitted.
	 */
	public function load() {
		error_log( 'DATA_MANAGER, Admin_Controller - Load' );
	}
}
