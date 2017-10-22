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

    function __construct($entity)
    {
        $table = $entity->table;
        $this->tableName = $table->name;
        $this->className = "Create{$entity->model->name}Table";
        $this->fileName = date('Y_m_d') . '_000000_create_' . $table->name . '_table.php';
        $this->filePath = base_path($table->path . DIRECTORY_SEPARATOR) . $this->fileName;

        $this->fieldList = [];
        foreach ($table->field->list as $field) {
            $this->fieldList[] = new Field($field);
        }

        $this->indexList = [];
        foreach ($table->index->list as $index) {
            $this->indexList[] = new Index($index);
        }
    }

    public function save()
    {
        $data = $this;
        $view = view('template::migration', compact('data'));

        $file = new File($this->filePath);
        $file->save("<?php \n" . $view->render());
    }

}