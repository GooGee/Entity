<?php

namespace GooGee\Entity\Generator;


class Form
{
    public $fileName;
    public $filePath;
    public $method;
    public $instance;
    public $fieldList;

    function __construct($entity)
    {
        $form = $entity->form;
        $this->fileName = $form->name . '.html';
        $this->filePath = base_path($form->path . DIRECTORY_SEPARATOR) . $this->fileName;

        $this->method = $form->method;
        $this->instance = $form->instance;
        $this->fieldList = $form->field->list;
    }

    public function save()
    {
        $form = $this;
        $view = view('template::form', compact('form'));

        $file = new File($this->filePath);
        $file->save($view->render());
    }

}