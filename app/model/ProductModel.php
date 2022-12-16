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
            ->take(1)
            ->before(10)
            ->get();
    }

    public function setValueById(int $id, float $value)
    {
        return $this
        ->where([
            ['id', '=', $id]
        ])
        ->set([
            ['price', $value]
        ]);
    }

    public function setNaneById(int $id, string $name)
    {
        return $this
        ->where([
            ['id', '=', $id]
        ])
        ->set([
            ['name', $name]
        ]);
    }

    public function deleteProduct(int $id)
    {
        return $this
        ->where([
            ['id', '=', $id]
        ])
        ->delete();
    }
}
