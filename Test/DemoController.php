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
			'center' => 'js:[ymaps.geolocation.latitude, ymaps.geolocation.longitude]',
			'zoom' => 10,
			'behaviors' => array(
				Map::BEHAVIOR_DEFAULT,
				// Map::BEHAVIOR_SCROLL_ZOOM
			),
			'type' => "yandex#map",
		), array(
			'minZoom' => 9,
			'maxZoom' => 11,
			'controls' => array(
				Map::CONTROL_MAP_TOOLS,
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
		$vatra = new Placemark(array(47.077696398335306, 28.72454284570312), array(), array(
			'iconImageHref' => Yii::app()->baseUrl . '/images/road-point-red.png',
			'iconImageSize' => array(16, 16),
			'iconImageOffset' => 8,
		));
		$map->addObject($vatra);

		// Polyline example
		$stavceniToCricova = new Polyline(array(
			array(47.08801496011808, 28.859125365234377),
			array(47.11333381323732, 28.85775207421873),
			array(47.14613651785698, 28.833032835937495),
		), array(
			'balloonContentHeader' => 'js:ymaps.geolocation.country',
			'balloonContent' => 'Дорога: Страшень - Крикова',
			//'balloonContentFooter' => 'js:ymaps.geolocation.region',
			//'balloonContentBody' => 'Балун оисание',
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