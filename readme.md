# Yandex Maps Components #
==========================

## Components ##

`YandexMaps\Api`

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

 Next in controller add your maps to it:
```php
Yii::app()->yandexMapsApi->maps['demo'] = $map;
```

Finally need render scrips, proposed in controller after render view:
```php
Yii::app()->yandexMapsApi->render();
```

`YandexMaps\Map`

Map instance.

__Usage__

```php
$map = new Map('demo', array(
		'center' => 'js:[ymaps.geolocation.latitude, ymaps.geolocation.longitude]',
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

`YandexMaps\Canvas`

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