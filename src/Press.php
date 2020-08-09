<?php


namespace hala\Press;


class Press
{

    private $fields = [];

    public function configuredNotPublish()
    {
        return is_null(config('press'));
    }

    public function driver()
    {
        $driver = ucfirst(config('press.driver'));

        $class = 'hala\\Press\\Drivers\\' . $driver . 'Driver';

        return new $class;
    }

    public function fields(array $fields)
    {
        $this->fields = array_merge($this->fields, $fields);
    }

    public function getFields()
    {
        return $this->fields;
    }
}