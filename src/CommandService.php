<?php

namespace GooGee\Entity;

use Illuminate\Support\Facades\Artisan;

class CommandService
{

    public function run(string $command)
    {
        Artisan::call($command);
        return Artisan::output();
    }

}
