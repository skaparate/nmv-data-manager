<?php
/**
 * Includes the Comparer class.
 *
 * @package Nicomv/Data_Manager/Includes
 */

namespace Nicomv\Data_Manager\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * A simple class used to perform comparison between two values.
 *
 * @version 1.0.0
 */
class Comparer {
	/**
	 * The sorting object.
	 *
	 * @var Sortable
	 */
	private $sortable;

	/**
	 * Builds an instance of this class.
	 *
	 * @param Sortable $sortable The sorting information that will define how
	 * the objects will be sorted.
	 */
	public function __construct( Sortable $sortable ) {
		$this->sortable = $sortable;
	}

	/**
	 * Compares the two values, returning -1, 0 or 1 if the
	 * left value is less, equal or greater than the right value.
	 *
	 * If the Sortable->is_descending is true, then the comparisons
	 * are reversed.
	 *
	 * @param mixed $left The left value of the comparison.
	 * @param mixed $right The right value of the comparison.
	 * @return int -1, 0 or 1 if the left value is less, equal or
	 * greater than the right value.
	 */
	public function compare( $left, $right ): int {
		$sortable  = $this->sortable;
		$left_val  = $left[ $sortable->sort_by ];
		$right_val = $right[ $sortable->sort_by ];

		if ( is_string( $left_val ) && is_string( $right_val ) ) {
			return $this->compare_string( $left_val, $right_val );
		}

		return $this->compare_numeric( $left_val, $right_val );
	}

	/**
	 * Case insensitive comparison of two strings.
	 *
	 * @param string $left The left value.
	 * @param string $right The right value.
	 * @return int -1, 0 or 1, if the left value is less, equal or
	 * greater than the right value.
	 */
	private function compare_string( $left, $right ): int {
		if ( $this->sortable->is_ascending ) {
			return strcasecmp( $left, $right );
		}
		return strcasecmp( $right, $left );
	}

	/**
	 * Simple numeric comparison (and the default one).
	 *
	 * @param mixed $left The left value.
	 * @param mixed $right The right value of the comparison.
	 * @return -1, 0 or 1 if the left value is less, equal or
	 * greater than the right value.
	 */
	private function compare_numeric( $left, $right ) {
		if ( $this->sortable->is_ascending ) {
			return $left > $right ? 1 : ( $left < $right ? -1 : 0 );
		}
		return $right > $left ? 1 : ( $right < $left ? -1 : 0 );
	}
}
