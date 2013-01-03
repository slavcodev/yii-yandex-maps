<?php
/**
 * \YandexMaps\Code class file.
 */

namespace YandexMaps;

use Exception,
	CJavaScript as JS;

/**
 *
 */
abstract class Code
{
	/**
	 * @return string
	 */
	public function __toString()
	{
		try {
			return $this->toString();
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * @return string
	 */
	abstract public function toString();
}