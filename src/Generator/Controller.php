<?php

namespace GooGee\Entity\Generator;


class Controller
{
    public $name;
    public $fileName;
    public $filePath;
    public $nameSpace;
    public $middlewareList;

    function __construct($entity)
    {
        $controller = $entity->controller;
        $this->name = $controller->name;
        $this->fileName = $this->name . '.php';
        $this->filePath = base_path($controller->path . DIRECTORY_SEPARATOR) . $this->fileName;
        $this->nameSpace = $controller->nameSpace;
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
        $view = view('template::controller', compact('controller'));

        $file = new File($this->filePath);
        $file->save("<?php \n" . $view->render());
    }

}