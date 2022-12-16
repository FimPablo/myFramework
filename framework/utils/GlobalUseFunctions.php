<?php

namespace Framework\Utils;

function response($response)
{
    if(gettype($response) == 'string')
    {
        exit($response);
    }

    exit(json_encode($response));
}