<?php
/**
 * \YandexMaps\Canvas class file.
 */

namespace YandexMaps;

use Yii,
	CException as Exception,
	CWidget as Widget,
	CHtml as Html;

/**
 * @property Api $api
 * @property Map $map
 */
class Canvas extends Widget
{
	/** @var string */
	public static $componentId = 'yandexMapsApi';

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
	 * @return Api
	 */
	public function getApi()
	{
		return Yii::app()->getComponent(self::$componentId);
	}

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
		$this->api->addObject($map, $map->id);
	}

	/**
	 * Run widget.
	 */
	public function run()
	{
		parent::run();
		$this->htmlOptions['id'] = $this->map->id;
		echo Html::tag($this->tagName, $this->htmlOptions, '');
		$this->onAfterRender(new \CEvent($this));
	}

	/**
	 * @param \CEvent $event
	 */
	public function onAfterRender(\CEvent $event)
	{
		$this->raiseEvent('onAfterRender', $event);
	}
}