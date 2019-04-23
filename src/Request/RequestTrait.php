<?php

namespace Mota\Console\Request;

use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\ParameterBag;

trait RequestTrait {

    private $req;

    public function __construct(ParameterBag $request) {

        $this->req = $request;
    }

    public function getDot(string $key) {

        $paramerers = Arr::dot($this->req->all());

        return $paramerers[$key];
    }
}