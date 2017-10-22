<?php

namespace GooGee\Entity\Generator;


class Index
{
    public $text;

    function __construct($index)
    {
        $name = $index->name;
        $type = $index->type;
        $array = $this->array2string($index->field->list);

        $this->text = "\$table->{$type}([{$array}], '{$name}');";
    }

    function array2string($array)
    {
        if (empty($array)) {
            return '';
        }

        $arr = [];
        foreach ($array as $value) {
            $arr[] = $value->name;
        }
        $string = implode("', '", $arr);
        return "'{$string}'";
    }

}