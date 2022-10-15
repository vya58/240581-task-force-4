<?php

namespace app\models\helpers;

use Yii;

class CalculateHelper
{
    /**
     * Функция вычисления возраста, имея дату рождения
     * https://alexandrnikolaev.ru/blog/kak-na-php-vychislit-vozrast-po-date-rozhdenija/
     * @param  $birthday - день рождения
     *
     * @return int $age - возраст
     */
    public static function calculateAge($birthday = null): int
    {
        if (!$birthday) {
            return 0;
        }
        $birthday_timestamp = strtotime($birthday);
        $age = date('Y') - date('Y', $birthday_timestamp);
        if (date('md', $birthday_timestamp) > date('md')) {
            $age--;
        }
        
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
    public static function calculateRating($sumGrade, $countGrade, $countFail): float
    {
        if (!$sumGrade) {
            return 0;
        }
        return $sumGrade / ($countGrade + $countFail);
    }
}
