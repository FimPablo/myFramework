<?php

class Route
{
    public static function get(string $routeName, $routeAction)
    {
        return self::defaultRequest($routeName, $routeAction, 'get');
    }

    public static function post(string $routeName, $routeAction)
    {
        return self::defaultRequest($routeName, $routeAction, 'post');
    }

    public static function delete(string $routeName, $routeAction)
    {
        return self::defaultRequest($routeName, $routeAction, 'delete');
    }

    private static function defaultRequest($routeName, $routeAction, $method)
    {
        $GLOBALS['_DEFINED_ROUTES'][$routeName] = [
            'method' => $method,
            'routeAction' => $routeAction
        ];

        return self::class;
    }
}
