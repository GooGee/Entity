<?php

namespace GooGee\Entity;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EntityController extends Controller
{
    const Entity = 'entity.json';

    private function send($data, $message = 'OK', $status = 200)
    {
        return response()->json([
            'version' => '2.1',
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function load()
    {
        $data = '';
        if (\Storage::exists(self::Entity)) {
            $data = \Storage::get(self::Entity);
        }
        return $this->send($data);
    }

    public function save(Request $request)
    {
        \Storage::put(self::Entity, $request['project']);
        return $this->send('');
    }

    public function deploy(Request $request)
    {
        foreach ($request['files'] as $file => $code) {
            $path = base_path($file);
            $info = pathinfo($path);
            if (!is_dir($info['dirname'])) {
                mkdir($info['dirname'], 0755, true);
            }
            file_put_contents($path, $code);
        }
        return $this->send('');
    }

    public function table()
    {
        $connection = config('database.default');
        $path = "database.connections.{$connection}";
        $driver = config("{$path}.driver");
        $database = config("{$path}.database");
        $prefix = config("{$path}.prefix");
        $tables = [];
        if ($driver == 'mysql') {
            $tables = $this->getMySQLTable($database);
        }
        if ($driver == 'pgsql') {
            $tables = $this->getPGSQLTable();
        }
        $data = [
            'driver' => $driver,
            'database' => $database,
            'prefix' => $prefix,
            'tables' => $tables,
        ];
        return $this->send($data);
    }

    private function getMySQLTable(string $database)
    {
        $tables = [];
        $column = "Tables_in_{$database}";
        $list = \DB::select('SHOW TABLES;');
        foreach ($list as $item) {
            $name = $item->$column;
            $tables[] = [
                'name' => $name,
                'fields' => \DB::select("SHOW COLUMNS FROM {$name};"),
                'indexes' => \DB::select("SHOW INDEX FROM {$name};"),
            ];
        }
        return $tables;
    }

    private function getPGSQLTable()
    {
        $tables = [];
        $list = \DB::select("SELECT * FROM information_schema.tables WHERE table_schema = 'public';");
        foreach ($list as $item) {
            $name = $item->table_name;
            $tables[] = [
                'name' => $name,
                'fields' => \DB::select("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '{$name}';"),
                'indexes' => \DB::select("SELECT * FROM pg_indexes WHERE tablename = '{$name}';"),
            ];
        }
        return $tables;
    }

}