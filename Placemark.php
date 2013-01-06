<?php
/**
 * \YandexMaps\Placemark class file.
 */

namespace YandexMaps;

/**
 * Placemark
 */
class Placemark extends GeoObject
{
	/**
	 * @param array $geometry
	 * @param array $properties
	 * @param array $options
	 */
	public function __construct(array $geometry, array $properties = array(), array $options = array())
	{
		$geometry = array(
			'type' => "Point",
			'coordinates' => $geometry,
		);
		parent::__construct($geometry, $properties, $options);
	}
}