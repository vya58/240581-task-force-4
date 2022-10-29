// Функция ymaps.ready() будет вызвана, когда
// загрузятся все компоненты API, а также когда будет готово DOM-дерево.

const yandexMap = document.querySelector('#map');
const taskName = document.querySelector('.head-main');

ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map", {
        center: [yandexMap.dataset.latitude, yandexMap.dataset.longitude],
        zoom: 16
    }, {
        searchControlProvider: 'yandex#search'
    }),
        // Создаем геообъект с типом геометрии "Точка".
        myGeoObject = new ymaps.GeoObject({
            // Описание геометрии.
            geometry: {
                type: "Point",
                coordinates: [yandexMap.dataset.latitude, yandexMap.dataset.longitude]
            },
            // Свойства.
            properties: {
                // Контент метки.
                iconContent: taskName.dataset.name,
                hintContent: 'Адрес выполнения задания',
            }
        }, {
            // Опции.
            // Иконка метки будет растягиваться под размер ее содержимого.
            preset: 'islands#redStretchyIcon',
            // Метку нельзя перемещать.
            draggable: false
        });

    myMap.geoObjects.add(myGeoObject);
}
