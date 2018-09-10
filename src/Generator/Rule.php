<?php

namespace GooGee\Entity\Generator;


class Rule
{
    public $empty;
    public $text;

    function __construct($field)
    {
        $array = [];
        foreach ($field->rule as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $array[] = $key;
                }
            } else {
                $array[] = $key . ':' . $value;
            }
        }

        $name = $field->name;
        $string = $this->array2string($array);
        $this->text = "'{$name}' => [{$string}],";
    }

    function array2string($array)
    {
        if (empty($array)) {
            return '';
        }

        $string = implode("', '", $array);
        return "'{$string}'";
    }

}