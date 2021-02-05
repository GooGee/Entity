<?php

namespace GooGee\Entity;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EntityController extends Controller
{
    const Version = '2.4';
    const Site = 'https://googee.github.io';

    private function send($data, $message = 'OK', $status = 200)
    {
        $this->cors();
        return response()->json([
            'version' => self::Version,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }

    private function cors()
    {
        header('Access-Control-Allow-Origin: ' . self::Site);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
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
