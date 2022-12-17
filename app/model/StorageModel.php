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
}