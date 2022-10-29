<?php

namespace app\models\helpers;

class FormatDataHelper
{
    //https://vitalik.ws/zametki/78-nazvanie-mesyaca-data-na-russkom-yazyke-s-pomoshyu-php.html
    /**
     * Функция форматирования даты в формат: ХХ месяца ХХХХ, 00:00 
     * Взято здесь: //https://vitalik.ws/zametki/78-nazvanie-mesyaca-data-na-russkom-yazyke-s-pomoshyu-php.html
     * и доработано в соответствии с требованиями проекта
     * @param  $data - форматируемая дата
     *
     * @return string - дата в формате: ХХ месяца ХХХХ, 00:00
     */
    public static function formatData($data = null): ?string
    {
        if (null === $data) {
            return null;
        }

        $data = strtotime($data);

        //список месяцев с названиями для замены
        $_monthsList = array(
            ".01." => "января", ".02." => "февраля",
            ".03." => "марта", ".04." => "апреля", ".05." => "мая", ".06." => "июня",
            ".07." => "июля", ".08." => "августа", ".09." => "сентября",
            ".10." => "октября", ".11." => "ноября", ".12." => "декабря"
        );

        //текущая дата
        $date = date("d.m.Y", $data);
        $time = date("H:i", $data);
        //переменная $date теперь хранит текущую дату в формате 22.07.2015

        //но так как наша задача - вывод русской даты, 
        //заменяем число месяца на название:
        $_mD = date(".m.", $data); //для замены

        //теперь в переменной $date хранится дата в формате 22 июня 2015
        $date = str_replace($_mD, " " . $_monthsList[$_mD] . " ", $date);

        $dateWithTime = $date . ', ' . $time;

        return $dateWithTime;
    }

    /**
     * Функция форматирования телефонного номера 
     * Взято здесь: https://snipp.ru/php/phone-format#link-format-1
     * 
     * @param  string $phone - номер телефона в формате "8хххххххххх"
     *
     * @return string $res - номер телефона в формате "+7 (xxx) xxx-xx-xx"
     */
    public static function formatPhone($phone = null): ?string
    {
        if (null === $phone) {
            return null;
        }

        $phone = trim($phone);

        $result = preg_replace(
            array(
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',
            ),
            array(
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4-$5',
                '+7 ($2) $3-$4',
                '+7 ($2) $3-$4',
            ),
            $phone
        );
        return $result;
    }
}
