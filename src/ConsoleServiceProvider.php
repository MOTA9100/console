<?php

namespace Mota\Console;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider {

    protected $commands = [
        'Mota\Console\Request\Request'
    ];

    public function boot() {

    }


    public function register() {

        $this->commands($this->commands);

        $this->app->singleton('mota_console', function () {
            return true;
        });
    }
}