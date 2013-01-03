
var myPolyLine = new ymaps.Polyline(
	[
		colonita,
		me,
		[46.992,28.792],
		[46.97064014550847,28.762994994140605],
		[46.95371677728384,28.762994994140605],
		[46.94243153908385,28.706690062499998],
		[46.90950258515595,28.68334411523436]
	],
	{
		balloonContentHeader: ymaps.geolocation.country,
		balloonContent: ymaps.geolocation.city,
		balloonContentFooter: ymaps.geolocation.region,
		balloonContentBody: 'В студёную зимнюю пору',
		hintContent: 'Зимние происшествия'
	},
	{
		geodesic: true,
		strokeWidth: 10,
		strokeColor: '#0000E2',
		//strokeOpacity: .5,
	}
);
//window.yaMaps.myMap.geoObjects.add(myPolyLine);

// Прокладывание маршрута от станции метро "Смоленская"
// до станции Третьяковская (маршрут должен проходить через метро "Арбатская").
// Точки маршрута можно задавать 3 способами:  как строка, как объект или как массив геокоординат.
ymaps.route([
	me,
	[46.99178678083139,28.792177428222654]
], {
	// Опции маршрутизатора
	mapStateAutoApply: true // автоматически позиционировать карту
}).then(function (route) {
		window.yaMaps.myMap.geoObjects.add(route);
	}, function (error) {
		alert("Возникла ошибка: " + error.message);
	});



var colonita = [47.042973749548615,28.91268371484374];
window.yaMarks.c = new ymaps.Placemark(me, {
 balloonContentHeader: ymaps.geolocation.country,
 balloonContent: ymaps.geolocation.city,
 balloonContentFooter: ymaps.geolocation.region,
 balloonContentBody: 'В студёную зимнюю пору',
 hintContent: 'Зимние происшествия'
 }, {
 iconImageHref: "<?php echo Yii::app()->baseUrl . '/images/road-point-blue.png'; ?>",
 iconImageSize: [20, 20],
 iconImageOffset: [-10, -10]
 });

//window.yaMaps.myMap.geoObjects.add(window.yaMarks.c);
//window.yaMarks.minsk.balloon.open();

myMap.events.add('click', function (e) {
 var coords = e.get('coordPosition');
 var eMap = e.get('target');// Получение ссылки на объект, сгенерировавший событие (карта).

 window.yaMarks.c1 = new ymaps.Placemark(coords);
 window.yaMaps.myMap.geoObjects.add(window.yaMarks.c1);
 alert(coords);
 });

marks.each(function (item) {
    var name = item.properties.get('hintContent');
    item.properties.set('iconContent', name);
    if (item.properties.get('hintContent') == 'Дьячий') {
        item.properties.set('iconContent', 'Я');
    }
});

// Определяем границы карты: координаты левого верхнего и правого нижнего ее углов.
var bounds = myMap.getBounds();


//window.yaMaps.myMap.behaviors
//	.disable(['drag', 'rightMouseButtonMagnifier']);