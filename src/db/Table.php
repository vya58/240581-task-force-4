<?php

namespace TaskForce\db;

use TaskForce\exceptions\TableExistException;

class Table

{
    private string $tableName;
    private array $tableColums;

    public function __construct(array $table)
    {
        if (!isset($table)) {
            throw new TableExistException('Такой таблицы не существует');
        }

        $this->tableName = array_shift($table);

        if (!isset($this->tableName)) {
            throw new TableExistException('Отсутствует имя таблицы');
        }

        $this->tableColums = $table;

        if (!isset($this->tableName)) {
            throw new TableExistException('Отсутствуют имена столбцов таблицы');
        }
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getColumnNames(): array
    {
        return $this->tableColums;
    }
}
