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

        $product->getProductById(10);

        $product->setValueById(1, 50.10);

        $product->setNameById(1, 'TILAPIA');

        $product->deleteProduct(11);

        $product->getProductQuantityById(11);

        $product->newProduct([
            'name' => 'salmão', 
            'price' => 90.40
        ]);
    }
}
