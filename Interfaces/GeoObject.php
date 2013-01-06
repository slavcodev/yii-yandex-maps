<?php
/**
 * \YandexMaps\Interfaces\GeoObject class file.
 */

namespace YandexMaps\Interfaces;

/**
 * GeoObject interface.
 */
interface GeoObject
{
	/**
	 * @param array $feature
	 * @param array $options
	 */
	public function __construct(array $feature, array $options = array());

	/**
	 * @return array
	 */
	public function getFeature();

	/**
	 * @param array $feature
	 */
	public function setFeature(array $feature);

	/**
	 * @return array
	 */
	public function getOptions();

	/**
	 * @param array $options
	 */
	public function setOptions(array $options);
}