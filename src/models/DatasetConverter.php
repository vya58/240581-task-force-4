<?php

namespace TaskForce\models;

use SplFileObject;
use TaskForce\db\Table;
use TaskForce\exceptions\FileExistException;
use TaskForce\exceptions\TableExistException;

class DatasetConverter
{
    private string $csv;
    private string $directory;
    private Table $table;
    private string $tableName;
    private array $tableColums;

    public function __construct(
        string $csv,
        string $directory,
        Table $table
    ) {
        if (!file_exists($csv)) {
            throw new FileExistException('Такого файла не существует');
        }

        if (!isset($table)) {
            throw new TableExistException('Такой таблицы не существует');
        }

        $this->csv = $csv;
        $this->directory = $directory;
        $this->table = $table;
        $this->tableName = $this->table->getTableName();
        $this->tableColums = $this->table->getColumnNames();
    }

    private function createHeader()
    {
        if (!isset($this->tableColums)) {
            throw new TableExistException('Отсутствуют имена столбцов таблицы');
        }
        $colums = implode(', ', $this->tableColums);
        return $colums;
    }

    public function createSqlFile(): void
    {
        file_put_contents($this->directory, implode($this->convertCsv()));
    }

    public function convertCsv(): array
    {
        $file = new SplFileObject($this->csv);
        $file->setFlags(SplFileObject::READ_CSV);
        $colums = $this->createHeader();
        $sql = [];

        foreach ($file as $line) {
            if (!in_array(null, $line) && 0 !== $file->key()) {
                $values = implode("', '", $line);

                $sql[] = "INSERT INTO {$this->tableName} ({$colums}) VALUES ('{$values}');";
            }
        }

        return $sql;
    }
}
