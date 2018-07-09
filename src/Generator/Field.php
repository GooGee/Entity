<?php

namespace GooGee\Entity\Generator;


class Field
{
    public $text;

    function __construct($field)
    {
        $name = $field->name;
        $type = $field->type;

        $length = '';
        if (in_array($type, ['char', 'string', 'float', 'double', 'decimal'])) {
            if (empty($field->length)) {
                //
            } else {
                $length = ", {$field->length}";
            }
        }

        if (empty($field->nullable)) {
            $nullable = '';
        } else {
            $nullable = '->nullable()';
        }

        $default = '';
        if (isset($field->value)) {
            if (is_numeric($field->value)) {
                $default = "->default({$field->value})";
            } else if ($field->value) {
                $value = trim($field->value, '\'"');
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