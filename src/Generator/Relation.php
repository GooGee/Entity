<?php

namespace GooGee\Entity\Generator;


class Relation
{
    public $name;
    public $text;

    function __construct($relation)
    {
        $this->name = $relation->name;

        if (!empty($relation->pivotTable)) {
            $array = [$relation->pivotTable];
            if (!empty($relation->foreignKey)) {
                $array[] = $relation->foreignKey;
            }
            if (!empty($relation->otherKey)) {
                $array[] = $relation->otherKey;
            }

            $string = $this->array2string($array);
            $this->text = "\$this->{$relation->type}({$relation->model}::class, {$string});";
            return;
        }

        if (!empty($relation->foreignKey)) {
            $this->text = "\$this->{$relation->type}({$relation->model}::class, '{$relation->foreignKey}');";
            return;
        }

        $this->text = "\$this->{$relation->type}({$relation->model}::class);";
    }

    function array2string($array)
    {
        $string = implode("', '", $array);
        return "'{$string}'";
    }

}