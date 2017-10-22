<?php

namespace GooGee\Entity\Generator;


class Middleware
{
    public $text;

    function __construct($middleware)
    {
        $name = $middleware->name;
        if (empty($middleware->method->list)) {
            $middleware->type = 'all';
        }
        if ('all' == $middleware->type) {
            $this->text = "\$this->middleware('{$name}');";
            return;
        }

        $type = $middleware->type;
        $array = $this->array2string($middleware->method->list);
        $this->text = "\$this->middleware('{$name}')->{$type}([$array]);";
    }

    function array2string($array)
    {
        $arr = [];
        foreach ($array as $value) {
            $arr[] = $value->name;
        }
        $string = implode("', '", $arr);
        return "'{$string}'";
    }

}