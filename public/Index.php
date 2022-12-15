<?php

$_PROJECTROOT = dirname(__DIR__, 1);
$_DEFINED_ROUTES = [];

function frameworkUse($file)
{
    require_once($_PROJECTROOT . "/framework/" . $file . ".php");
}

require('../framework/Route.php');

require('../framework/Config.php');
require('../framework/HttpRequest.php');

Request::requestStart();
