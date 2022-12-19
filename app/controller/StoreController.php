<?php

namespace App\Controllers;

use App\Models\ProductModel;
use Framework\Controller;

use function Framework\Utils\response;

class StoreController extends Controller
{
    public function getProductById()
    {
        $product = new ProductModel();

        response($product->getProductById($this->request['id']));
    }
}