<?php

namespace Framework\Utils;

function response($response)
{
    
    if(gettype($response) == 'string')
    {
        header('Content-Type: text/plan; charset=utf-8');
        exit($response);
    }
    
    header('Content-Type: text/json; charset=utf-8');
    exit(json_encode($response));
}