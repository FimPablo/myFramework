<?php

class Config
{
    public static function get(string $key)
    {
        $configFile = file_get_contents("../config.json", true);

        $configStructure = json_decode($configFile, true);

        return $configStructure[$key];
    }
}