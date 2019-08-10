<?php

namespace GooGee\Entity\Generator;


class Field
{
    public $text;

    function __construct($field)
    {
        $name = $field->name;
        $type = $field->type;

        $length = $this->length($field);
        $allowNull = $this->allowNull($field);
        $default = $this->value($field);
        $comment = $this->comment($field);

        $this->text = "\$table->{$type}('{$name}'{$length}){$allowNull}{$default}{$comment};";
    }

    function allowNull($field)
    {
        if (isset($field->allowNull)) {
            if ($field->allowNull) {
                return '->nullable()';
            }
        }
        return '';
    }

    function comment($field)
    {
        if (isset($field->comment)) {
            if ($field->comment) {
                return "->comment('{$field->comment}')";
            }
        }
        return '';
    }

    function length($field)
    {
        if (isset($field->length)) {
            if ($field->length) {
                return ", {$field->length}";
            }
        }
        return '';
    }

    function value($field)
    {
        if (isset($field->value)) {
            if (is_numeric($field->value)) {
                return "->default({$field->value})";
            }

            if ($field->value) {
                $hasQuote = false;
                if (preg_match('/^".*"$/', $field->value)) {
                    $hasQuote = true;
                }
                if (preg_match("/^'.*'$/", $field->value)) {
                    $hasQuote = true;
                }

                if ($hasQuote) {
                    return "->default({$field->value})";
                }

                $value = $this->addSlash($field->value);
                return "->default('{$value}')";
            }
        }
        return '';
    }

    /**
     * convert ' to \'
     */
    function addSlash($string)
    {
        $stringList = [];
        $list = explode("\\'", $string);
        foreach ($list as $item) {
            $stringList[] = implode("\\'", explode("'", $item));
        }
        return implode("\\'", $stringList);
    }

}