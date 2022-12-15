<?php

require 'controller/TesteController.php';

use App\Controllers\TesteController;

Route::get('saaaaass', function () {
    echo ('teste');
    var_dump($_REQUEST);
});

Route::get('bbb', [TesteController::class, 'testeMetodo']);
