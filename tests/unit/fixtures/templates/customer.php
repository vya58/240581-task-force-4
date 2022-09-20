<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'customer_name' => $faker->name,
    'customer_email' => $faker->email,
    'customer_password' => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    //'customer_avatar' => $faker->image,
    'customer_date_add' => $faker->dateTimeThisYear
];
