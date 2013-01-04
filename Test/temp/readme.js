var points = {
    'cimislia': [46.523667899172416, 28.775354613281237],
    'hincesti': [46.83368868485617, 28.59408019921875],
    'hincesti_yaloveni': [46.91091424381294, 28.692957152343745],
    'yaloveni': [46.95794812435353, 28.769861449218745],
    'codru': [46.98943757030572, 28.782221068359377],
    'chisinau': [47.015742793379644, 28.84127258203123],

    'stavceni': [47.08801496011808, 28.859125365234377],
    'stavceni_cricova': [47.11333381323732, 28.85775207421873],
    'cricova': [47.14613651785698, 28.833032835937495],

    'straseni': [47.14894723106607, 28.61605285546874],
    'cojusna': [47.09551810558289, 28.69982360742186],
    'vatra': [47.077696398335306, 28.72454284570312]
};

var colors = {
    maroon : '#98202d',
    red : '#ff0000',
    blue :  '#0000E2',
    yellow : '#ffff00',
    green : '#95d340'
};

var ymaps = {};

var roads = {
        straseni_vatra: [points.straseni, points.cojusna, points.vatra],
        stavceni_cricova: [points.stavceni, points.stavceni_cricova, points.cricova],
        chisinau_cimislia: [
            points.chisinau,
            points.codru,
            points.yaloveni,
            points.hincesti_yaloveni
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

marks.each(function (item) {
    var name = item.properties.get('hintContent');
    item.properties.set('iconContent', name);
    if (item.properties.get('hintContent') == 'Дьячий') {
        item.properties.set('iconContent', 'Я');
    }
});

//window.yaMaps.myMap.behaviors
//	.disable(['drag', 'rightMouseButtonMagnifier']);