<?php

namespace GooGee\Entity\Generator;


class Migration
{

    public $className;
    public $fileName;
    public $filePath;
    public $tableName;
    public $fieldList;
    public $indexList;

    function __construct($table, $path)
    {
        $this->tableName = $table->name;
        $this->className = "Create{$table->model->name}Table";
        $this->fileName = '0000_00_00_000000_create_' . $table->name . '_table.php';
        $this->filePath = $path . DIRECTORY_SEPARATOR . $this->fileName;

        $this->fieldList = [];
        foreach ($table->field->list as $field) {
            $this->fieldList[] = new Field($field);
        }

        $this->indexList = [];
        foreach ($table->index->list as $index) {
            $this->indexList[] = new Index($index);
        }
    }

    public function text()
    {
        $migration = $this;
        $view = view('template::migration', compact('migration'));

        return "<?php \n" . $view->render();
    }

}