<?php

use function Framework\Utils\response;

function exception_handler($exception) {
    response([
        "houveErro" => true,
        "mensagem" => $exception->getMessage()
    ]);
}
set_exception_handler('exception_handler');