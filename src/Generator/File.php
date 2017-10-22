<?php

namespace GooGee\Entity\Generator;


class File
{
    protected $file;

    function __construct($file)
    {
        $this->file = $file;
    }

    public function save($content)
    {
        $file = $this->file;
        if (file_exists($file)) {
            $old = $file . '.txt';
            if (file_exists($old)) {
                //
            } else {
                rename($file, $old);
            }
        }
        file_put_contents($file, $content);
    }

}