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

	/** @var array */
	private $_objects = array();

	/**
	 * @param mixed $key
	 * @param mixed $object
	 * @return $this
	 */
	public function addObject($object, $key = null)
	{
		if (null === $key) {
			$this->_objects[] = $object;
		} else {
			$this->_objects[$key] = $object;
		}
		return $this;
	}

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

		foreach ($this->_objects as $id => $object) {
			$class = get_class($object);
			$generator = 'generate' . substr($class, strrpos($class, '\\') + 1);
			if (method_exists($this, $generator)) {
				$var = is_numeric($id) ? null : $id;
				$js .= $this->$generator($object, $var)."\n";
			} else {
				$js .= JS::encode($object)."\n";
			}
		}

		$js.= "});\n";

		$cs = Yii::app()->clientScript;
		$cs->registerScript(self::SCRIPT_ID, $js, ClientScript::POS_END);
	}

	public function generateMap(Map $map, $var = null)
	{
		$id = $map->id;
		$state = JS::encode($map->state);
		$options = JS::encode($map->options);

		$js = "new ymaps.Map('$id', $state, $options)";
		if (null !== $var) {
			$js = "var $var = $js;\n";

			if (count($map->objects) > 0) {
				foreach ($map->objects as $object) {
					if ($object instanceof Placemark) {
						$object = $this->generatePlacemark($object);
					}
					$js .= "$id.geoObjects.add($object);";
				}
			}
		}

		return $js;
	}

	public function generatePlacemark(Placemark $object, $var = null)
	{
		$geometry = JS::encode($object->geometry);
		$properties = JS::encode($object->properties);
		$options = JS::encode($object->options);

		$js = "new ymaps.Placemark($geometry, $properties, $options)";
		if (null !== $var) {
			$js = "var $var = $js;\n";
		}

		return $js;
	}
}