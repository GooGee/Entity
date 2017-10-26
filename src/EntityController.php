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

    function publish()
    {
        $cssFolder = __DIR__ . '/Scaffold/css';
        $jsFolder = __DIR__ . '/Scaffold/js';
        $publicFolder = __DIR__ . '/Scaffold/public';
        copy($cssFolder . '/entity.css', $publicFolder . '/entity.css');

        //$fileArray=['array.js', 'check.js', 'dialogue.js', 'entity.js', 'net.js', 'string.js'];
        $fileArray = scandir($jsFolder);
        $stringArray = [];
        foreach ($fileArray as $file) {
            if ('.' == $file or '..' == $file) {
                continue;
            }
            echo $file . '<br>';
            $stringArray[] = file_get_contents($jsFolder . DIRECTORY_SEPARATOR . $file);
        }
        $content = implode("\n", $stringArray);
        file_put_contents($publicFolder . '/entity.js', $content);

        copy($publicFolder . '/entity.css', public_path('css/entity.css'));
        copy($publicFolder . '/entity.js', public_path('js/entity.js'));

        return redirect('entity');
    }


    function table(Request $request)
    {
        $json = $request['entity'];
        $entity = json_decode($json);
        $mmm = new Generator\Migration($entity);
        $mmm->save();

        return response()->json($this->json);
    }

    function model(Request $request)
    {
        $json = $request['entity'];
        $entity = json_decode($json);
        $model = new Generator\Model($entity);
        $model->save();

        return response()->json($this->json);
    }

    function factory(Request $request)
    {
        $json = $request['entity'];
        $entity = json_decode($json);
        $factory = new Generator\Factory($entity);
        $factory->save();

        return response()->json($this->json);
    }

    function controller(Request $request)
    {
        $json = $request['entity'];
        $entity = json_decode($json);
        $ccc = new Generator\Controller($entity);
        $ccc->save();

        return response()->json($this->json);
    }

    function form(Request $request)
    {
        $json = $request['entity'];
        $entity = json_decode($json);
        $form = new Generator\Form($entity);
        $form->save();

        return response()->json($this->json);
    }

}