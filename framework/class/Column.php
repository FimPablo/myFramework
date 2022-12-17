<?php

namespace Framework;

class Column
{
    public $value;
    public $name;

    public function __construct(string $name, $owner) {
        $this->name = "{$owner}.{$name}";
    }
}