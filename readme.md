# Yandex Maps Components #

* * *

## Components ##
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