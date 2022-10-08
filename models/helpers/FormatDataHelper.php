<?php

namespace app\models\helpers;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $category_id
 * @property string $category_name
 * @property string $icon
 *
 * @property ExecutorCategory[] $executorCategories
 * @property Executor[] $executors
 * @property Task[] $tasks
 * @property Category[] $allCategories
 * @property Category[] $categories
 */
class FormatDataHelper
{
    /**
     * Функция вычисления возраста, имея дату рождения
     * https://alexandrnikolaev.ru/blog/kak-na-php-vychislit-vozrast-po-date-rozhdenija/
     * @param  $birthday - день рождения
     *
     * @return int $age - возраст
     */
    public static function calculateAge($birthday = null)
    {
        if (!$birthday) {
            return 0;
        }
        $birthday_timestamp = strtotime($birthday);
        $age = date('Y') - date('Y', $birthday_timestamp);
        if (date('md', $birthday_timestamp) > date('md')) {
            $age--;
        }
        //echo "Возраст: " . $age;
        return $age;
    }


    /*Рейтинг пользователя считается по формуле:

   сумма всех оценок из отзывов / (кол-во отзывов + счетчик проваленных заданий)

   */
    /**
     * Функция вычисления рейтинга пользователя
     * считается по формуле:
     * сумма всех оценок из отзывов / (кол-во отзывов + счетчик проваленных заданий);
     * @param  $countGrade - сумма всех оценок из отзывов
     * @param  $countReview - кол-во отзывов
     * @param  $countFail - счетчик проваленных заданий
     *
     * @return int - рейтинг пользователя
     */
    public static function calculateRating($sumGrade, $countGrade, $countFail)
    {
        if(!$sumGrade) {
            return 0;
        }
        return $sumGrade / ($countGrade + $countFail);
    }


    //https://vitalik.ws/zametki/78-nazvanie-mesyaca-data-na-russkom-yazyke-s-pomoshyu-php.html
    /**
     * Функция форматирования даты в формат: ХХ месяца ХХХХ, 00:00 
     * Взято здесь: //https://vitalik.ws/zametki/78-nazvanie-mesyaca-data-na-russkom-yazyke-s-pomoshyu-php.html
     * и доработано в соответствии с требованиями проекта
     * @param  $data - форматируемая дата
     *
     * @return string - дата в формате: ХХ месяца ХХХХ, 00:00
     */
    public static function formatData($data)
    {
        if (!$data) {
            return $data;
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
    public static function formatPhone($phone)
    {
        $phone = trim($phone);

        $res = preg_replace(
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

        return $res;
    }
}
