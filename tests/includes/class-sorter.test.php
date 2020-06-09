<?php
/**
 * Includes tests for the Sorter class.
 *
 * @package Nicomv/Data_Manager/Tests
 */

use Nicomv\Data_Manager\Includes\Sortable;
use Nicomv\Data_Manager\Includes\Sorter;
use PHPUnit\Framework\TestCase;

/**
 * Tests the Sorter class.
 */
class Sorter_Test extends TestCase {
	/**
	 * The original, unsorted, data.
	 *
	 * @var array
	 */
	private $data;

	/**
	 * Sets up the tests.
	 */
	public function setUp() {
		$this->data = array(
			array(
				'id'   => 3,
				'name' => 'Lisa',
			),
			array(
				'id'   => 1,
				'name' => 'Maggie',
			),
			array(
				'id'   => 2,
				'name' => 'Homer',
			),
		);
	}
	/**
	 * Tests that the data is sorted by id in ascending order.
	 */
	public function test_sort_by_id_ascending() {
		$data     = $this->data;
		$expected = array(
			array(
				'id'   => 1,
				'name' => 'Maggie',
			),
			array(
				'id'   => 2,
				'name' => 'Homer',
			),
			array(
				'id'   => 3,
				'name' => 'Lisa',
			),
		);
		$sortable = new Sortable( 'id', 'asc' );
		$actual   = Sorter::sort_data( $sortable, $data );
		$this->assertEquals( $expected, $actual );
	}

	/**
	 * Tests that the data can be sorted by id in
	 * descending order.
	 */
	public function test_sort_by_id_descending() {
		$data     = $this->data;
		$expected = array(
			array(
				'id'   => 3,
				'name' => 'Lisa',
			),
			array(
				'id'   => 2,
				'name' => 'Homer',
			),
			array(
				'id'   => 1,
				'name' => 'Maggie',
			),
		);
		$sortable = new Sortable( 'id', 'desc' );
		$actual   = Sorter::sort_data( $sortable, $data );
		$this->assertEquals( $expected, $actual );
	}

	/**
	 * Tests that the data can be sorted in ascending order
	 * using the name as value.
	 */
	public function test_sort_by_name_ascending() {
		$data     = $this->data;
		$expected = array(
			array(
				'id'   => 2,
				'name' => 'Homer',
			),
			array(
				'id'   => 3,
				'name' => 'Lisa',
			),
			array(
				'id'   => 1,
				'name' => 'Maggie',
			),
		);
		$sortable = new Sortable( 'name', 'asc' );
		$actual   = Sorter::sort_data( $sortable, $data );
		$this->assertEquals( $expected, $actual );
	}

	/**
	 * Tests that the data can be sorted in descending order
	 * using the name as value.
	 */
	public function test_sort_by_name_descending() {
		$data     = $this->data;
		$expected = array(
			array(
				'id'   => 1,
				'name' => 'Maggie',
			),
			array(
				'id'   => 3,
				'name' => 'Lisa',
			),
			array(
				'id'   => 2,
				'name' => 'Homer',
			),

		);
		$sortable = new Sortable( 'name', 'desc' );
		$actual   = Sorter::sort_data( $sortable, $data );
		$this->assertEquals( $expected, $actual );
	}
}
