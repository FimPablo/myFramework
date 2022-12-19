<?php

namespace Framework;

class Column
{
    public $value;
    protected $name;

    public function __construct(string $name, $owner) {
        $this->name = "{$owner}.{$name}";
    }

    public function val()
    {
        return $this->value;
    }

    public function name()
    {
        return $this->name;
    }
}