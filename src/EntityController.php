<?php

namespace GooGee\Entity;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EntityController extends Controller
{
    const Version = '2.3';

    private function send($data, $message = 'OK', $status = 200)
    {
        return response()->json([
            'version' => self::Version,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function load()
    {
        return FileService::load();
    }

    public function save(Request $request)
    {
        try {
            FileService::save($request['project']);
        } catch (\Exception $exception) {
            return $this->send('', $exception->getMessage(), 422);
        }
        return $this->send('');
    }

    public function deploy(Request $request)
    {
        try {
            FileService::deploy($request['files']);
        } catch (\Exception $exception) {
            return $this->send('', $exception->getMessage(), 422);
        }
        return $this->send('');
    }

    public function table(MySQL $mySQL, PostgreSQL $postgreSQL)
    {
        try {
            $data = DataBase::getDB($mySQL, $postgreSQL);
        } catch (\Exception $exception) {
            return $this->send('', $exception->getMessage(), 422);
        }
        return $this->send($data);
    }

}
