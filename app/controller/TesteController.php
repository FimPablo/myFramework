<?php

namespace App\Controllers;

use Framework\Controller;
use App\Models\ProductModel;

class TesteController extends Controller
{
    public function testeMetodo()
    {
        $product = new ProductModel();

        echo "<pre>";
        
        var_dump($product->getProductById(10));

        var_dump($product->setValueById(1, 50.10));

        var_dump($product->setNaneById(1, 'TILAPIA'));

        var_dump($product->deleteProduct(11));
    }
}
