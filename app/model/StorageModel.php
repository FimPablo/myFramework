<?php

namespace App\Models;

use Framework\Model;

class StorageModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->table = "Storage";
        $this
            ->defineColumn('id')
            ->defineColumn('productId')
            ->defineColumn('quantity');
    }

    public function changeProductQuantity($productId, $quantity)
    {
        $this
        ->where([
            [$this->productId, '=', $productId->value]
        ])
        ->get();

        if ($this->productId->value == null) {
            $this->productId->value = (int) $productId->value;
            $this->quantity->value = $quantity;

            $this->new();
            return $this->serialize();
        }

        return $this->where([
            [$this->productId, '=', (int)$productId->value]
        ])->set([
            [$this->quantity, $this->quantity->value + ($quantity)]
        ]);
    }
}
