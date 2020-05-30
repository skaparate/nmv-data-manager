<?php
/**
 * Testing the library.
 *
 * @package Nicomv/Data_Manager/Tests
 */

use PHPUnit\Framework\TestCase;

/**
 * Tests that the setup is working.
 */
class Wordpress_Test extends TestCase {
	/**
	 * Tests transient functions to check that the setup is correct.
	 */
	public function test_a_wordpress_function() {
		$cache   = 'cache_name';
		$expires = 10;
		$data    = 'a simple test string';
		$this->assertTrue( set_transient( $cache, $data, $expires ) );

		// Test that the data is the same.
		$actual = get_transient( $cache );
		$this->assertEquals( $data, $actual, 'The expected value is not the same' );
	}
}
