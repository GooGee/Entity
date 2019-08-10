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

    function __construct($table, $path)
    {
        $controller = $table->controller;
        $this->name = $controller->name;
        $this->fileName = $this->name . '.php';
        $this->filePath = $path . DIRECTORY_SEPARATOR . $this->fileName;
        $this->nameSpace = $controller->nameSpace;
        $this->model = $table->model;
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

    public function text()
    {
        $controller = $this;
        $model = $this->model;
        $view = view('template::controller', compact('controller', 'model'));

        return "<?php\n" . $view->render();
    }

}