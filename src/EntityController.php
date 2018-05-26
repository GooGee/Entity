<?php

namespace GooGee\Entity;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EntityController extends Controller
{
    const FileName = 'entity.json';

    protected $json = [
        'code' => 0,
        'text' => 'ok',
    ];

    function index()
    {
        $project = null;
        if (\Storage::exists(self::FileName)) {
            $project = \Storage::get(self::FileName);
        }
        return view('entity::project', compact('project'));
    }

    function store(Request $request)
    {
        $project = $request['project'];
        \Storage::put('entity.json', $project);

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