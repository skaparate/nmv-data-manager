<?php
/**
 * Includes a simple DTO to hold the result from the API.
 *
 * @package Nicomv/Data_Manager/Includes
 */

namespace Nicomv\Data_Manager\Includes;

use InvalidArgumentException;
use JsonSerializable;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * A DTO to hold the data retrieved from the API.
 *
 * @version 1.0.0
 */
class Data_Result implements JsonSerializable {
	/**
	 * The title of the table.
	 *
	 * @var string.
	 */
	private $title;

	/**
	 * The headers of the table.
	 *
	 * @var array
	 */
	private $headers = array();

	/**
	 * The actual results.
	 *
	 * @var array
	 */
	private $content = array();

	/**
	 * Private constructor.
	 *
	 * @param string $title The table title.
	 * @param array  $headers The table headers.
	 * @param array  $content The actual content.
	 */
	public function __construct( $title, $headers, $content ) {
		$this->title   = $title;
		$this->headers = $headers;
		$this->content = $content;
	}

	/**
	 * Parses the data to build a Data_Result object.
	 *
	 * @param string $data The JSON data.
	 * @return Data_Result The parsed object.
	 * @throws InvalidArgumentException If no data is provided.
	 */
	public static function from_json( string $data ): Data_Result {
		if ( ! $data ) {
			throw new InvalidArgumentException( 'No data provided' );
		}
		$json = json_decode( $data, true );
		$rows = array();

		foreach ( $json['data']['rows'] as $key => $val ) {
			$val['date'] = gmdate( 'c', $val['date'] );
			$rows[]      = $val;
		}

		return new Data_Result(
			$json['title'],
			$json['data']['headers'],
			$rows
		);
	}

	/**
	 * Wither method that changes the content of the object,
	 * maintaining the title and headers.
	 *
	 * @param array $content The new content.
	 */
	public function with_content( array $content ): Data_Result {
		return new Data_Result( $this->title, $this->headers, $content );
	}

	/**
	 * Magic method to retrieve the properties of the class: title, headers or content.
	 *
	 * @param string $name The property name.
	 * @throws InvalidArgumentException If the property doesn't exist.
	 */
	public function __get( string $name ) {
		switch ( $name ) {
			case 'title':
				return $this->title;
			case 'headers':
				return $this->headers;
			case 'content':
				return $this->content;
			default:
				throw new InvalidArgumentException( "Undefined property name '$name'" );
		}
	}

	/**
	 * Serializes this class data into JSON.
	 */
	public function jsonSerialize(): array {
		return array(
			'title'   => $this->title,
			'headers' => $this->headers,
			'content' => $this->content,
		);
	}

	/**
	 * A string representation of the contents of this instance.
	 */
	public function __toString() {
		$h = implode( ',', $this->headers );
		return "Data_Result: { title: '$this->title',"
			. " headers: '$h'"
			. ' }';
	}
}
