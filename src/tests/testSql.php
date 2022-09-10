<?php

use TaskForce\models\CsvToSqlConverter;
use TaskForce\exceptions\FileExistException;

$csvFilesDirectory = 'data';
$sqlFilesDirectory = 'data';
$fileExtension = 'csv';

try {
    $csvFilesPaths = getFilesPaths($csvFilesDirectory, $fileExtension);
    try {
        $sql = new CsvToSqlConverter($csvFilesPaths, $sqlFilesDirectory);
        $sqlFile = $sql->createSqlFile();
    } catch (FileExistException $e) {
        echo $e->getMessage() . '<br>' . '<br>';
    };
} catch (FileExistException $e) {
    echo $e->getMessage() . '<br>' . '<br>';
}
