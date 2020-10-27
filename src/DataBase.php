<?php

namespace GooGee\Entity;

use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class DataBase
{

    abstract protected function getSchema(string $database);

    abstract protected function getTable(string $database);

    static function getDB(MySQL $mySQL, PostgreSQL $postgreSQL)
    {
        $connection = config('database.default');
        $path = "database.connections.{$connection}";
        $driver = config("{$path}.driver");
        $database = config("{$path}.database");
        $prefix = config("{$path}.prefix");
        $tables = [];
        if ($driver == 'mysql') {
            $tables = $mySQL->getSchema($database);
        }
        if ($driver == 'pgsql') {
            $tables = $postgreSQL->getSchema($database);
        }
        $data = [
            'driver' => $driver,
            'database' => $database,
            'prefix' => $prefix,
            'tables' => $tables,
        ];
        return $data;
    }
}