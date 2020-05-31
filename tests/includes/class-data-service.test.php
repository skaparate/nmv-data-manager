<?php
/**
 * Includes tests related to the data service.
 *
 * @package Nicomv/Data_Manager/Tests
 */

use Nicomv\Data_Manager\Includes\Data_Service;
use PHPUnit\Framework\TestCase;

/**
 * Tests the Data_Service class.
 */
class Data_Service_Test extends TestCase {

	/**
	 * The expected retrieved data.
	 *
	 * @var mixed
	 */
	private $expected_data;

	/**
	 * Setups the tests.
	 */
	public function setUp() {
		$this->expected_data = file_get_contents( NMV_TEST_ROOT . '/tests/data.json' );
		$svc                 = new Data_Service();
		delete_transient( $svc->cache_name );
	}

	/**
	 * Cleans after each test.
	 *
	 * @after
	 */
	public function runAfter() {
		$svc = new Data_Service();
		delete_transient( $svc->cache_name );
	}

	/**
	 * Test that the data is actually cached.
	 */
	public function test_data_is_cached() {
		$svc        = new Data_Service();
		$cache_name = $svc->cache_name;
		$svc->get_data();
		$this->assertNotNull( get_transient( $cache_name ), 'The data should be cached' );
	}

	/**
	 * Tests that the remote REST API is not contacted when
	 * there is cached data.
	 */
	public function test_no_unneeded_requests() {
		$svc        = new Data_Service();
		$cache_name = $svc->cache_name;

		// First, cache the test data.
		$test_data = 'it is the cached data';
		$this->assertTrue( set_transient( $cache_name, $test_data, 30 ) );

		// Check the data to make sure it's not the same.
		// (If it were the same, the data would have been retrieved from the API).
		$data = $svc->get_data();
		$this->assertNotEquals( $this->expected_data, $data );
	}

	/**
	 * Test that we receive the expected data.
	 */
	public function test_is_expected_data() {
		$svc             = new Data_Service();
		$non_cached_data = $svc->get_data();
		$this->assertEquals( $this->expected_data, $non_cached_data );

		$transient_data = get_transient( $svc->cache_name );
		$cached_data    = $svc->get_data();

		// Check that the read data is the same.
		$this->assertEquals( $transient_data, $cached_data );

		// Check that the received data is the same as the cached one.
		$this->assertEquals( $non_cached_data, $cached_data );
	}
}
