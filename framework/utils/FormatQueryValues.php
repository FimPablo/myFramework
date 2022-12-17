<?php

namespace Framework;

class FormatQueryValues
{
    public static function format($value)
    {
        $formatTypes = [
            'string' => "formatString",
            'double' => "formatFloat"
        ];

        $valueType = gettype($value);

        if (!isset($formatTypes[$valueType])) {
            return $value;
        }

        $function = $formatTypes[$valueType];

        return SELF::$function($value);
    }

    private function formatString(string $value)
    {
        return "'{$value}'";
    }

    private function formatFloat(float $value)
    {
        $integerAndDecimal = explode('.', (string)$value);

        return $value;
    }
}
