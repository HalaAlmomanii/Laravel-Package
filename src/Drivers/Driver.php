<?php


namespace hala\Press\Drivers;


use hala\Press\FileParser;
use Illuminate\Support\Str;

abstract class Driver
{
    protected $posts;

    protected $config;

    public function __construct()
    {
        $this->setConfig();

        $this->validateSource();

    }

    public abstract function fetchPost();

    protected function setConfig()
    {
        $this->config = config('press.' . config('press.driver'));

    }

    protected function validateSource()
    {
        return true;
    }

    protected function parse($content, $fileName)
    {
        $this->posts[] = array_merge((new FileParser($content))->getData(),
            ['identifier' => Str::random()]);
    }
}