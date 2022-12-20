<?php

namespace Framework;

class FrameworkCore
{
    private string $projectRoot;
    private array $definedRoutes;
    private array $allowedPathRequest;
    private array $request;
    private string $requestPath;
    private string $requestSource;

    public function __construct()
    {  
        $this->projectRoot = dirname(__DIR__, 1);
        $this->request = $_REQUEST;
        $this->allowedPathRequest = ['view', 'api'];

        if (!$this->getPathInfo()) {
            return;
        }

        $this->folderRequire("framework/utils");
        $this->folderRequire("framework/class");
        $this->folderRequire("app/controller");
        $this->folderRequire("app/model");
        $this->exceptionHandling();

        $this->initiateRoutes();

        $this->validateRequest();

        $this->requireRoute();
    }

    private function exceptionHandling()
    {
        require_once("ExceptionTreat.php");
    }

    private function getPathInfo()
    {   
        if (!isset($_SERVER['PATH_INFO'])) {
            $this->requestPath = "view";
            $this->requestSource = "Main";
            return true;
        }

        $pathInfo = explode('/', $_SERVER['PATH_INFO']);

        if (count($pathInfo) < 3) {
            trigger_error("Bad Request", E_USER_ERROR);
            return false;
        }
        $this->requestPath = $pathInfo[1];
        $this->requestSource = $pathInfo[2];

        return true;
    }

    private function initiateRoutes()
    {
        require_once("{$this->projectRoot}/app/Routes.php");

        $this->definedRoutes = $GLOBALS['_DEFINED_ROUTES'];
        unset($GLOBALS['_DEFINED_ROUTES']);
    }

    private function validateRequest()
    {
        if (!in_array($this->requestPath, $this->allowedPathRequest)) {
            trigger_error("Path not found", E_USER_ERROR);
        }

        if ($this->requestPath == 'view') {
            if (!file_exists("{$this->projectRoot}/app/view/{$this->requestSource}.php")) {
                trigger_error("View not found", E_USER_ERROR);
            }
            return;
        }

        if (!in_array($this->requestSource, array_keys($this->definedRoutes))) {
            trigger_error("Source not found", E_USER_ERROR);
        }
    }

    private function requireRoute()
    {
        if ($this->requestPath == 'view') {
            require_once("{$this->projectRoot}/app/view/{$this->requestSource}.php");
            return;
        }

        if (gettype($this->definedRoutes[$this->requestSource]['routeAction']) == 'object') {
            $this->definedRoutes[$this->requestSource]['routeAction']($this->request);
            return;
        }

        if (gettype($this->definedRoutes[$this->requestSource]['routeAction']) == 'array') {

            $controllerClass = new $this->definedRoutes[$this->requestSource]['routeAction'][0]($this->request);
            $method = $this->definedRoutes[$this->requestSource]['routeAction'][1];

            call_user_func_array([$controllerClass, $method], [$this->request]);
            return;
        }
        trigger_error("invalid route sintax", E_USER_ERROR);
    }

    private function folderRequire($folder)
    {
        $dir = new \DirectoryIterator("{$this->projectRoot}/{$folder}");

        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                require_once("{$this->projectRoot}/{$folder}/" . $fileinfo->getFilename());
            }
        }
    }
}
