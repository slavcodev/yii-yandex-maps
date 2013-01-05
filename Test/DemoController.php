<?php
/**
 * \YandexMaps\Test\DemoController class file.
 */

namespace YandexMaps\Test;

use YandexMaps\JavaScript;
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
			'center' => array(55.7595, 37.6249),
			'zoom' => 12,
			'behaviors' => array(
				Map::BEHAVIOR_DEFAULT,
				// Map::BEHAVIOR_SCROLL_ZOOM
			),
			'type' => "yandex#map",
		), array(
			'minZoom' => 9,
			'maxZoom' => 12,
			'controls' => array(
				Map::CONTROL_MAP_TOOLS,
				Map::CONTROL_SMALL_ZOOM,
			),
			'events' => array(
				'dblclick' => 'js:function (e) {e.preventDefault();}',
				// 'click' => 'js:function (e) {
				//	var coords = e.get("coordPosition");
				//	var eMap = e.get("target"); // Получение ссылки на объект, сгенерировавший событие (карта)
				//	eMap.geoObjects.add(new ymaps.Placemark(coords));
				//	// alert(coords);
				// }',
			),
		));

		// Global placemark
		$me = new Placemark(array('js:ymaps.geolocation.latitude', 'js:ymaps.geolocation.longitude'), array(
			'balloonContentHeader' => 'js:ymaps.geolocation.country',
			'balloonContent' => 'js:ymaps.geolocation.city',
			'balloonContentFooter' => 'js:ymaps.geolocation.region',
		), array(
			'iconImageHref' => Yii::app()->baseUrl . '/images/road-point-yellow.png',
			'iconImageSize' => array(16, 16),
			'iconImageOffset' => 8,
		));
		$this->api->addObject($me, 'me');
		$this->api->addObject($map, $map->id);
		$map->addObject('me');

		// Private placemark
		$vatra = new Placemark(array(55.7595, 37.6249), array(), array(
			'iconImageHref' => Yii::app()->baseUrl . '/images/road-point-red.png',
			'iconImageSize' => array(16, 16),
			'iconImageOffset' => 8,
		));
		$map->addObject($vatra);

		// Polyline example
		$stavceniToCricova = new Polyline(array(
			array(55.7852, 37.5661),
			array(55.7699, 37.5961),
			array(55.7595, 37.5844),
		), array(
			'balloonContentHeader' => 'js:"Вы в " + ymaps.geolocation.country',
			'balloonContent' => 'А это Ленинградский проспект',
			'hintContent' => 'Куку я всплывающая подсказка',
		), array(
			'geodesic' => true,
			'strokeWidth' => 8,
			'strokeColor' => '#98202d',
		));
		$map->addObject($stavceniToCricova);

		// Simple JS code example
		$alert = new JavaScript("var bounds = $map->id.getBounds();");
		$this->api->addObject($alert);
		// $this->api->addObject(new JavaScript("var accessor = $map->id.copyrights.add('&copy; My Copyright Text');"));
		// $this->api->addObject(new JavaScript("me.balloon.open();"));

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