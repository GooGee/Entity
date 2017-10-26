<?php

namespace GooGee\Entity\Generator;


class Factory
{

    public $fileName;
    public $filePath;
    public $model;
    public $fieldList;

    function __construct($entity)
    {
        $factory = $entity->factory;
        $this->fileName = $factory->name . '.php';
        $this->filePath = base_path($factory->path . DIRECTORY_SEPARATOR) . $this->fileName;

        $this->model = $entity->model;
        $this->model = $entity->model;
        $this->fieldList = $factory->field->list;
    }

    public function save()
    {
        $factory = $this;
        $view = view('template::factory', compact('factory'));

        $file = new File($this->filePath);
        $file->save("<?php \n" . $view->render());
    }

}