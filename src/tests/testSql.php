<?php

use TaskForce\models\DatasetConverter;
use TaskForce\exceptions\FileExistException;
use TaskForce\exceptions\TableExistException;
use TaskForce\db\Table;

$fileNameCities = 'data/cities.csv';
$directoryCities = 'data/cities.sql';
$fileNameCategories = 'data/categories.csv';
$directoryCategories = 'data/categories.sql';

$tableCities = [
    'cities',
    'city_name',
    'city_latitude',
    'city_longitude'
];
$tableCategories = [
    'categories',
    'category_name',
    'icon'
];

$fileTableCities = new Table($tableCities);
$fileTableCategories = new Table($tableCategories);

$sql = new DatasetConverter($fileNameCities, $directoryCities, $fileTableCities);

try {
    $sqlFile = $sql->createSqlFile();
} catch (FileExistException $e) {
    echo $e->getMessage() . '<br>' . '<br>';
} catch (TableExistException $e) {
    echo $e->getMessage() . '<br>' . '<br>';
};

$sql = new DatasetConverter($fileNameCategories, $directoryCategories, $fileTableCategories);

try {
    $sqlFile = $sql->createSqlFile();
} catch (FileExistException $e) {
    echo $e->getMessage() . '<br>' . '<br>';
} catch (TableExistException $e) {
    echo $e->getMessage() . '<br>' . '<br>';
};
