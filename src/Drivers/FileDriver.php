<?php


namespace hala\Press\Drivers;


use hala\Press\Exceptions\FileDriverExceptions;
use Illuminate\Support\Facades\File;

class FileDriver extends Driver
{

    public function fetchPost()
    {
        $files = File::files(config('press.path'));

        foreach ($files as $file) {
            $this->parse($file->getPathname(),$file->getFilename()) ;
        }
        return $this->posts;
    }

    protected function validateSource()
    {
        if (!File::exists($this->config['path'])) {
            throw  new FileDriverExceptions('Ops File Not exist ');
        }
    }
}