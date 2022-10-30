<?php

namespace app\models\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use GuzzleHttp\Client;
use TaskForce\exceptions\GeocoderException;

class GeocoderHelper
{
    const GEOCODER_RESPONSE_OK = 200;
    const GEOCODER_BASE_URL = 'https://geocode-maps.yandex.ru/';
    const GEOCODER_COORDINATE_KEY = 'response.GeoObjectCollection.featureMember.0.GeoObject.Point.pos';
    const GEOCODER_CITY_KEY = 'response.GeoObjectCollection.featureMember.0.GeoObject.description';
    const GEOCODER_ADDRESS_KEY = 'response.GeoObjectCollection.featureMember.0.GeoObject.name';
    const GEOCODER_LONGITUDE_KEY = 0;
    const GEOCODER_LATITUDE_KEY = 1;

    public string $apiKey;
    public string $baseUri;

    private static function requestGeocoder(string $location): object
    {
        $client = new Client([
            'base_uri' => self::GEOCODER_BASE_URL,
        ]);

        $query = [
            'apikey' => Yii::$app->params['geocoderKey'],
            'geocode' => $location,
            'format' => 'json',
        ];
        return $client->request('GET', '1.x', ['query' => $query]);
    }

    public static function getCoordinates(string $location): array
    {
        $response = self::requestGeocoder($location);

        if ($response->getStatusCode() !== self::GEOCODER_RESPONSE_OK) {
            throw new GeocoderException('Ошибка запроса геоданных');
        }

        $body = $response->getBody();

        $responseResult = json_decode($body);

        $coordinates = ArrayHelper::getValue($responseResult, self::GEOCODER_COORDINATE_KEY);

        return explode(' ', $coordinates);
    }

    public static function getAdress(float $longitude, float $latitude): array
    {
        $location = $longitude . ',' . $latitude;

        $response = self::requestGeocoder($location);;

        if ($response->getStatusCode() !== self::GEOCODER_RESPONSE_OK) {
            throw new GeocoderException('Ошибка запроса геоданных');
        }

        $body = $response->getBody();

        $responseResult = json_decode($body);

        return ['city' => ArrayHelper::getValue($responseResult, self::GEOCODER_CITY_KEY), 'adress' => ArrayHelper::getValue($responseResult, self::GEOCODER_ADDRESS_KEY)];
    }
}
