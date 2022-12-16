<?php

namespace App\Models;

use Framework\Model;

class ProductModel extends Model
{
    public int $id;
    public string $name;
    public float $value;
    public int $quantity;

    public function __construct()
    {
        $this->table = "Products";
    }

    public function getProductById($id)
    {
        return $this
            ->where([['id', '=', $id]])
            ->get();
    }

    public function setValueById(int $id, float $value)
    {
        return $this
        ->where([
            ['id', '=', $id]
        ])
        ->set([
            ['value', $value]
        ]);
    }
}
