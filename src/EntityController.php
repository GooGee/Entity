<?php

namespace GooGee\Entity;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EntityController extends Controller
{
    const Version = '2.3';
    const Folder = 'entity';
    const File = 'entity.json';

    private function send($data, $message = 'OK', $status = 200)
    {
        return response()->json([
            'version' => self::Version,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }

    private function getJSON()
    {
        $data = '';
        if (\Storage::exists(self::File)) {
            $data = \Storage::get(self::File);
        }
        return $data;
    }

    public function load()
    {
        return $this->send($this->getJSON());
    }

    public function save(Request $request)
    {
        $data = $this->getJSON();
        if ($data !== $request['project']) {
            $path = self::Folder . '/' . Carbon::now() . '.json';
            $valid = str_replace(':', '_', $path);
            \Storage::put($valid, $data);
            \Storage::put(self::File, $request['project']);
        }
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
        try {
            if ($driver == 'mysql') {
                $tables = $this->getMySQLTable($database);
            }
            if ($driver == 'pgsql') {
                $tables = $this->getPGSQLTable();
            }
        } catch (\Exception $exception) {
            throw new HttpException(422, $exception->getMessage(), $exception);
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
