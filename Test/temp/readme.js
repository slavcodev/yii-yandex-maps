$yellowUrl = Yii::app()->baseUrl . '/images/road-point-yellow.png';
$maroonUrl = Yii::app()->baseUrl . '/images/road-point-maroon.png';
$redUrl = Yii::app()->baseUrl . '/images/road-point-red.png';
$points = (string) new PointCollection(array(
    'cimislia' => new Point(46.523667899172416, 28.775354613281237),
    'hincesti' => new Point(46.83368868485617, 28.59408019921875),
    'hincesti_yaloveni' => new Point(46.91091424381294, 28.692957152343745),
    'yaloveni' => new Point(46.95794812435353, 28.769861449218745),
    'codru' => new Point(46.98943757030572, 28.782221068359377),
    'chisinau' => new Point(47.015742793379644, 28.84127258203123),

    'stavceni' => new Point(47.08801496011808, 28.859125365234377),
    'stavceni_cricova' => new Point(47.11333381323732, 28.85775207421873),
    'cricova' => new Point(47.14613651785698, 28.833032835937495),

    'straseni' => new Point(47.14894723106607, 28.61605285546874),
    'cojusna' => new Point(47.09551810558289, 28.69982360742186),
    'vatra' => new Point(47.077696398335306, 28.72454284570312),
));


var colors = {
    maroon : '#98202d',
    red : '#ff0000',
    blue :  '#0000E2',
    yellow : '#ffff00',
    green : '#95d340'
};
var points = $points,
    roads = {
        straseni_vatra: [points.straseni, points.cojusna, points.vatra],
        stavceni_cricova: [points.stavceni, points.stavceni_cricova, points.cricova],
        chisinau_cimislia: [
            points.chisinau,
            points.codru,
            points.yaloveni,
            points.hincesti_yaloveni,
            //points.hincesti,
            //points.cimislia
        ]
    },
    radius = 16,
    shift = radius/2,
    size = [radius, radius],
    offset = [-shift, -shift],
    marksOptions = {
        //preset: 'twirl#cafeIcon', // все метки коллекции с пиктограммой "кафе"
        //cursor: 'grab', // курсор на метках будет "рукой"
        draggable: true // метки можно будет перемещать
    },
    marks = new ymaps.GeoObjectCollection({}, marksOptions).add(
            new ymaps.Placemark(points.cojusna, {}, {
                iconImageHref: "$yellowUrl",
                iconImageSize: size,
                iconImageOffset: offset
            })).add(
            new ymaps.Placemark(points.stavceni_cricova, {}, {
                iconImageHref: "$redUrl",
                iconImageSize: size,
                iconImageOffset: offset
            })).add(
            new ymaps.Placemark(points.codru, {}, {
                iconImageHref: "$maroonUrl",
                iconImageSize: size,
                iconImageOffset: offset
            })),
    lines = new ymaps.GeoObjectCollection().add(
            new ymaps.Polyline(roads.straseni_vatra, {}, {
                    strokeWidth: shift,
                    strokeColor: colors.yellow
                }
            )).add(
            new ymaps.Polyline(roads.stavceni_cricova, {}, {
                    strokeWidth: shift,
                    strokeColor: colors.red
                }
            )).add(
            new ymaps.Polyline(roads.chisinau_cimislia, {}, {
                    strokeWidth: shift,
                    strokeColor: colors.maroon
                }
            ));

myMap.geoObjects.add(marks);
myMap.geoObjects.add(lines);

var myButton = new ymaps.control.Button('Добавить ...');

myButton.events
    .add('click', function () { alert('Щёлк'); })
    .add('select', function () { alert('Нажата'); })
    .add('deselect', function () { alert('Отжата'); });

myMap.controls
    // .add("zoomControl", {left: '5px', top: '5px'})
    .add("smallZoomControl", {left: '5px', top: '5px'})
    // .add("mapTools")
    .add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid"]), { left: '35px', top: '5px' })
    // .add(new ymaps.control.SearchControl({ provider: 'yandex#map' }), {left: '5px', top: '5px'})
    .add(myButton, { right: '5px', top: '5px' });

myMap.events.add('dblclick', function (e) {
    e.preventDefault(); // При двойном щелчке зума не будет.
});

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