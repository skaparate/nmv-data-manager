<?php
/**
 * Includes a class for sorting items.
 *
 * @package Nicomv/Data_Manager/Includes
 */

namespace Nicomv\Data_Manager\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Sorts items using the provided sorter.
 *
 * @version 1.0.0
 */
final class Sorter {
	/**
	 * Sorts the data using the provided Sortable.
	 *
	 * @param Sortable $sortable The object containing the sort information.
	 * @param array    $data The data being sorted.
	 * @return array The sorted array.
	 */
	public static function sort_data( Sortable $sortable, array $data ): array {
		$sortby = $sortable->sort_by;
		if ( empty( $sortby ) ) {
			return $data;
		}
		error_log( 'DATA_MANAGER, Sorter - Sorting by: ' . $sortby );
		error_log( 'DATA_MANAGER, Sorter - Sorting direction: ' . $sortable->direction );
		$comparer = new Comparer( $sortable );
		usort(
			$data,
			array( $comparer, 'compare' )
		);

		return $data;
	}
}
