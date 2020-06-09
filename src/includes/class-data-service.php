<?php
/**
 * Includes the class in charge of requesting data.
 *
 * @package Nicomv/Data_Manager/Includes
 */

namespace Nicomv\Data_Manager\Includes;

use Exception;
use Requests_Exception;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class responsible for requesting the data from the endpoint.
 *
 * @version 1.0.0
 */
class Data_Service {
	/**
	 * The API where we will request the data from.
	 *
	 * @var string
	 */
	const APIURI = 'http://api.strategy11.com/wp-json/challenge/v1/1';

	/**
	 * The name of the cached item.
	 *
	 * @var string
	 */
	private $cache_name;

	/**
	 * How much time to maintain the cached data.
	 *
	 * @var int
	 */
	private $expires;

	/**
	 * Builds an instance of this class.
	 *
	 * @param int $expires How much time to retain the cached data. Default: 1 hour.
	 */
	public function __construct( $expires = 3600 ) {
		$this->cache_name = esc_url( self::APIURI );
		$this->expires    = is_int( $expires ) ? $expires : 3600;
	}

	/**
	 * Reads the data from the remote API.
	 *
	 * @throws Exception If the data cannot be cached.
	 * @throws Requests_Exception If the remote API cannot be reached.
	 * @return Data_Result The requested data.
	 */
	public function get_data(): Data_Result {
		$data = get_transient( $this->cache_name );

		if ( false === $data ) {
			$remote_data = wp_remote_get( self::APIURI );
			if ( is_wp_error( $remote_data ) ) {
				throw new Requests_Exception(
					'Failed to get data from the remote API',
					'get',
					$remote_data->get_error_messages(),
					$remote_data->get_error_code()
				);
			}

			$data = Data_Result::from_json( $remote_data['body'] );

			if ( false === set_transient( $this->cache_name, $data, $this->expires ) ) {
				throw new Exception( 'Could not cache the requested data' );
			}
		}

		return $data;
	}

	/**
	 * Magic method to retrieve class properties.
	 *
	 * @param string $name The name of the property to retrieve.
	 * @return mixed The value of the property or null if it
	 * doesn't exist.
	 */
	public function __get( string $name ) {
		if ( 'cache_name' === $name ) {
			return $this->cache_name;
		}
		return null;
	}
}
