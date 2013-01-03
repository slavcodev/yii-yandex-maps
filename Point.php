<?php
/**
 * \YandexMaps\Point class file.
 */

namespace YandexMaps;

use Exception,
	CJavaScript as JS;

/**
 *
 */
class Point extends Code
{
	/**
	 * @var array
	 */
	private $_point = array();

	/**
	 * @param float $latitude
	 * @param float $longitude
	 */
	public function __construct($latitude, $longitude)
	{
		$this->_point[0] = (float) $latitude;
		$this->_point[1] = (float) $longitude;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		return JS::encode($this->_point);
	}
}