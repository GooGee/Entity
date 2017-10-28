<?php

namespace GooGee\Entity\Generator;


class Model
{
    public $name;
    public $fileName;
    public $filePath;
    public $nameSpace;
    public $table;
    public $primaryKey;
    public $timestamps;
    public $dates;
    public $fillable;
    public $hidden;
    public $relationList;
    public $ruleList;

    function __construct($entity)
    {
        $model = $entity->model;
        $this->name = $model->name;
        $this->fileName = $this->name . '.php';
        $this->filePath = $model->path;
        $this->nameSpace = $model->nameSpace;
        $this->table = $entity->table->name;
        $this->primaryKey = $model->primaryKey;

        $this->setTimeStamps($entity->table);
        $this->setDates($entity->table);

        $validation = $model->validation;
        $this->setFillable($validation);
        $this->setHidden($validation);
        $this->setRule($validation);

        $this->setRelation($model->relation->list);
    }

    function setTimeStamps($table)
    {
        $hasOne = false;
        $hasTwo = false;
        foreach ($table->field->list as $field) {
            if ($field->name == 'created_at') {
                $hasOne = true;
            }
            if ($field->name == 'updated_at') {
                $hasTwo = true;
            }
        }

        if ($hasOne and $hasTwo) {
            $this->timestamps = 'true';
        } else {
            $this->timestamps = 'false';
        }
    }

    function setDates($table)
    {
        $array = [];
        foreach ($table->field->list as $field) {
            if ($field->type == 'timestamp') {
                $array[] = $field->name;
            }
        }

        $this->dates = $this->array2string($array);
    }

    function setFillable($validation)
    {
        $array = [];
        foreach ($validation->list as $field) {
            if (isset($field->fillable)) {
                if ($field->fillable) {
                    $array[] = $field->name;
                }
            }
        }

        $this->fillable = $this->array2string($array);
    }

    function setHidden($validation)
    {
        $array = [];
        foreach ($validation->list as $field) {
            if (isset($field->hidden)) {
                if ($field->hidden) {
                    $array[] = $field->name;
                }
            }
        }

        $this->hidden = $this->array2string($array);
    }

    function setRule($validation)
    {
        $this->ruleList = [];
        foreach ($validation->list as $field) {
            $rule = new Rule($field);
            if ($rule->empty) {
                continue;
            }
            $this->ruleList[] = $rule;
        }
    }

    function setRelation($list)
    {
        $this->relationList = [];
        foreach ($list as $relation) {
            $this->relationList[] = new Relation($relation);
        }
    }

    function array2string($array)
    {
        if (empty($array)) {
            return '';
        }

        $string = implode("', '", $array);
        return "'{$string}'";
    }

    public function save()
    {
        $model = $this;
        $view = view('template::model', compact('model'));

        $file = new File($this->fileName, $this->filePath);
        $file->save("<?php \n" . $view->render());
    }

}