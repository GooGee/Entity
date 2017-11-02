<?php

namespace GooGee\Entity\Generator;


class Controller
{
    public $name;
    public $fileName;
    public $filePath;
    public $nameSpace;
    public $model;
    public $blade;
    public $middlewareList;

    function __construct($entity)
    {
        $controller = $entity->controller;
        $this->name = $controller->name;
        $this->fileName = $this->name . '.php';
        $this->filePath = $controller->path;
        $this->nameSpace = $controller->nameSpace;
        $this->model = $entity->model;
        $this->blade = $controller->blade;
        $this->getMiddleware($controller->middleware->list);
    }

    function getMiddleware($list)
    {
        $this->middlewareList = [];
        foreach ($list as $middleware) {
            $this->middlewareList[] = new Middleware($middleware);
        }
    }

    public function save()
    {
        $controller = $this;
        $model = $this->model;
        $view = view('template::controller', compact('controller', 'model'));

        $file = new File($this->fileName, $this->filePath);
        $file->save("<?php \n" . $view->render());
    }

}