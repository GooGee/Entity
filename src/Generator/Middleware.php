<?php

namespace GooGee\Entity\Generator;


class Middleware
{
    public $text;

    function __construct($middleware)
    {
        $name = $middleware->name;
        $type = $middleware->type;

        $array = [];
        foreach ($middleware->method as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $array[] = $key;
                }
            }
        }
        if (empty($array)) {
            $type = 'all';
        }
        if ('all' == $type) {
            $this->text = "\$this->middleware('{$name}');";
            return;
        }

        $string = $this->array2string($array);
        $this->text = "\$this->middleware('{$name}')->{$type}([$string]);";
    }

    function array2string($array)
    {
        $arr = [];
        foreach ($array as $value) {
            $arr[] = $value;
        }
        $string = implode("', '", $arr);
        return "'{$string}'";
    }

}