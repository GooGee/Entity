<?php

namespace GooGee\Entity\Generator;


class Form
{
    public $fileName;
    public $filePath;
    public $method;
    public $instance;
    public $fieldList;

    function __construct($table, $path)
    {
        $form = $table->form;
        $this->fileName = 'form.blade.php';
        $this->filePath = $path . DIRECTORY_SEPARATOR . $form->name . DIRECTORY_SEPARATOR . $this->fileName;

        $this->method = $form->method;
        $this->instance = $form->_instance;
        $this->fieldList = $form->field->list;
    }

    public function text()
    {
        $form = $this;
        $view = view('template::form', compact('form'));

        return "<?php\n" . $view->render();
    }

}