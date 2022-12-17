<?php

namespace App\Models;

use Framework\Model;

class ProductModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->table = "Products";
        $this
        ->defineColumn('id')
        ->defineColumn('name')
        ->defineColumn('price');
    }

    public function getProductById($id)
    {
        return $this
            ->where([[$this->id, '=', $id]])
            ->take(1)
            ->before(10)
            ->get();
    }

    public function setValueById(int $id, float $value)
    {
        return $this
        ->where([
            [$this->id, '=', $id]
        ])
        ->set([
            [$this->name, $value]
        ]);
    }

    public function setNameById(int $id, string $name)
    {
        return $this
        ->where([
            [$this->id, '=', $id]
        ])
        ->set([
            [$this->name, $name]
        ]);
    }

    public function deleteProduct(int $id)
    {
        return $this
        ->where([
            [$this->id, '=', $id]
        ])
        ->delete();
    }

    public function getProductQuantityById(int $id)
    {
        $storage = new StorageModel();

        return $this
        ->where([
            [$this->id, '=', $id],
        ])
        ->with($storage, [
            [$this->id, "=", $storage->id]
        ])
        ->get();
    }

    public function newProduct(array $productInfo)
    {
        $this->price->value = $productInfo['price'];
        $this->name->value = $productInfo['name'];

        return $this->new();
    }
}
