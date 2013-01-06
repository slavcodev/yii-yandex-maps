<?php
/**
 * \YandexMaps\GeoObject class file.
 */

namespace YandexMaps;

use CException as Exception;

/**
 * @property array $geometry
 * @property array $properties
 * @property array $options
 */
class GeoObject extends JavaScript
{
	/** @var array */
	private $_geometry;
	/** @var array */
	private $_properties = array();
	/** @var array */
	public $_options = array();

	/**
	 * @param array $geometry
	 * @param array $properties
	 * @param array $options
	 */
	public function __construct(array $geometry, array $properties = array(), array $options = array())
	{
		$this->setGeometry($geometry);
		$this->setProperties($properties);
		$this->setOptions($options);
	}

	/**
	 * @param string $code
	 * @throws Exception
	 */
	final public function setCode($code)
	{
		throw new Exception('Cannot change code directly.');
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

	/**
	 * @return array
	 */
	public function getOptions()
	{
		return $this->_options;
	}

	/**
	 * @param array $options
	 */
	public function setOptions(array $options)
	{
		$this->_options = $options;
	}

	/**
	 * @return array
	 */
	public function getProperties()
	{
		return $this->_properties;
	}

	/**
	 * @param array $properties
	 */
	public function setProperties(array $properties)
	{
		$this->_properties = $properties;
	}
}