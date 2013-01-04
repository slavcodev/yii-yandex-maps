<?php
/**
 * \YandexMaps\Api class file.
 */

namespace YandexMaps;

use Yii,
	CApplicationComponent as Component,
	CClientScript as ClientScript,
	CJavaScript as JS;

/**
 * Yandex Maps API component.
 *
 *
 */
class Api extends Component
{
	const SCRIPT_ID = 'yandex.maps.api';

	/** @var string */
	public $protocol = 'http';
	/** @var string */
	public $language = 'ru-RU';
	/** @var array */
	public $packages = array('package.full');

	/** @var Map[] */
	public $maps = array();

	/**
	 * Render client scripts.
	 */
	public function render()
	{
		$this->registerScriptFile();
		$this->registerScript();
	}

	/**
	 * @todo Add another API params
	 * @see http://api.yandex.ru/maps/doc/jsapi/2.x/dg/concepts/load.xml
	 */
	protected function registerScriptFile()
	{
		if ('https' !== $this->protocol) {
			$this->protocol = 'http';
		}

		if (is_array($this->packages)) {
			$this->packages = implode(',', $this->packages);
		}

		$url = $this->protocol . '://api-maps.yandex.ru/2.0-stable'
			.'/?lang=' . $this->language
			. '&load=' . $this->packages;

		$cs = Yii::app()->clientScript;
		$cs->registerScriptFile($url, ClientScript::POS_END);
	}

	/**
	 * Register client script.
	 */
	protected function registerScript()
	{
		$js = "ymaps.ready(function() {\n";

		// Maps
		foreach ($this->maps as $map) {
			$js .= $this->renderMap($map);
		}

		$js.= "});\n";

		$cs = Yii::app()->clientScript;
		$cs->registerScript(self::SCRIPT_ID, $js, ClientScript::POS_END);
	}

	public function renderMap(Map $map)
	{
		$id = $map->id;
		$state = JS::encode($map->state);
		$options = JS::encode($map->options);

		return "var $id = new ymaps.Map('$id', $state, $options);\n";
	}
}