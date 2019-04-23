<?php

namespace Mota\Console\Request;

use Mota\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class Request extends Command {

    protected $name = 'mota:request';

    protected $description = 'make mota request class';

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle() {

        $this->makeRequest();
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function makeRequest() {

        $requestsDir = app_path('Http/Requests');

        if (!is_dir($requestsDir))
            $this->makeDir($requestsDir);

        $request = $this->getClassName();

        $requestArray = explode('/', $request);
        $requestClassName = end($requestArray);
        unset($requestArray[(count($requestArray) - 1)]);

        $namespace = 'App\Http\Requests';

        foreach ($requestArray as $item) {

            $requestsDir .= '/' . $item;

            if (!is_dir($requestsDir))
                $this->makeDir($requestsDir);

            $namespace .= "\\$item";
        }

        $file = app_path("Http/Requests/{$request}.php");

        if($this->alreadyExists($file)) {

            $this->line("<error>{$request} request already exists!</error> ");

            return;
        }

        $stub = $this->getStub('Request');

        $this->putFile($file, $stub, $namespace, $requestClassName);

        $this->line('<info>mota request creared!</info> ', '', $file);
    }

    protected function replacements($stub, $namespace, $class) {

        $stub = str_replace(
            ['DummyNameSpace', 'DummyClass'],
            [$namespace, $class],
            $stub
        );

        return $stub;
    }

    protected function putFile($file, $stub, $namespace, $class) {

        $stub = $this->replacements($stub, $namespace, $class);

        $this->files->put($file, $stub);
    }

    protected function getClassName() {

        return trim($this->argument('ClassName'));
    }

    protected function getArguments() {

        return [
            ['ClassName', InputArgument::REQUIRED, 'The name of request class'],
        ];
    }
}