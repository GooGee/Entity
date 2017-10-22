<?php

namespace GooGee\Entity\Generator;


class Field
{
    public $text;

    function __construct($field)
    {
        $name = $field->name;
        $type = $field->type;

        if (empty($field->length)) {
            $length = '';
        } else {
            $length = ", {$field->length}";
        }

        if (empty($field->nullable)) {
            $nullable = '';
        } else {
            $nullable = '->nullable()';
        }

        $default = $this->getDefault($field);

        if (empty($field->comment)) {
            $comment = '';
        } else {
            $comment = "->comment('{$field->comment}')";
        }

        $this->text = "\$table->{$type}('{$name}'{$length}){$nullable}{$default}{$comment};";
    }

    function getDefault($field)
    {
        if (empty($field->default)) {

        } else {
            return "->default('{$field->default}')";
        }

//        $list = ['decimal', 'double', 'float'];
//        if (in_array($field->type, $list)) {
//            return "->default(0)";
//        }
//        if (preg_match('/integer$/i', $field->type)) {
//            return "->default(0)";
//        }
//
//        if ('string' == $field->type) {
//            return "->default('')";
//        }
//        if (preg_match('/text/i', $field->type)) {
//            return "->default('')";
//        }

        return '';
    }

}