<?php

namespace Framework;

class Controller
{
    protected array $request;

    public function __construct($request) {
        $this->request = $request;
    }
}
