<?php

namespace GooGee\Entity;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

    public function table(MySQL $mySQL, PostgreSQL $postgreSQL)
    {
        $data = DataBase::getDB($mySQL, $postgreSQL);
        return $this->send($data);
    }

}
