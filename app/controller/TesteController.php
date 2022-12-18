<?php

namespace App\Controllers;

use Framework\Controller;
use App\Models\ProductModel;
use App\Models\StorageModel;

class TesteController extends Controller
{
    public function testeMetodo()
    {
        $product = new ProductModel();
        $storage = new StorageModel();

        echo "<pre>";

        var_dump($product->getProductById(1)[0]->serialize());

        var_dump($storage->changeProductQuantity($product->id, 1));

        var_dump($product->getProductQuantityById(1)[0]->serialize());

        //var_dump($storage->addProductQuantity($product->id, 1));

        //var_dump($product->getProductQuantityById(1)[0]->serialize());
        //$product->setValueById(1, 50.10);

        //$product->setNameById(1, 'TILAPIA');

        //$product->deleteProduct(11);

        

        // $product->newProduct([
        //     'name' => 'salmão', 
        //     'price' => 90.40
        // ]);
    }
}
