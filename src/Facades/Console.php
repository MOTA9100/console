<?php

namespace Mota\Console\Facades;

use Illuminate\Support\Facades\Facade;

class Console extends Facade {

    protected static function getFacadeAccessor() {

        return 'mota_console';
    }
}