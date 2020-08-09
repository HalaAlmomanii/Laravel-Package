<?php


namespace hala\Press\Fields;

use hala\Press\MarkdownParser;

class Title extends FieldContract
{

    public static function process($type, $value,$data)
    {
        return [
            $type => MarkdownParser::parse($value)
        ];
    }
}