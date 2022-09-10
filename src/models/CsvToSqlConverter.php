<?php

namespace TaskForce\models;

use SplFileObject;
use TaskForce\exceptions\FileExistException;

class CsvToSqlConverter
{
    private array $csvFilesPaths;
    private string $sqlFilesDirectory;

    public function __construct(
        array $csvFilesPaths,
        string $sqlFilesDirectory
    ) {
        if (empty($csvFilesPaths)) {
            throw new FileExistException('Нет csv-файлов для конвертации');
        }

        $this->csvFilesPaths = $csvFilesPaths;
        $this->sqlFilesDirectory = $sqlFilesDirectory;
    }

    public function createSqlFile(): void
    {
        foreach ($this->csvFilesPaths as $csvFilePath) {
            $directoryInfo = pathinfo($csvFilePath);
            $sqlFileName = $directoryInfo['filename'];
            $sqlFilePath = "{$this->sqlFilesDirectory}/{$sqlFileName}.sql";
            $this->tableName = pathinfo($csvFilePath)['filename'];
           
            file_put_contents($sqlFilePath, implode($this->convertCsv($csvFilePath)));
        }
    }

    private function convertCsv(string $csvFilePath): array
    {
        $file = new SplFileObject($csvFilePath);
        $file->setFlags(SplFileObject::READ_CSV);

        $sql = [];

        foreach ($file as $line) {
            if (!in_array(null, $line) && 0 === $file->key()) {
                $tableColums = implode(', ', array_map(static fn (string $line) => "`{$line}`", $line,));
            }

            if (!in_array(null, $line) && 0 !== $file->key()) {
                $tableValues = implode("', '", $line);

                $sql[] = "INSERT INTO {$this->tableName} ({$tableColums}) VALUES ('{$tableValues}');";
            }
        }
        return $sql;
    }
}
