<?php

namespace GooGee\Entity;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EntityController extends Controller
{
    const EntityPath = 'entity/';

    protected $json = [
        'code' => 0,
        'text' => 'ok',
        'data' => null,
    ];

    function index()
    {
        $fileList = \Storage::files(self::EntityPath);
        foreach ($fileList as $key => $file) {
            $fileList[$key] = str_replace('entity/', '', $file);
        }

        return view('entity::project', compact('fileList'));
    }

    function load(Request $request)
    {
        $this->json['data'] = null;
        $file = self::EntityPath . $request['file'];
        $this->json['data'] = \Storage::get($file);
        return response()->json($this->json);
    }

    function store(Request $request)
    {
        $file = self::EntityPath . $request['file'];
        \Storage::put($file, $request['project']);
        return response()->json($this->json);
    }


    function table(Request $request)
    {
        $json = $request['entry'];
        $entry = json_decode($json);
        $mmm = new Generator\Migration($entry);
        $mmm->save();

        return response()->json($this->json);
    }

    function model(Request $request)
    {
        $json = $request['entry'];
        $entry = json_decode($json);
        $model = new Generator\Model($entry);
        $model->save();

        return response()->json($this->json);
    }

    function factory(Request $request)
    {
        $json = $request['entry'];
        $entry = json_decode($json);
        $factory = new Generator\Factory($entry);
        $factory->save();

        return response()->json($this->json);
    }

    function controller(Request $request)
    {
        $json = $request['entry'];
        $entry = json_decode($json);
        $ccc = new Generator\Controller($entry);
        $ccc->save();

        return response()->json($this->json);
    }

    function form(Request $request)
    {
        $json = $request['entry'];
        $entry = json_decode($json);
        $form = new Generator\Form($entry);
        $form->save();

        return response()->json($this->json);
    }

}