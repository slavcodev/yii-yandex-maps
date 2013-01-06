<?php
/**
 * \YandexMaps\Polyline class file.
 */

namespace YandexMaps;

/**
 * Polyline
 */
class Polyline extends GeoObject
{
	public function __construct(array $geometry, array $properties = array(), array $options = array())
	{
		$geometry = array(
			'type' => "LineString",
			'coordinates' => $geometry,
		);
		parent::__construct($geometry, $properties, $options);
	}
}