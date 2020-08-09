<?php


namespace hala\Press\Fields;


abstract class FieldContract
{
    public static function process($fieldtype, $value, $data)
    {
        return [
            $fieldtype => $value
        ];
    }
}