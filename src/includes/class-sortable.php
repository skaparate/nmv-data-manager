<?php
/**
 * Includes the sortable class.
 *
 * @package Nicomv/Data_Manager/Includes
 */

namespace Nicomv\Data_Manager\Includes;

use InvalidArgumentException;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * A simple DTO to hold the sorting parameters.
 *
 * @version 1.0.0
 */
final class Sortable {
	/**
	 * The property that's used to sort the results.
	 *
	 * @var string
	 */
	private $sort_by;

	/**
	 * The direction of the sort.
	 *
	 * @var string
	 */
	private $direction;

	/**
	 * Builds an instance of this class.
	 *
	 * @param string $sort_by The property used to sort the data.
	 * @param string $direction The direction to do the sorting.
	 *
	 * @throws InvalidArgumentException If the direction is provided but is different to
	 * asc or desc (case-insensitive).
	 */
	public function __construct( string $sort_by = '', string $direction = null ) {
		$tmp_dir = '';

		if ( is_null( $direction ) || empty( $direction ) ) {
			$tmp_dir = 'asc';
		} else {
			$tmp_dir = strtolower( sanitize_text_field( $direction ) );
			if ( $tmp_dir && (
			'desc' !== $tmp_dir &&
			'asc' !== $tmp_dir ) ) {
				throw new InvalidArgumentException(
					'The direction must either be null, asc or desc; current: ' . $tmp_dir
				);
			}
		}
		$this->sort_by   = sanitize_text_field( $sort_by );
		$this->direction = $tmp_dir;
	}

	/**
	 * Property getter for:
	 *
	 * <ul>
	 *  <li>sort_by</li>
	 *  <li>direction</li>
	 * </ul>
	 *
	 * @param string $name The property name to read.
	 * @throws InvalidArgumentException If the property doesn't exist.
	 */
	public function __get( string $name ) {
		if ( 'sort_by' === $name ) {
			return $this->sort_by;
		}

		if ( 'direction' === $name ) {
			return $this->direction;
		}

		if ( 'is_ascending' === $name ) {
			return 'asc' === $this->direction;
		}

		if ( 'is_descending' === $name ) {
			return 'desc' === $this->direction;
		}

		throw new InvalidArgumentException( "The property '$name' does not exist" );
	}

	/**
	 * Builds a sortable object from the GET params.
	 *
	 * @return Sortable A sortable instance.
	 */
	public static function from_get_request(): Sortable {
		$sortby    = '';
		$direction = '';

		/*
		 * Disabled nonce verification since the $_GET params should
		 * not be a security issue here.
		 */
		// phpcs:disable WordPress.Security.NonceVerification
		if ( isset( $_GET['sort_by'] ) ) {
			$sortby = $_GET['sort_by'];
		}
		if ( isset( $_GET['sort_dir'] ) ) {
			$direction = $_GET['sort_dir'];
		}

		return new Sortable( $sortby, $direction );
	}

	/**
	 * Overrides the default toString method.
	 */
	public function __toString() {
		return "Sortable { sort_by: '$this->sort_by', direction: '$this->direction' }";
	}
}
