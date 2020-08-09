<?php

namespace hala\Press;

use Carbon\Carbon;
use hala\Press\Fields\Date;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class FileParser
{

    public $data;
    public $fileName;
    public $rawData;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
        $this->handle();
        $this->explodeData();
        $this->processData();
    }

    public function getData()
    {
        return $this->data;
    }

    public function getRawData()
    {
        return $this->rawData;
    }

    public function handle()
    {
        preg_match('/^\-{3}(.*?)\-{3}(.*)/s',
            File::exists($this->fileName) ? File::get($this->fileName) : $this->fileName,
            $this->rawData);

    }

    public function explodeData()
    {
        foreach (explode("\n", trim($this->rawData[1])) as $field) {
            preg_match('/(.*):\s?(.*)/', $field, $array);
            $this->data[$array[1]] = $array[2];
        }

        $this->data['body'] = trim($this->rawData[2]);
    }

    public function processData()
    {
        foreach ($this->data as $field => $value) {
            $class = $this->getField(ucfirst($field));

            if (!class_exists($class) && !method_exists($class, 'process')) {
                $class = 'hala\\Press\\Fields\\Extra';
            }

            $this->data = array_merge($this->data, $class::process($field, $value, $this->data));
        }


    }


    private function getField($field)
    {
        foreach (Press::getFeilds() as $item) {
            $class = new ReflectionClass($item);

            if ($field->getShortName() === $class) {
                $class->getName();
            }
        }
    }


}