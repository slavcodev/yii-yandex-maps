<?php
/**
 * \YandexMaps\Interfaces\GeoObject class file.
 */

namespace YandexMaps\Interfaces;

/**
 * EventAggregate interface.
 */
interface EventAggregate
{
	/**
	 * @return array
	 */
	public function getEvents();
}