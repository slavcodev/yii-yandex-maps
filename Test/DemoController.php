<?php
/**
 * \YandexMaps\Test\DemoController class file.
 */

namespace YandexMaps\Test;

use YandexMaps\Polyline;
use Yii,
	Controller;

use YandexMaps\Api,
	YandexMaps\Map,
	YandexMaps\Placemark;

/**
 * @property Api $api
 */
class DemoController extends Controller
{
	/** @var string */
	public static $componentId = 'yandexMapsApi';

	/**
	 * Default action.
	 */
	public function actionIndex()
	{
		$map = new Map('chisinau', array(
			'center' => 'js:[ymaps.geolocation.latitude, ymaps.geolocation.longitude]',
			'zoom' => 10,
			// Включим масштабирование карты колесом мыши
			// 'behaviors' => array('default', 'scrollZoom'),
			'type' => "yandex#map",
		), array(
			// В нашем примере хотспотные данные есть только от 9 до 11 масштаба.
			// Поэтому ограничим диапазон коэффициентов масштабирования карты.
			'minZoom' => 9,
			'maxZoom' => 11,
		));

		// Global placemark
		$me = new Placemark(array('js:ymaps.geolocation.latitude', 'js:ymaps.geolocation.longitude'), array(), array(
			'iconImageHref' => Yii::app()->baseUrl . '/images/road-point-yellow.png',
			'iconImageSize' => array(16, 16),
			'iconImageOffset' => 8,
		));
		$this->api->addObject($me, 'me');
		$map->addObject('me');

		// Private placemark
		$vatra = new Placemark(array(47.077696398335306, 28.72454284570312), array(), array(
			'iconImageHref' => Yii::app()->baseUrl . '/images/road-point-red.png',
			'iconImageSize' => array(16, 16),
			'iconImageOffset' => 8,
		));
		$map->addObject($vatra);

		$stavceniToCricova = new Polyline(array(
			array(47.08801496011808, 28.859125365234377),
			array(47.11333381323732, 28.85775207421873),
			array(47.14613651785698, 28.833032835937495),
		), array(), array(
			'strokeWidth' => 8,
			'strokeColor' => '#98202d',
		));
		$map->addObject($stavceniToCricova);

		$this->render('index', array(
				'map' => $map,
			));
	}

	/**
	 * @return Api
	 */
	public function getApi()
	{
		return Yii::app()->getComponent(self::$componentId);
	}

	public function getViewPath()
	{
		return __DIR__ . '/views';
	}

	protected function afterRender($view, &$output)
	{
		$this->api->render();
		parent::afterRender($view, $output);
	}
}