<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['quantity'];
    function relationshipwithProduct(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    function relationshipwithColor(){
        return $this->hasOne(Color::class, 'id', 'color_id');
    }

    function relationshipwithSize(){
        return $this->hasOne(Size::class, 'id', 'size_id');
    }
    function relationshipwithUser(){
        return $this->hasOne(User::class, 'id', 'vendor_id');
    }
}
