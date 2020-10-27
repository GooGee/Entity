<?php

namespace GooGee\Entity;

class MySQL extends DataBase
{

    protected function getSchema(string $database)
    {
        $tables = [];
        $column = "Tables_in_{$database}";
        $list = \DB::select('SHOW TABLES;');
        foreach ($list as $item) {
            $tables[] = $this->getTable($item->$column);
        }
        return $tables;
    }

    protected function getTable(string $name)
    {
        $table = [
            'name' => $name,
            'fields' => \DB::select("SHOW COLUMNS FROM {$name};"),
            'indexes' => \DB::select("SHOW INDEX FROM {$name};"),
        ];
        return $table;
    }

}