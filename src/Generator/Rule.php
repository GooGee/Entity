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
            switch ($key) {
                case 'between':
                    $array[] = 'between:' . $value;
                    break;
                case 'regex':
                    $array[] = 'regex:' . $value;
                    break;
                default :
                    if ($value) {
                        $array[] = $key;
                    }
            }
        }

        if (empty($array)) {
            $this->empty = true;
            return;
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