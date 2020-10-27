<?php

namespace GooGee\Entity;

use Carbon\Carbon;

class FileService
{
    const Folder = 'entity';
    const File = 'entity.json';

    static function deploy(array $map)
    {
        foreach ($map as $file => $code) {
            $path = base_path($file);
            $info = pathinfo($path);
            if (!is_dir($info['dirname'])) {
                mkdir($info['dirname'], 0755, true);
            }
            file_put_contents($path, $code);
        }
    }

    private static function getFile()
    {
        $data = '';
        if (\Storage::exists(self::File)) {
            $data = \Storage::get(self::File);
        }
        return $data;
    }

    static function load()
    {
        return self::getFile();
    }

    static function save(string $text)
    {
        $data = self::getFile();
        if ($data === $text) {
            return;
        }

        $path = self::Folder . '/' . Carbon::now() . '.json';
        $valid = str_replace(':', '_', $path);
        \Storage::put($valid, $data);
        \Storage::put(self::File, $text);
    }

}