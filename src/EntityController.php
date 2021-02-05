<?php

namespace GooGee\Entity;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EntityController extends Controller
{
    const Version = '2.4';

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
        return $this->send(FileService::load());
    }

    public function save(Request $request)
    {
        try {
            FileService::save($request['project']);
            return $this->send('');
        } catch (\Exception $exception) {
            return $this->send('', $exception->getMessage(), 422);
        }
    }

    public function deploy(Request $request)
    {
        try {
            FileService::deploy($request['files']);
            return $this->send('');
        } catch (\Exception $exception) {
            return $this->send('', $exception->getMessage(), 422);
        }
    }

    public function run(Request $request, CommandService $service)
    {
        try {
            $command = $request->input('command');
            $result = $service->run($command);
            return $this->send($result);
        } catch (\Exception $exception) {
            return $this->send('', $exception->getMessage(), 422);
        }
    }

    public function table(MySQL $mySQL, PostgreSQL $postgreSQL)
    {
        try {
            $data = DataBase::getDB($mySQL, $postgreSQL);
            return $this->send($data);
        } catch (\Exception $exception) {
            return $this->send('', $exception->getMessage(), 422);
        }
    }

}
