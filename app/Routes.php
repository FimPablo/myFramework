<?php

use Framework\Route;

use App\Controllers\StoreController;

Route::get('getProduct', [StoreController::class, 'getProductById']);
