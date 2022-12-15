<?php

class Request
{
    public static function requestStart()
    {
        $allowedPathRequest = Config::get('allowedPathRequest');

        require_once('../app/Routes.php');
        $definedRoutes = $GLOBALS['_DEFINED_ROUTES'];

        $request = $_REQUEST;
        $pathInfo = explode('/', $_SERVER['PATH_INFO']);

        if (!in_array($pathInfo[1], $allowedPathRequest)) {
            trigger_error("Path not found", E_USER_ERROR);
        }

        if (!in_array($pathInfo[2], array_keys($definedRoutes))) {
            trigger_error("Source not found", E_USER_ERROR);
        }

        if (gettype($definedRoutes[$pathInfo[2]]['routeAction']) == 'object') {
            $definedRoutes[$pathInfo[2]]['routeAction']($request);
            return;
        }

        if (!gettype($definedRoutes[$pathInfo[2]]['routeAction']) == 'array') {
            trigger_error("invalid route sintax", E_USER_ERROR);
            return;
        }

        $controllerClass = new $definedRoutes[$pathInfo[2]]['routeAction'][0]($request);

        $method = $definedRoutes[$pathInfo[2]]['routeAction'][1];

        call_user_func_array([$controllerClass, $method], [$request]);
    }
}
