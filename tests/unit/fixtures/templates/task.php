<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'customer_id' => $faker->numberBetween(1, 10),
    'category_id' => $faker->numberBetween(1, 8),
    'city_id' => $faker->numberBetween(1, 1000),
    'task_name' => $faker->sentence(4),
    'task_essence' => $faker->sentences(1, true),
    'task_details' => $faker->paragraphs(1, true),
    'task_status' => $faker->numberBetween(0, 1),
    'task_date_create' => $faker->dateTimeThisYear
];
