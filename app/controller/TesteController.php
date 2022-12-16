<?php

namespace App\Controllers;

use Framework\Controller;
use App\Models\ProductModel;

class TesteController extends Controller
{
    public function testeMetodo()
    {
        $product = new ProductModel();
        
        var_dump($product->getProductById(10));

        var_dump($product->setValueById('tilapia', 50.10));
    }
}
