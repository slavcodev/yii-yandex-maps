# Yandex Maps Components #

* * *

## Components ##

- [`YandexMaps\Api`](https://github.com/slavcodev/yii-yandex-maps#yandexmapsapi)
- [`YandexMaps\Map`](https://github.com/slavcodev/yii-yandex-maps#yandexmapsmap)
- [`YandexMaps\Canvas`](https://github.com/slavcodev/yii-yandex-maps#yandexmapscanvas)
- `YandexMaps\JavaScript`
- `YandexMaps\Placemark`
- `YandexMaps\Polyline`
- TODO: [Geo XML](http://api.yandex.ru/maps/doc/jsapi/2.x/dg/concepts/geoxml.xml)
- TODO: [GeoObject](http://api.yandex.ru/maps/doc/jsapi/2.x-stable/ref/reference/GeoObject.xml)
- TODO: [Balloon](http://api.yandex.ru/maps/doc/jsapi/2.x-stable/ref/reference/Balloon.xml)
- TODO: [Hint](http://api.yandex.ru/maps/doc/jsapi/2.x-stable/ref/reference/Hint.xml)

### YandexMaps\Api ###

Application components which register scripts.

__Usage__

Attach component to application (e.g. edit config/main.php):
```php
'components' => array(
	'yandexMapsApi' => array(
		'class' => '\YandexMaps\Api';
	)
 ),
```

Important! You need render script in controller after render view,
proposed in CController::afterRender():
```php
protected function afterRender($view, &$output)
{
	Yii::app()->yandexMapsApi->render();
	parent::afterRender($view, $output);
}
```

### YandexMaps\Map ###

Map instance.

__Usage__

```php
$map = new Map('demo', array(
		'center' => array('js:ymaps.geolocation.latitude', 'js:ymaps.geolocation.longitude'),
		'zoom' => 10,
		// Enable zoom with mouse scroll
		'behaviors' => array('default', 'scrollZoom'),
		'type' => "yandex#map",
	), array(
		// Permit zoom only fro 9 to 11
		'minZoom' => 9,
		'maxZoom' => 11,
	));
```

### YandexMaps\Canvas ###

This is widget which render html tag for your map.

__Usage__

Simple add widget to view:
```php

$this->widget('\YandexMaps\Canvas', array(
		'htmlOptions' => array(
			'style' => 'height: 400px;',
		),
		'map' => $map,
	));
```

*more example you can found in [Test](https://github.com/slavcodev/yii-yandex-maps/blob/master/Test) folder*