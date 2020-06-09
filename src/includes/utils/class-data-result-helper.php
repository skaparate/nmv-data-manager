<?php
/**
 * Includes a class to help with transforming data.
 *
 * @package Nicomv/Data_Manager/Includes
 */

namespace Nicomv\Data_Manager\Includes\Utils;

use Nicomv\Data_Manager\Includes\Sortable;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Helps with transforming a Data_Result into the expected data
 * for the templates.
 *
 * @version 1.0.0
 */
class Data_Result_Helper {
	/**
	 * Builds table headers.
	 *
	 * @param Sortable $sortable A Sortable instance.
	 * @param string   $current_url The curren url.
	 */
	public static function build_headers( Sortable $sortable, $current_url = null ) {
		$headers = array(
			'id'    => array(
				'name'       => 'ID',
				'url'        => '',
				'sort_title' => __( 'Sorts the results by ID', 'nmv-data-manager' ),
			),
			'fname' => array(
				'name'       => __( 'First Name', 'nmv-data-manager' ),
				'url'        => '',
				'sort_title' =>
				__( 'Sort results by the First Name', 'nmv-data-manager' ),
			),
			'lname' => array(
				'name'       => __( 'Last Name', 'nmv-data-manager' ),
				'url'        => '',
				'sort_title' =>
				__( 'Sort results by the Last Name', 'nmv-data-manager' ),
			),
			'email' => array(
				'name'       => __( 'Email', 'nmv-data-manager' ),
				'url'        => '',
				'sort_title' =>
				__( 'Sort the results using the Email', 'nmv-data-manager' ),
			),
			'date'  => array(
				'name'       => __( 'Date', 'nmv-data-manager' ),
				'url'        => '',
				'sort_title' =>
				__( 'Sorts the results by date', 'nmv-data-manager' ),
			),
		);

		if ( ! $current_url ) {
			return $headers;
		}

		$reverse_dir = $sortable->is_ascending ? 'desc' : 'asc';

		foreach ( $headers as $key => $val ) {
			$args = array(
				'sort_by'  => $key,
				'sort_dir' => 'asc',
			);
			if ( $key === $sortable->sort_by ) {
				$args['sort_dir'] = $reverse_dir;
			}
			$headers[ $key ]['url'] = add_query_arg(
				$args,
				$current_url
			);
		}

		return $headers;
	}
}
