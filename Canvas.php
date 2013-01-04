<?php
/**
 * \YandexMaps\Canvas class file.
 */

namespace YandexMaps;

use CException as Exception,
	CWidget as Widget,
	CHtml as Html;

/**
 * @property Map $map
 */
class Canvas extends Widget
{
	/** @var string */
	public $tagName = 'div';
	/** @var array */
	public $htmlOptions = array(
		'class' => 'yandex-map',
		'style' => 'height: 100%; width: 100%;',
	);

	/** @var Map */
	private $_map;

	/**
	 * @return Map
	 * @throws Exception
	 */
	public function getMap()
	{
		if (null === $this->_map) {
			throw new Exception('Orphan map canvas.');
		}
		return $this->_map;
	}

	/**
	 * @param Map $map
	 */
	public function setMap(Map $map)
	{
		$this->_map = $map;
	}

	/**
	 * Run widget.
	 */
	public function run()
	{
		$this->htmlOptions['id'] = $this->map->id;
		echo Html::tag($this->tagName, $this->htmlOptions, '');
	}
}