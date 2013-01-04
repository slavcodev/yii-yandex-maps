<?php
/**
 * \YandexMaps\Polyline class file.
 */

namespace YandexMaps;

use CException as Exception,
	CComponent as Component;

/**
 * @property string $geometry
 */
class Polyline extends Component
{
	/** @var array */
	public $properties = array();
	/** @var array */
	public $options = array();

	/** @var array */
	private $_geometry;

	/**
	 * @param array $geometry
	 * @param array $properties
	 * @param array $options
	 */
	public function __construct(array $geometry, array $properties = array(), array $options = array())
	{
		$this->_geometry = $geometry;
		$this->properties = $properties;
		$this->options = $options;
	}

	/**
	 * Clone object.
	 */
	function __clone()
	{
	}

	/**
	 * @return array
	 * @throws Exception
	 */
	public function getGeometry()
	{
		if (empty($this->_geometry)) {
			throw new Exception('Empty placemark geometry.');
		}
		return $this->_geometry;
	}

	/**
	 * @param array $geometry
	 */
	public function setGeometry(array $geometry)
	{
		$this->_geometry = $geometry;
	}
}