<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_details extends Model
{
    use HasFactory;
    function relationshipwithProduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
