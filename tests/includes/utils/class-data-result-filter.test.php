<?php
/**
 * Tests for the Data Result Filter.
 *
 * @package Nicomv/Data_Manager/Tests
 */

use Nicomv\Data_Manager\Includes\Data_Result;
use Nicomv\Data_Manager\Includes\Utils\Data_Result_Filter;
use PHPUnit\Framework\TestCase;

/**
 * Tests the data result filter class.
 */
class Data_Result_Filter_Test extends TestCase {

	/**
	 * The data result object.
	 *
	 * @var Data_Result
	 */
	private $data;

	/**
	 * @before
	 */
	public function beforeEach() {
		$sample     = array(
			array(
				'id'    => 1,
				'fname' => 'Lisa',
				'lname' => 'Simpson',
				'email' => 'smartgirl63@yahoo.com',
			),
			array(
				'id'    => 2,
				'fname' => 'Homer',
				'lname' => 'Simpson',
				'email' => 'chunkylover53@aol.com',
			),
			array(
				'id'    => 3,
				'fname' => 'Ned',
				'lname' => 'Flanders',
				'email' => 'neddy@yahoo.com',
			),
			array(
				'id'    => 4,
				'fname' => 'Todd',
				'lname' => 'Flanders',
				'email' => 'tod.flanders@yahoo.com',
			),
		);
		$this->data = new Data_Result( 'test header', array(), $sample );
	}

	/**
	 * Tests that the array can be filtered by id.
	 */
	public function test_can_filter_by_id() {
		$_GET['search'] = 3;
		$expected       = array(
			array(
				'id'    => 3,
				'fname' => 'Ned',
				'lname' => 'Flanders',
				'email' => 'neddy@yahoo.com',
			),
		);
		$data           = Data_Result_Filter::filter_data( $this->data );
		$this->assertEquals( $expected, $data->content );
	}

	/**
	 * Tests that the data can be filtered using the first name.
	 */
	public function test_can_filter_by_first_name() {
		$_GET['search'] = 'todd';
		$expected       = array(
			array(
				'id'    => 4,
				'fname' => 'Todd',
				'lname' => 'Flanders',
				'email' => 'tod.flanders@yahoo.com',
			),
		);
		$data           = Data_Result_Filter::filter_data( $this->data );
		$this->assertEquals( $expected, $data->content );
	}

	/**
	 * Tests that the data can be filtered using the last name.
	 */
	public function test_can_filter_by_last_name() {
		$_GET['search'] = 'simpson';
		$expected       = array(
			array(
				'id'    => 1,
				'fname' => 'Lisa',
				'lname' => 'Simpson',
				'email' => 'smartgirl63@yahoo.com',
			),
			array(
				'id'    => 2,
				'fname' => 'Homer',
				'lname' => 'Simpson',
				'email' => 'chunkylover53@aol.com',
			),
		);
		$data           = Data_Result_Filter::filter_data( $this->data );
		$this->assertEquals( $expected, $data->content );
	}

	/**
	 * Test that an advanced search by id works.
	 */
	public function test_can_filter_advanced_id() {
		$_GET['search'] = 'id:4';
		$expected       = array(
			array(
				'id'    => 4,
				'fname' => 'Todd',
				'lname' => 'Flanders',
				'email' => 'tod.flanders@yahoo.com',
			),
		);
		$data           = Data_Result_Filter::filter_data( $this->data );
		$this->assertEquals( $expected, $data->content );
	}

	/**
	 * Test that an advanced search by first name works.
	 */
	public function test_can_filter_advanced_fname() {
		$_GET['search'] = 'fname:lisa';
		$expected       = array(
			array(
				'id'    => 1,
				'fname' => 'Lisa',
				'lname' => 'Simpson',
				'email' => 'smartgirl63@yahoo.com',
			),
		);
		$data           = Data_Result_Filter::filter_data( $this->data );
		$this->assertEquals( $expected, $data->content );
	}

	/**
	 * Test that an advanced search by last name works.
	 */
	public function test_can_filter_advanced_lname() {
		$_GET['search'] = 'lname:flanders';
		$expected       = array(
			array(
				'id'    => 3,
				'fname' => 'Ned',
				'lname' => 'Flanders',
				'email' => 'neddy@yahoo.com',
			),
			array(
				'id'    => 4,
				'fname' => 'Todd',
				'lname' => 'Flanders',
				'email' => 'tod.flanders@yahoo.com',
			),
		);
		$data           = Data_Result_Filter::filter_data( $this->data );
		$this->assertEquals( $expected, $data->content );
	}
}
