<?php

class Request
{
    public static function requestStart()
    {
        $allowedPathRequest = Config::get('allowedPathRequest');

        $request = $_REQUEST;
        $pathInfo = explode('/', $_SERVER['PATH_INFO']);

        if (!in_array($pathInfo[1], $allowedPathRequest)) {
            trigger_error("Path not found", E_USER_ERROR);
        }

        require_once('../app/Routes.php');

        var_dump( $GLOBALS);

        if(!in_array($pathInfo[2], $_DEFINED_ROUTES))
        {

        }
    }
}
