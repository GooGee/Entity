<?php

namespace GooGee\Entity;

class PostgreSQL extends DataBase
{

    protected function getSchema(string $database)
    {
        $tables = [];
        $list = \DB::select("SELECT * FROM information_schema.tables WHERE table_schema = 'public';");
        foreach ($list as $item) {
            $tables[] = $this->getTable($item->table_name);
        }
        return $tables;
    }

    protected function getTable(string $name)
    {
        $table = [
            'name' => $name,
            'fields' => \DB::select("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '{$name}';"),
            'indexes' => \DB::select("SELECT * FROM pg_indexes WHERE tablename = '{$name}';"),
        ];
        return $table;
    }

}