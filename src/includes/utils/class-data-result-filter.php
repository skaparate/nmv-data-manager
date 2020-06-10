<?php
/**
 * Includes a class to filter data.
 *
 * @package Nicomv/Data_Manager/Includes/Utils
 */

namespace Nicomv\Data_Manager\Includes\Utils;

use Nicomv\Data_Manager\Includes\Data_Result;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class used to filter data results.
 *
 * @version 1.0.0
 */
class Data_Result_Filter {
	/**
	 * The allowed search terms.
	 *
	 * @var array
	 */
	private static $search_terms = array( 'id', 'fname', 'lname', 'email' );

	/**
	 * Filters the provided data using the provided filters on the
	 * URL query string.
	 *
	 * @param Data_Result $data The data being filtered.
	 * @return Data_Result Returns a Data_Result object with the filtered
	 * contents.
	 */
	public static function filter_data( Data_Result $data ) {
		$search = isset( $_GET['search'] ) ? sanitize_text_field( $_GET['search'] ) : '';

		if ( ! $search ) {
			return $data;
		}

		$terms = explode( ':', $search );

		if ( 2 <= count( $terms ) ) {
			list( $search_by, $search_term ) = $terms;
			if ( ! in_array( $search_by, self::$search_terms, true ) ) {
				return $data;
			}
			if ( 'id' === $search_by ) {
				$search_term = (int) $search_term;
			}
			$results = self::search_data( $data, $search_by, $search_term );
			return $data->with_content( $results );
		}

		$val = $terms[0];

		if ( is_numeric( $val ) ) {
			return $data->with_content( self::search_data( $data, 'id', (int) $val ) );
		}

		if ( is_email( $val ) ) {
			return $data->with_content( self::search_data( $data, 'email', $val ) );
		}

		// It may be the first or last name, so we concat them.
		$results = self::search_data( $data, 'fname', $val );
		$results = array_merge( $results, self::search_data( $data, 'lname', $val ) );
		return $data->with_content( $results );
	}

	/**
	 * The function that handles the filtering.
	 *
	 * @param Data_Result $data The data being filtered.
	 * @param string      $by The key being filtered.
	 * @param mixed       $value The value being searched for.
	 * @return array The filtered contents.
	 */
	private static function search_data( Data_Result $data, string $by, $value ): array {
		$filtered = array();

		foreach ( $data->content as $item ) {
			$other = $item[ $by ];

			if ( is_int( $value ) && $other === $value ) {
				$filtered[] = $item;
			} elseif ( 0 === strcasecmp( $other, $value ) ) {
				$filtered[] = $item;
			} elseif ( $other === $value ) {
				$filtered[] = $item;
			}
		}

		return $filtered;
	}
}
