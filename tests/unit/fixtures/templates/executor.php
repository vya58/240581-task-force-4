<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'executor_name' => $faker->name,
    'executor_email' => $faker->email,
    'executor_password' => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    'executor_date_add' => $faker->dateTimeThisYear,
    'city_id' => $faker->numberBetween(1, 1000),
];
