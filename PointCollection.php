<?php
/**
 * \YandexMaps\PointCollection class file.
 */

namespace YandexMaps;

use Exception,
	CJavaScript as JS;

/**
 *
 */
class PointCollection extends Code
{
	/**
	 * @var array
	 */
	private $_points = array();

	/**
	 * @param array $points
	 */
	public function __construct(array $points = array())
	{
		foreach ($points as $i => $point) {
			$this->add($point, $i);
		}
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		$points = array();
		foreach ($this->_points as $i => $point) {
			$points[$i] = 'js:' . (string) $point;
		}
		return JS::encode($points);
	}

	/**
	 * @param Point $point
	 * @param null $index
	 */
	public function add(Point $point, $index = null)
	{
		if (null === $index) {
			$this->_points[] = $point;
		} else {
			$this->_points[$index] = $point;
		}
		return $this;
	}
}