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

}