<?php

namespace App\File;


class Upload
{

    private $name;

    private $extension;

    private $tmpName;

    private $type;

    private $error;

    private $size;

    private $duplicates = 0;


    public function __construct($file)
    {

        $this->type      = $file['type'];
        $this->tmpName   = $file['tmp_name'];
        $this->error     = $file['error'];
        $this->size      = $file['size'];

        $info = pathinfo($file['name']);

        $this->name = $info['filename'];
        $this->extension = $info['extension'];
    }

    public function setName()
    {

        $this->name = $name;
    }

    public function gerarNovoNome()
    {

        $this->name =  $this->name;
    }

    public function getBasename()
    {

        $extension = strlen($this->extension) ? '.' . $this->extension : '';

        $duplicates = $this->duplicates > 0 ? '-' . $this->duplicates : '';

        return $this->name . $duplicates . $extension;
    }

    private function getPossivelBasename($dir, $overwrite)
    {

        if ($overwrite) return $this->getBasename();

        $basename = $this->getBasename();

        if (!file_exists($dir . '/' . $basename)) {
            return $basename;
        } else {

            $this->duplicates++;
            return $this->getPossivelBasename($dir, $overwrite);
        }
    }

    public function upload($dir, $overwrite = true)
    {


        if ($this->error != 0) return false;

        $path = $dir . '/' . $this->getPossivelBasename($dir, $overwrite);

        return move_uploaded_file($this->tmpName, $path);
    }

    public static function createMultpleUpload($files)
    {

        $uploads = [];

        foreach ($files['name'] as $key => $value) {
            $file = [
                'name'     => $files['name'][$key],
                'type'     => $files['type'][$key],
                'tmp_name' => $files['tmp_name'][$key],
                'error'    => $files['error'][$key],
                'size'     => $files['size'][$key]
            ];

            $uploads[] = new Upload($file);
        }

        return $uploads;
    }
}
