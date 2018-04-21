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

        $default = '';
        if (isset($field->default)) {
            if (is_numeric($field->default)) {
                $default = "->default({$field->default})";
            } else if ($field->default) {
                $value = trim($field->default, '\'"');
                $default = "->default('{$value}')";
            }
        }

        if (empty($field->comment)) {
            $comment = '';
        } else {
            $comment = "->comment('{$field->comment}')";
        }

        $this->text = "\$table->{$type}('{$name}'{$length}){$nullable}{$default}{$comment};";
    }

}