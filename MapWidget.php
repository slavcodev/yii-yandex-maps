<?php
/**
 * \YandexMaps\MapWidget class file.
 */

namespace YandexMaps;

use Yii,
	CClientScript,
	CWidget,
	CHtml;

/**
 *
 */
class MapWidget extends CWidget
{
	const POS_BEGIN = 0;
	const POS_END = 1;

	private $_scripts = array(
		self::POS_BEGIN => '',
		self::POS_END => '',
	);

	public $state = array();
	public $options = array();

	public $htmlOptions = array(
		'style' => 'height: 100%; width: 100%;',
	);

	public function init()
	{
		parent::init();
		$this->htmlOptions['id'] = $this->id;
		echo CHtml::tag('div', $this->htmlOptions, '');
		echo CHtml::scriptFile('http://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru-RU');
	}

	public function run()
	{
		parent::run();
		echo CHtml::script($this->generateScript());
	}

	protected function generateScript()
	{
		return "var myMap, initMap = function() {\n"
			. $this->_scripts[self::POS_BEGIN]
			. $this->generateMap()
			. $this->_scripts[self::POS_END]
			. "};\n"
			. "ymaps.ready(initMap);\n";
	}

	protected function generateMap()
	{
		$js = "myMap = new ymaps.Map('{$this->id}', \n"
			. \CJavaScript::encode($this->state) . ",\n"
			. \CJavaScript::encode($this->options) .");\n";
		return $js;
	}

	public function registerScript($js, $pos = self::POS_BEGIN)
	{
		$this->_scripts[$pos] .= $js . "\n";
	}

	public function addPlacemark()
	{}
}