<?php
/**
 * \YandexMaps\Test\DemoController class file.
 */

namespace YandexMaps\Test;

use Yii,
	Controller;

use YandexMaps\Map,
	YandexMaps\Api,
	YandexMaps\Placemark;

/**
 * @property Api $api
 */
class DemoController extends Controller
{
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

		$this->render('index', array(
				'map' => $map,
			));
	}

	public function getApi()
	{
		return Yii::app()->getComponent('yandexMapsApi');
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